<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'total'));
    }

    private function checkIngredientsAvailability($proposedCart)
    {
        $totalRequired = [];
        foreach ($proposedCart as $cartKey => $item) {
            $productId = $item['product_id'] ?? explode('_', $cartKey)[0];
            $product = Product::with('ingredients')->find($productId);
            if ($product) {
                foreach ($product->ingredients as $ingredient) {
                    if (!isset($totalRequired[$ingredient->id])) {
                        $totalRequired[$ingredient->id] = 0;
                    }
                    $totalRequired[$ingredient->id] += $ingredient->pivot->quantity_required * $item['quantity'];
                }
            }
        }

        $insufficientIngredients = [];
        foreach ($totalRequired as $ingredientId => $qty) {
            $ingredient = \App\Models\Ingredient::find($ingredientId);
            if ($ingredient && $ingredient->stock < $qty) {
                $insufficientIngredients[] = $ingredient->name;
            }
        }

        return $insufficientIngredients;
    }

    public function add(Request $request)
    {
        $product_id = $request->input('product_id');
        $product = Product::findOrFail($product_id);

        $quantity = (int)$request->input('quantity', 1);
        $size = $request->input('size', 'S');
        $cartKey = $product_id . '_' . $size;

        $price = $product->price;
        if ($size == 'M') $price += 5000;
        if ($size == 'L') $price += 10000;

        $cart = session()->get('cart', []);
        $proposedCart = $cart;

        if (isset($proposedCart[$cartKey])) {
            $proposedCart[$cartKey]['quantity'] += $quantity;
        } else {
            $proposedCart[$cartKey] = [
                "product_id" => $product_id,
                "name" => $product->name . ' (Size ' . $size . ')',
                "quantity" => $quantity,
                "price" => $price,
                "image_url" => $product->image_url,
                "size" => $size
            ];
        }

        $insufficient = $this->checkIngredientsAvailability($proposedCart);
        if (count($insufficient) > 0) {
            return redirect()->back()->with('error', 'Không đủ nguyên liệu: ' . implode(', ', $insufficient));
        }

        session()->put('cart', $proposedCart);
        return redirect()->back()->with('success', 'Đã thêm ' . $product->name . ' vào giỏ hàng!');
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $proposedCart = $cart;
            $proposedCart[$request->id]["quantity"] = $request->quantity;

            $insufficient = $this->checkIngredientsAvailability($proposedCart);
            if (count($insufficient) > 0) {
                return redirect()->back()->with('error', 'Không đủ nguyên liệu: ' . implode(', ', $insufficient));
            }

            session()->put('cart', $proposedCart);
            return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật!');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }
    }
}
