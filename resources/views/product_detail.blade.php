<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - Freshie</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .header-blur { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    </style>
</head>
<body class="bg-warm-white text-text-primary antialiased flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-deep-navy/95 header-blur sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center space-x-3">
                <span class="text-2xl font-black text-white tracking-tight">freshie<span class="text-aquamarine">.</span></span>
            </a>
            <div class="flex items-center space-x-3">
                <a href="{{ route('cart.index') }}" class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-white/10 hover:bg-sky-blue/20 transition group">
                    <svg class="w-5 h-5 text-white group-hover:text-sky-blue transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    @if(count((array) session('cart')) > 0)
                        <span class="absolute -top-1 -right-1 bg-blush text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center">
                            {{ count((array) session('cart')) }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </header>

    @if(session('error'))
        <div class="bg-blush text-white px-4 py-3 shadow-md border border-red-200">
            <div class="container mx-auto text-center font-bold">
                ⚠️ {{ session('error') }}
            </div>
        </div>
    @endif
    @if(session('success'))
        <div class="bg-aquamarine text-deep-navy px-4 py-3 shadow-md border border-green-200">
            <div class="container mx-auto text-center font-bold">
                ✓ {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow py-12 px-6">
        <div class="container mx-auto max-w-5xl">
            <!-- Breadcrumbs -->
            <div class="text-sm text-text-secondary mb-8">
                <a href="/" class="hover:text-ocean-blue">Trang chủ</a>
                <span class="mx-2">/</span>
                <span class="text-deep-navy font-bold">{{ $product->name }}</span>
            </div>

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-light-border flex flex-col md:flex-row">
                <!-- Image -->
                <div class="w-full md:w-1/2 h-96 md:h-auto relative">
                    <img src="{{ $product->image_url ?: 'https://placehold.co/500x500?text=Freshie' }}" onerror="this.onerror=null; this.src='https://placehold.co/500x500?text=Freshie';" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    <div class="absolute top-4 left-4">
                        <span class="bg-deep-navy/80 text-sky-blue text-xs font-bold px-4 py-1.5 rounded-full backdrop-blur-sm shadow-lg">
                            {{ $product->category->name ?? 'Đồ uống' }}
                        </span>
                    </div>
                </div>

                <!-- Info -->
                <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col">
                    <h1 class="text-3xl md:text-4xl font-black text-deep-navy mb-2">{{ $product->name }}</h1>
                    
                    <!-- Rating Stars (Static/Demo) -->
                    <div class="flex items-center space-x-1 mb-4">
                        <div class="flex text-amber-400">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <span class="text-sm font-medium text-text-secondary">(4.0) 128 Đánh giá</span>
                    </div>
                    
                    <div class="text-3xl font-black text-ocean-blue mb-6">
                        <span id="display-price" data-base-price="{{ $product->price }}">{{ number_format($product->price, 0, ',', '.') }}</span>đ
                    </div>
                    
                    <p class="text-text-secondary text-lg leading-relaxed mb-6 flex-grow">
                        {{ $product->description }}
                    </p>

                    <!-- Form Add to Cart -->
                    <form action="{{ route('cart.add') }}" method="POST" class="mt-auto flex flex-col gap-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <!-- Size Selection -->
                        <div>
                            <h4 class="font-bold text-deep-navy mb-3 text-sm uppercase tracking-wide">Chọn Size</h4>
                            <div class="flex gap-3">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="size" value="S" class="peer hidden" checked onchange="updatePrice()">
                                    <div class="text-center py-2 px-4 rounded-xl border-2 border-light-border text-text-secondary font-bold peer-checked:border-ocean-blue peer-checked:text-ocean-blue peer-checked:bg-alice-blue transition">
                                        S <span class="block text-xs font-normal opacity-70">Nhỏ</span>
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="size" value="M" class="peer hidden" onchange="updatePrice()">
                                    <div class="text-center py-2 px-4 rounded-xl border-2 border-light-border text-text-secondary font-bold peer-checked:border-ocean-blue peer-checked:text-ocean-blue peer-checked:bg-alice-blue transition">
                                        M <span class="block text-xs font-normal opacity-70">+5.000đ</span>
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="size" value="L" class="peer hidden" onchange="updatePrice()">
                                    <div class="text-center py-2 px-4 rounded-xl border-2 border-light-border text-text-secondary font-bold peer-checked:border-ocean-blue peer-checked:text-ocean-blue peer-checked:bg-alice-blue transition">
                                        L <span class="block text-xs font-normal opacity-70">+10.000đ</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Stock info & Quantity -->
                        @php
                            $maxQuantity = $product->max_orderable_quantity;
                        @endphp
                        
                        <div class="flex items-center justify-between p-4 bg-alice-blue rounded-xl border border-light-border">
                            <div>
                                <h4 class="font-bold text-deep-navy mb-1 text-sm">Số lượng</h4>
                                @if($maxQuantity > 0)
                                    <p class="text-xs text-text-secondary">Còn <span class="font-bold text-ocean-blue">{{ $maxQuantity }}</span> ly</p>
                                @else
                                    <p class="text-xs font-bold text-blush">Hết nguyên liệu</p>
                                @endif
                            </div>
                            
                            @if($maxQuantity > 0)
                                <div class="flex items-center bg-white border border-light-border rounded-lg overflow-hidden shadow-sm">
                                    <button type="button" class="px-3 py-2 text-text-secondary hover:bg-gray-50 font-bold" onclick="decreaseQty()">-</button>
                                    <input type="number" id="qty-input" name="quantity" value="1" min="1" max="{{ $maxQuantity }}" 
                                        class="w-12 text-center font-bold text-deep-navy border-x border-light-border focus:outline-none" readonly>
                                    <button type="button" class="px-3 py-2 text-text-secondary hover:bg-gray-50 font-bold" onclick="increaseQty()">+</button>
                                </div>
                            @endif
                        </div>

                        @if($maxQuantity > 0)
                            <button type="submit" class="w-full bg-deep-navy text-white px-6 py-4 rounded-2xl font-black text-lg hover:bg-ocean-blue transition shadow-xl shadow-deep-navy/30 flex items-center justify-center space-x-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                <span>Thêm vào giỏ hàng</span>
                            </button>
                        @else
                            <button type="button" disabled class="w-full bg-gray-300 text-gray-500 px-6 py-4 rounded-2xl font-black text-lg cursor-not-allowed flex items-center justify-center space-x-2">
                                <span>Tạm hết hàng</span>
                            </button>
                        @endif
                    </form>
                </div>
            </div>
            
            <!-- Ingredients List (Optional, for demo purposes) -->
            <div class="mt-12 bg-white rounded-3xl shadow-md p-8 border border-light-border">
                <h3 class="text-xl font-black text-deep-navy mb-6">Thành phần nguyên liệu</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($product->ingredients as $ingredient)
                        <div class="bg-alice-blue p-4 rounded-xl flex items-center justify-between border border-light-border/50 hover:border-ocean-blue transition">
                            <span class="font-bold text-text-primary">{{ $ingredient->name }}</span>
                            <span class="text-sm text-text-secondary font-medium bg-white px-3 py-1 rounded-full shadow-sm">
                                {{ $ingredient->pivot->quantity_required }} {{ $ingredient->unit }}
                            </span>
                        </div>
                    @endforeach
                    @if($product->ingredients->isEmpty())
                        <div class="text-text-secondary">Chưa có thông tin nguyên liệu.</div>
                    @endif
                </div>
            </div>
            
        </div>
    </main>
    <!-- JS for interaction -->
    <script>
        function decreaseQty() {
            const input = document.getElementById('qty-input');
            if (input && parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
        function increaseQty() {
            const input = document.getElementById('qty-input');
            if (input && parseInt(input.value) < parseInt(input.max)) {
                input.value = parseInt(input.value) + 1;
            }
        }
        function updatePrice() {
            const sizeS = document.querySelector('input[name="size"][value="S"]').checked;
            const sizeM = document.querySelector('input[name="size"][value="M"]').checked;
            const sizeL = document.querySelector('input[name="size"][value="L"]').checked;
            
            const displayPrice = document.getElementById('display-price');
            let basePrice = parseInt(displayPrice.dataset.basePrice);
            
            if (sizeM) basePrice += 5000;
            if (sizeL) basePrice += 10000;
            
            displayPrice.innerText = new Intl.NumberFormat('vi-VN').format(basePrice);
        }
    </script>
</body>
</html>
