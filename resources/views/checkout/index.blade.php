<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thanh toán - Freshie</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .header-blur { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    </style>
</head>
<body class="bg-warm-white text-text-primary antialiased flex flex-col min-h-screen">
    
    <!-- ===== HEADER ===== -->
    <header class="bg-deep-navy/95 header-blur sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center space-x-3 group">
                <span class="text-2xl font-black text-white tracking-tight">freshie<span class="text-aquamarine">.</span></span>
            </a>
            
            <div class="text-white font-bold text-lg hidden md:block">
                Thanh toán an toàn
            </div>
            
            <a href="{{ route('cart.index') }}" class="text-white/80 hover:text-sky-blue font-medium transition flex items-center text-sm md:text-base">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Quay lại giỏ hàng
            </a>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-4 py-12 max-w-6xl">
        <div class="flex flex-col-reverse lg:flex-row gap-8 lg:gap-12">
            
            <!-- Left: Checkout Form -->
            <div class="lg:w-3/5">
                <div class="bg-white rounded-3xl shadow-sm border border-light-border p-8 md:p-10">
                    <h2 class="text-2xl font-black text-deep-navy mb-8 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-deep-navy text-white text-sm flex items-center justify-center mr-3">1</span>
                        Thông tin giao hàng
                    </h2>
                    
                    <form action="{{ route('order.place') }}" method="POST" id="checkout-form">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-bold text-deep-navy mb-2">Họ và tên *</label>
                                <input type="text" name="name" required value="{{ auth()->user()->name ?? '' }}" 
                                    class="w-full px-4 py-3.5 rounded-xl border border-light-border focus:outline-none focus:border-ocean-blue focus:ring-4 focus:ring-ocean-blue/10 bg-gray-50 transition font-medium"
                                    placeholder="Nguyễn Văn A">
                            </div>
                            
                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-bold text-deep-navy mb-2">Số điện thoại *</label>
                                <input type="tel" name="phone" required 
                                    class="w-full px-4 py-3.5 rounded-xl border border-light-border focus:outline-none focus:border-ocean-blue focus:ring-4 focus:ring-ocean-blue/10 bg-gray-50 transition font-medium"
                                    placeholder="0901234567">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-deep-navy mb-2">Địa chỉ nhận hàng *</label>
                            <textarea name="address" required rows="3" 
                                class="w-full px-4 py-3.5 rounded-xl border border-light-border focus:outline-none focus:border-ocean-blue focus:ring-4 focus:ring-ocean-blue/10 bg-gray-50 transition font-medium resize-none"
                                placeholder="Số nhà, Tên đường, Phường/Xã, Quận/Huyện, Tỉnh/Thành phố"></textarea>
                        </div>

                        <h2 class="text-2xl font-black text-deep-navy mb-6 flex items-center border-t border-alice-blue pt-8">
                            <span class="w-8 h-8 rounded-full bg-deep-navy text-white text-sm flex items-center justify-center mr-3">2</span>
                            Phương thức thanh toán
                        </h2>

                        <div class="space-y-4 mb-10">
                            <label class="flex items-center p-4 border-2 border-ocean-blue rounded-xl bg-alice-blue/30 cursor-pointer relative">
                                <input type="radio" name="payment_method" value="cod" checked class="w-5 h-5 text-ocean-blue focus:ring-ocean-blue border-gray-300">
                                <span class="ml-4 font-bold text-deep-navy">Thanh toán khi nhận hàng (COD)</span>
                                <span class="absolute right-4 text-2xl">💵</span>
                            </label>
                            
                            <label class="flex items-center p-4 border border-light-border rounded-xl hover:bg-gray-50 transition cursor-pointer relative opacity-60">
                                <input type="radio" name="payment_method" value="momo" disabled class="w-5 h-5 text-ocean-blue focus:ring-ocean-blue border-gray-300">
                                <span class="ml-4 font-bold text-text-secondary">Ví MoMo <span class="text-xs bg-gray-200 px-2 py-1 rounded text-gray-600 ml-2">Sắp ra mắt</span></span>
                                <span class="absolute right-4 text-2xl">📱</span>
                            </label>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="lg:w-2/5">
                <div class="bg-white rounded-3xl shadow-sm border border-light-border overflow-hidden sticky top-24">
                    <div class="p-6 md:p-8 bg-gray-50/50 border-b border-light-border">
                        <h3 class="text-xl font-black text-deep-navy">Đơn hàng của bạn</h3>
                        <p class="text-sm text-text-secondary font-medium mt-1">{{ count($cart) }} sản phẩm</p>
                    </div>
                    
                    <!-- Cart Items Preview -->
                    <div class="p-6 md:p-8 border-b border-alice-blue max-h-72 overflow-y-auto custom-scrollbar">
                        <div class="space-y-4">
                            @foreach($cart as $details)
                                <div class="flex gap-4 items-center">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden border border-light-border flex-shrink-0 relative">
                                        <img src="{{ $details['image_url'] }}" alt="{{ $details['name'] }}" class="w-full h-full object-cover">
                                        <span class="absolute top-0 right-0 bg-deep-navy text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-bl-lg">{{ $details['quantity'] }}</span>
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="font-bold text-deep-navy text-sm line-clamp-1">{{ $details['name'] }}</h4>
                                        <p class="text-text-secondary text-sm font-medium mt-0.5">{{ number_format($details['price'], 0, ',', '.') }}đ</p>
                                    </div>
                                    <div class="font-bold text-ocean-blue">
                                        {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}đ
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Totals -->
                    <div class="p-6 md:p-8">
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-text-secondary font-medium">
                                <span>Tạm tính</span>
                                <span class="font-bold text-deep-navy">{{ number_format($total, 0, ',', '.') }}đ</span>
                            </div>
                            <div class="flex justify-between text-text-secondary font-medium">
                                <span>Phí giao hàng</span>
                                <span class="text-deep-teal font-bold bg-aquamarine/20 px-2 py-0.5 rounded-md text-sm">Miễn phí</span>
                            </div>
                        </div>
                        
                        <div class="border-t border-alice-blue pt-6 mb-8">
                            <div class="flex justify-between items-end">
                                <span class="text-lg font-bold text-deep-navy">Tổng thanh toán</span>
                                <span class="text-3xl font-black text-ocean-blue">{{ number_format($total, 0, ',', '.') }}đ</span>
                            </div>
                        </div>

                        <button onclick="document.getElementById('checkout-form').submit()" class="w-full bg-ocean-blue text-white font-black py-4 px-6 rounded-2xl hover:bg-deep-navy transition-all duration-300 shadow-xl shadow-ocean-blue/30 hover:-translate-y-1 flex items-center justify-center gap-2 text-lg">
                            Đặt hàng ngay
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </main>
</body>
</html>
