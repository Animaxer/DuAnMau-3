<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@freshie.com',
            'password' => Hash::make('password'),
            'role' => 1,
        ]);

        // Customer user
        User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@freshie.com',
            'password' => Hash::make('password'),
            'role' => 0,
        ]);

        // Categories
        $cat1 = Category::create(['name' => 'Cà phê', 'description' => 'Cà phê truyền thống và pha máy']);
        $cat2 = Category::create(['name' => 'Trà trái cây', 'description' => 'Thanh mát, tươi mới']);
        $cat3 = Category::create(['name' => 'Đá xay', 'description' => 'Giải nhiệt mùa hè']);

        // Ingredients
        $ingCoffee = \App\Models\Ingredient::create(['name' => 'Cà phê hạt', 'stock' => 1000, 'unit' => 'gram']);
        $ingFreshMilk = \App\Models\Ingredient::create(['name' => 'Sữa tươi', 'stock' => 2000, 'unit' => 'ml']);
        $ingCondMilk = \App\Models\Ingredient::create(['name' => 'Sữa đặc', 'stock' => 1000, 'unit' => 'ml']);
        $ingBlackTea = \App\Models\Ingredient::create(['name' => 'Trà đen', 'stock' => 500, 'unit' => 'gram']);
        $ingMatcha = \App\Models\Ingredient::create(['name' => 'Bột Matcha', 'stock' => 500, 'unit' => 'gram']);
        $ingPeach = \App\Models\Ingredient::create(['name' => 'Đào ngâm', 'stock' => 50, 'unit' => 'miếng']);
        $ingLychee = \App\Models\Ingredient::create(['name' => 'Vải ngâm', 'stock' => 50, 'unit' => 'quả']);
        $ingSyrup = \App\Models\Ingredient::create(['name' => 'Đường nước', 'stock' => 1000, 'unit' => 'ml']);

        // Additional Ingredients
        $ingOolongTea = \App\Models\Ingredient::create(['name' => 'Trà Oolong', 'stock' => 500, 'unit' => 'gram']);
        $ingMacchiato = \App\Models\Ingredient::create(['name' => 'Kem Macchiato', 'stock' => 1000, 'unit' => 'ml']);
        $ingCacao = \App\Models\Ingredient::create(['name' => 'Bột Cacao', 'stock' => 500, 'unit' => 'gram']);
        $ingBoba = \App\Models\Ingredient::create(['name' => 'Trân châu đen', 'stock' => 2000, 'unit' => 'gram']);

        // Products
        $p1 = Product::create(['category_id' => $cat1->id, 'name' => 'Bạc xỉu', 'description' => 'Bạc xỉu thơm béo', 'price' => 35000, 'image_url' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=500&auto=format&fit=crop&q=60']);
        $p1->ingredients()->attach($ingCoffee->id, ['quantity_required' => 20]);
        $p1->ingredients()->attach($ingFreshMilk->id, ['quantity_required' => 50]);
        $p1->ingredients()->attach($ingCondMilk->id, ['quantity_required' => 30]);

        $p2 = Product::create(['category_id' => $cat1->id, 'name' => 'Cà phê sữa đá', 'description' => 'Cà phê Việt Nam', 'price' => 29000, 'image_url' => 'https://images.unsplash.com/photo-1559525839-b184a4d698c7?w=500&auto=format&fit=crop&q=60']);
        $p2->ingredients()->attach($ingCoffee->id, ['quantity_required' => 25]);
        $p2->ingredients()->attach($ingCondMilk->id, ['quantity_required' => 40]);
        
        $p3 = Product::create(['category_id' => $cat2->id, 'name' => 'Trà đào cam sả', 'description' => 'Signature Freshie', 'price' => 45000, 'image_url' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=500&auto=format&fit=crop&q=60']);
        $p3->ingredients()->attach($ingBlackTea->id, ['quantity_required' => 10]);
        $p3->ingredients()->attach($ingPeach->id, ['quantity_required' => 3]);
        $p3->ingredients()->attach($ingSyrup->id, ['quantity_required' => 20]);

        $p4 = Product::create(['category_id' => $cat2->id, 'name' => 'Trà vải', 'description' => 'Trà vải lài thanh mát', 'price' => 45000, 'image_url' => 'https://plus.unsplash.com/premium_photo-1675715924046-24e680a65dc2?w=500&auto=format&fit=crop&q=60']);
        $p4->ingredients()->attach($ingBlackTea->id, ['quantity_required' => 10]);
        $p4->ingredients()->attach($ingLychee->id, ['quantity_required' => 4]);
        $p4->ingredients()->attach($ingSyrup->id, ['quantity_required' => 20]);
        
        $p5 = Product::create(['category_id' => $cat3->id, 'name' => 'Matcha đá xay', 'description' => 'Trà xanh Nhật Bản đá xay', 'price' => 55000, 'image_url' => 'https://images.unsplash.com/photo-1515823662972-da6a2e4d3002?w=500&auto=format&fit=crop&q=60']);
        $p5->ingredients()->attach($ingMatcha->id, ['quantity_required' => 15]);
        $p5->ingredients()->attach($ingFreshMilk->id, ['quantity_required' => 60]);

        // Thêm sản phẩm mới
        $p6 = Product::create(['category_id' => $cat1->id, 'name' => 'Cacao Sữa Đá', 'description' => 'Đậm đà hương vị cacao nguyên bản', 'price' => 35000, 'image_url' => 'https://images.unsplash.com/photo-1511920170033-f8396924c348?w=500&auto=format&fit=crop&q=60']);
        $p6->ingredients()->attach($ingCacao->id, ['quantity_required' => 20]);
        $p6->ingredients()->attach($ingFreshMilk->id, ['quantity_required' => 40]);
        $p6->ingredients()->attach($ingCondMilk->id, ['quantity_required' => 20]);

        $p7 = Product::create(['category_id' => $cat2->id, 'name' => 'Trà Sữa Trân Châu', 'description' => 'Hương vị trà đen truyền thống với trân châu dẻo dai', 'price' => 39000, 'image_url' => 'https://images.unsplash.com/photo-1558160074-4d7d8bdf4256?w=500&auto=format&fit=crop&q=60']);
        $p7->ingredients()->attach($ingBlackTea->id, ['quantity_required' => 15]);
        $p7->ingredients()->attach($ingCondMilk->id, ['quantity_required' => 20]);
        $p7->ingredients()->attach($ingFreshMilk->id, ['quantity_required' => 30]);
        $p7->ingredients()->attach($ingBoba->id, ['quantity_required' => 50]);

        $p8 = Product::create(['category_id' => $cat2->id, 'name' => 'Trà Oolong Macchiato', 'description' => 'Trà Oolong thanh tao kết hợp lớp kem Macchiato béo ngậy', 'price' => 45000, 'image_url' => 'https://images.unsplash.com/photo-1576092762791-dd9e2220abd4?w=500&auto=format&fit=crop&q=60']);
        $p8->ingredients()->attach($ingOolongTea->id, ['quantity_required' => 12]);
        $p8->ingredients()->attach($ingMacchiato->id, ['quantity_required' => 40]);
        $p8->ingredients()->attach($ingSyrup->id, ['quantity_required' => 15]);

        $p9 = Product::create(['category_id' => $cat1->id, 'name' => 'Cà phê đen đá', 'description' => 'Cà phê đen đá đậm chất pha phin', 'price' => 25000, 'image_url' => 'https://images.unsplash.com/photo-1553177595-4de2bb0842b9?w=500&auto=format&fit=crop&q=60']);
        $p9->ingredients()->attach($ingCoffee->id, ['quantity_required' => 30]);
        $p9->ingredients()->attach($ingSyrup->id, ['quantity_required' => 10]);
    }
}
