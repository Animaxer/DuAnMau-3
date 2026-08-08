<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Ingredient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if(count($cart) == 0) {
            return redirect()->route('cart.index')->with('success', 'Giỏ hàng trống!');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);
        if (count($cart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        DB::beginTransaction();
        try {
            // Recalculate total required ingredients just to be safe before saving
            $totalRequired = [];
            $totalPrice = 0;

            foreach ($cart as $id => $item) {
                $productId = $item['product_id'] ?? explode('_', $id)[0];
                $product = Product::with('ingredients')->findOrFail($productId);
                $totalPrice += $item['price'] * $item['quantity'];

                foreach ($product->ingredients as $ingredient) {
                    if (!isset($totalRequired[$ingredient->id])) {
                        $totalRequired[$ingredient->id] = 0;
                    }
                    $totalRequired[$ingredient->id] += $ingredient->pivot->quantity_required * $item['quantity'];
                }
            }

            // Check stock and decrement
            foreach ($totalRequired as $ingredientId => $qty) {
                $ingredient = Ingredient::lockForUpdate()->find($ingredientId);
                if (!$ingredient || $ingredient->stock < $qty) {
                    throw new \Exception('Không đủ nguyên liệu: ' . ($ingredient ? $ingredient->name : 'Không xác định'));
                }
                $ingredient->stock -= $qty;
                $ingredient->save();
            }

            // Create Order
            $order = Order::create([
                'user_id' => Auth::id() ?? 1, // Fallback if not logged in but it requires auth route
                'total_price' => $totalPrice,
                'status' => 0
            ]);

            // Create Order Details
            foreach ($cart as $id => $item) {
                $productId = $item['product_id'] ?? explode('_', $id)[0];
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            DB::commit();

            session()->forget('cart');
            return redirect()->route('home')->with('success', 'Đặt hàng thành công! Đơn hàng của bạn đang được xử lý.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }
}
