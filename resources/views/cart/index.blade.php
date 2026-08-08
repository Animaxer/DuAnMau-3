<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giỏ hàng - Freshie</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .header-blur {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        /* Custom number input arrows */
        input[type="number"]::-webkit-inner-spin-button, 
        input[type="number"]::-webkit-outer-spin-button { 
            opacity: 1; 
        }
    </style>
</head>
<body class="bg-warm-white text-text-primary antialiased flex flex-col min-h-screen">

    <!-- ===== HEADER ===== -->
    <header class="bg-deep-navy/95 header-blur sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center space-x-3 group">
                <span class="text-2xl font-black text-white tracking-tight">freshie<span class="text-aquamarine">.</span></span>
            </a>
            
            <a href="/" class="text-white/80 hover:text-sky-blue font-medium transition flex items-center text-sm md:text-base">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Tiếp tục mua sắm
            </a>
        </div>
    </header>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="flex-grow container mx-auto px-4 py-12 max-w-6xl">
        
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl md:text-4xl font-black text-deep-navy">Giỏ hàng của bạn</h1>
            <span class="bg-alice-blue text-ocean-blue font-bold px-4 py-1.5 rounded-full text-sm border border-light-border">{{ count($cart) }} sản phẩm</span>
        </div>

        @if(session('success'))
            <div class="bg-aquamarine/20 border border-deep-teal text-deep-teal px-5 py-4 rounded-2xl mb-8 shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-blush/10 border border-blush text-blush px-5 py-4 rounded-2xl mb-8 shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                <!-- Cart Items List -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-3xl shadow-sm border border-light-border overflow-hidden">
                        <div class="hidden md:grid grid-cols-12 gap-4 px-8 py-5 border-b border-alice-blue bg-gray-50/50">
                            <div class="col-span-6 text-xs font-bold text-text-secondary uppercase tracking-wider">Sản phẩm</div>
                            <div class="col-span-2 text-xs font-bold text-text-secondary uppercase tracking-wider text-center">Đơn giá</div>
                            <div class="col-span-2 text-xs font-bold text-text-secondary uppercase tracking-wider text-center">Số lượng</div>
                            <div class="col-span-2 text-xs font-bold text-text-secondary uppercase tracking-wider text-right">Tổng</div>
                        </div>

                        <div class="divide-y divide-alice-blue">
                            @foreach($cart as $id => $details)
                                <div class="p-6 md:px-8 py-6 flex flex-col md:grid md:grid-cols-12 gap-4 items-center group hover:bg-gray-50/30 transition">
                                    
                                    <!-- Product Info -->
                                    <div class="col-span-6 w-full flex items-center gap-4">
                                        <div class="w-20 h-20 rounded-2xl overflow-hidden flex-shrink-0 border border-light-border shadow-sm">
                                            <img src="{{ $details['image_url'] ?: 'https://placehold.co/500x500?text=Freshie' }}" onerror="this.onerror=null; this.src='https://placehold.co/500x500?text=Freshie';" alt="{{ $details['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-deep-navy text-lg mb-1">{{ $details['name'] }}</h3>
                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <button type="submit" class="text-blush text-sm font-semibold hover:underline flex items-center">
                                                    Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Price (Mobile hidden, Desktop shown) -->
                                    <div class="hidden md:flex col-span-2 justify-center text-text-secondary font-semibold">
                                        {{ number_format($details['price'], 0, ',', '.') }}đ
                                    </div>

                                    <!-- Quantity -->
                                    <div class="col-span-2 w-full md:w-auto flex justify-between md:justify-center items-center mt-4 md:mt-0">
                                        <span class="md:hidden font-bold text-text-secondary text-sm">Số lượng:</span>
                                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <div class="flex items-center border border-light-border rounded-xl overflow-hidden shadow-sm">
                                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" 
                                                    class="w-16 h-10 text-center font-bold text-deep-navy bg-white focus:outline-none focus:ring-2 focus:ring-sky-blue/50"
                                                    onchange="this.form.submit()">
                                            </div>
                                            <!-- Fallback submit button hidden but functional -->
                                            <button type="submit" class="hidden">Cập nhật</button>
                                        </form>
                                    </div>

                                    <!-- Total -->
                                    <div class="col-span-2 w-full md:w-auto flex justify-between md:justify-end items-center mt-2 md:mt-0">
                                        <span class="md:hidden font-bold text-text-secondary text-sm">Tổng cộng:</span>
                                        <span class="font-black text-ocean-blue text-lg">{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}đ</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-3xl shadow-sm p-8 border border-light-border sticky top-24">
                        <h3 class="text-xl font-black text-deep-navy mb-6">Tóm tắt đơn hàng</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between items-center text-text-secondary font-medium">
                                <span>Tạm tính ({{ count($cart) }} món)</span>
                                <span class="text-deep-navy font-bold">{{ number_format($total, 0, ',', '.') }}đ</span>
                            </div>
                            <div class="flex justify-between items-center text-text-secondary font-medium">
                                <span>Phí giao hàng</span>
                                <span class="text-deep-teal font-bold bg-aquamarine/20 px-2 py-0.5 rounded-md text-sm">Miễn phí</span>
                            </div>
                        </div>
                        
                        <div class="border-t border-alice-blue pt-6 mb-8">
                            <div class="flex justify-between items-end">
                                <div>
                                    <span class="block text-sm font-semibold text-text-secondary mb-1">Tổng thanh toán</span>
                                    <span class="text-xs text-text-secondary/70">Đã bao gồm VAT (nếu có)</span>
                                </div>
                                <span class="text-3xl font-black text-ocean-blue">{{ number_format($total, 0, ',', '.') }}đ</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout') }}" class="flex items-center justify-center w-full bg-deep-navy text-white font-black py-4 px-6 rounded-2xl hover:bg-ocean-blue transition-all duration-300 shadow-xl shadow-deep-navy/20 hover:-translate-y-1">
                            <span>Tiến hành thanh toán</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        
                        <div class="mt-6 flex items-center justify-center gap-2 text-text-secondary text-sm font-medium">
                            <svg class="w-4 h-4 text-deep-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Thanh toán an toàn 100%
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl shadow-sm p-16 text-center max-w-2xl mx-auto border border-light-border flex flex-col items-center">
                <div class="w-32 h-32 bg-alice-blue rounded-full flex items-center justify-center mb-8 relative">
                    <span class="text-6xl">🛍️</span>
                    <div class="absolute -bottom-2 -right-2 bg-white rounded-full p-1 shadow-md">
                        <div class="w-8 h-8 bg-blush rounded-full flex items-center justify-center text-white font-bold text-sm">0</div>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-deep-navy mb-4">Giỏ hàng của bạn đang trống</h3>
                <p class="text-text-secondary text-lg mb-10 max-w-md">Có vẻ như bạn chưa chọn món đồ uống nào. Hãy quay lại thực đơn để khám phá các món ngon của Freshie nhé!</p>
                <a href="/#menu" class="bg-ocean-blue text-white font-bold py-4 px-10 rounded-2xl hover:bg-deep-navy transition-all duration-300 shadow-xl shadow-ocean-blue/30 hover:-translate-y-1">
                    Khám phá Thực đơn
                </a>
            </div>
        @endif
    </main>
</body>
</html>
