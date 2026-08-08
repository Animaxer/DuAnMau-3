<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Freshie - Web bán đồ uống tươi mát. Đặt hàng trà, cà phê, đá xay ngay tại nhà.">
    <title>Freshie - Web bán đồ uống</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Gradient hero */
        .hero-gradient {
            background: linear-gradient(135deg, #1A2E4A 0%, #3B82C4 50%, #97D2FB 100%);
        }

        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(-2deg); }
            50% { transform: translateY(-12px) rotate(2deg); }
        }
        .float-anim { animation: float 4s ease-in-out infinite; }

        /* Card hover lift */
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(59, 130, 196, 0.18);
        }

        /* Search bar glow */
        .search-glow:focus {
            box-shadow: 0 0 0 3px rgba(151, 210, 251, 0.5);
        }

        /* Filter badge active */
        .filter-btn.active {
            background-color: #1A2E4A;
            color: #ffffff;
        }

        /* Price badge */
        .price-badge {
            background: linear-gradient(135deg, #1A2E4A, #3B82C4);
        }

        /* Scrollbar custom */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #E1EFF6; }
        ::-webkit-scrollbar-thumb { background: #97D2FB; border-radius: 3px; }

        /* Fade-in animation for cards */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .product-card { animation: fadeInUp 0.4s ease both; }

        /* Sticky header blur */
        .header-blur {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-warm-white text-text-primary antialiased flex flex-col min-h-screen">

    <!-- ===== HEADER ===== -->
    <header class="bg-deep-navy/95 header-blur sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-3 group">
                <span class="text-2xl font-black text-white tracking-tight">freshie<span class="text-aquamarine">.</span></span>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="/" class="text-sky-blue font-semibold border-b-2 border-sky-blue pb-0.5">Trang chủ</a>
                <a href="#menu" class="text-white/80 hover:text-sky-blue font-medium transition">Thực đơn</a>
                <a href="#" class="text-white/80 hover:text-sky-blue font-medium transition">Về chúng tôi</a>
            </nav>

            <!-- Right actions -->
            <div class="flex items-center space-x-3">
                <!-- Cart icon -->
                <a href="{{ route('cart.index') }}" class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-white/10 hover:bg-sky-blue/20 transition group">
                    <svg class="w-5 h-5 text-white group-hover:text-sky-blue transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    @if(count((array) session('cart')) > 0)
                        <span class="absolute -top-1 -right-1 bg-blush text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center">
                            {{ count((array) session('cart')) }}
                        </span>
                    @endif
                </a>

                @auth
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-lg bg-aquamarine flex items-center justify-center text-deep-navy font-black text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        @if(auth()->user()->role == 1)
                            <a href="{{ route('admin.dashboard') }}" class="hidden md:block bg-aquamarine text-deep-navy px-4 py-2 rounded-xl font-bold hover:bg-sky-blue transition text-sm">
                                Quản Trị
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="hidden md:block text-white/70 hover:text-white font-medium text-sm transition px-3 py-2 rounded-xl hover:bg-white/10">
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-ocean-blue text-white px-5 py-2 rounded-xl font-bold hover:bg-sky-blue transition shadow-lg shadow-ocean-blue/30 text-sm">
                        Đăng nhập
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- ===== HERO SECTION ===== -->
    <section class="hero-gradient relative overflow-hidden py-20 px-6">
        <!-- Decorative blobs -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-sky-blue/20 rounded-full blur-3xl pointer-events-none -translate-y-1/3 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-aquamarine/15 rounded-full blur-3xl pointer-events-none translate-y-1/3 -translate-x-1/4"></div>

        <div class="container mx-auto flex flex-col md:flex-row items-center gap-12 relative z-10">
            <!-- Text -->
            <div class="flex-1 text-center md:text-left">
                <div class="inline-block bg-aquamarine/20 text-aquamarine border border-aquamarine/30 px-4 py-1 rounded-full text-sm font-semibold mb-6 backdrop-blur-sm">
                    🌿 Tươi mới mỗi ngày
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-6">
                    Thức uống<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-aquamarine to-sky-blue">tươi mát</span><br>
                    mỗi ngày
                </h1>
                <p class="text-white/70 text-lg mb-10 max-w-xl leading-relaxed">
                    Freshie mang đến trải nghiệm đồ uống độc đáo. Đặt hàng ngay và nhận giao hàng miễn phí trong hôm nay!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="#menu" class="bg-aquamarine text-deep-navy font-black px-8 py-4 rounded-2xl hover:bg-white transition shadow-xl shadow-aquamarine/20 text-center">
                        Xem thực đơn →
                    </a>
                    <a href="{{ route('cart.index') }}" class="border-2 border-white/30 text-white font-semibold px-8 py-4 rounded-2xl hover:border-sky-blue hover:text-sky-blue backdrop-blur-sm transition text-center">
                        Giỏ hàng
                    </a>
                </div>

                <!-- Stats -->
                <div class="flex gap-8 mt-12 justify-center md:justify-start">
                    <div class="text-center">
                        <div class="text-3xl font-black text-white">15+</div>
                        <div class="text-white/60 text-xs mt-1">Thức uống</div>
                    </div>
                    <div class="w-px bg-white/20"></div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-white">3</div>
                        <div class="text-white/60 text-xs mt-1">Danh mục</div>
                    </div>
                    <div class="w-px bg-white/20"></div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-aquamarine">Free</div>
                        <div class="text-white/60 text-xs mt-1">Giao hàng</div>
                    </div>
                </div>
            </div>

            <!-- Hero Visual -->
            <div class="flex-shrink-0 float-anim">
                <div class="relative w-72 h-72 md:w-80 md:h-80">
                    <!-- Glow ring -->
                    <div class="absolute inset-0 rounded-full bg-gradient-to-br from-aquamarine/40 to-sky-blue/40 blur-2xl scale-110"></div>
                    <!-- Main circle -->
                    <div class="relative w-full h-full rounded-full overflow-hidden border-4 border-white/20 shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&auto=format&fit=crop&q=80" 
                             alt="Freshie hero drink" class="w-full h-full object-cover">
                    </div>
                    <!-- Floating badge -->
                    <div class="absolute -bottom-3 -right-3 bg-white rounded-2xl shadow-xl px-4 py-3 flex items-center space-x-2">
                        <div class="w-8 h-8 bg-aquamarine rounded-lg flex items-center justify-center">⭐</div>
                        <div>
                            <div class="text-xs text-text-secondary font-medium">Đánh giá</div>
                            <div class="font-black text-deep-navy text-sm">4.9 / 5.0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== SUCCESS TOAST ===== -->
    @if(session('success'))
        <div id="toast" class="fixed bottom-6 right-6 z-50 bg-deep-navy text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center space-x-4 max-w-sm border border-aquamarine/30">
            <div class="w-8 h-8 bg-aquamarine rounded-lg flex items-center justify-center text-deep-navy flex-shrink-0 font-black">✓</div>
            <div>
                <p class="font-semibold text-sm">{{ session('success') }}</p>
                <a href="{{ route('cart.index') }}" class="text-aquamarine text-xs font-bold hover:underline">Xem giỏ hàng →</a>
            </div>
            <button onclick="document.getElementById('toast').remove()" class="text-white/50 hover:text-white transition ml-2">✕</button>
        </div>
    @endif

    <!-- ===== MENU SECTION ===== -->
    <main id="menu" class="flex-grow py-16 px-4">
        <div class="container mx-auto">
            
            <!-- Section Header -->
            <div class="text-center mb-12">
                <div class="inline-block bg-alice-blue text-ocean-blue border border-light-border px-4 py-1 rounded-full text-sm font-semibold mb-4">
                    Thực đơn
                </div>
                <h2 class="text-4xl font-black text-deep-navy mb-3">Thức uống hôm nay</h2>
                <p class="text-text-secondary text-lg max-w-xl mx-auto">Chọn món yêu thích và thêm vào giỏ hàng ngay!</p>
            </div>

            <!-- Search + Filter Bar -->
            <div class="bg-white rounded-2xl shadow-md border border-light-border p-4 mb-10 flex flex-col md:flex-row gap-4 items-stretch md:items-center">
                <!-- Search -->
                <div class="flex-1 relative">
                    <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-text-secondary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input id="search-input" type="text" placeholder="Tìm kiếm đồ uống... (VD: Bạc xỉu, Trà đào)" 
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-light-border focus:outline-none focus:border-ocean-blue search-glow transition bg-alice-blue text-text-primary font-medium placeholder:text-text-secondary/60">
                </div>

                <!-- Category Filters -->
                <div class="flex gap-2 flex-wrap">
                    <button data-filter="all" class="filter-btn active px-4 py-2.5 rounded-xl font-bold text-sm border border-light-border hover:border-deep-navy transition whitespace-nowrap">
                        Tất cả
                    </button>
                    @foreach($categories as $cat)
                        <button data-filter="{{ $cat->id }}" class="filter-btn px-4 py-2.5 rounded-xl font-bold text-sm border border-light-border text-text-secondary hover:border-deep-navy hover:text-deep-navy transition whitespace-nowrap bg-white">
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Sort -->
                <select id="sort-select" class="px-4 py-3 rounded-xl border border-light-border focus:outline-none focus:border-ocean-blue bg-alice-blue text-text-primary font-semibold text-sm cursor-pointer">
                    <option value="default">Mặc định</option>
                    <option value="price-asc">Giá thấp → cao</option>
                    <option value="price-desc">Giá cao → thấp</option>
                    <option value="name-asc">Tên A → Z</option>
                </select>
            </div>

            <!-- No results message (hidden by default) -->
            <div id="no-results" class="hidden text-center py-16">
                <div class="w-20 h-20 bg-alice-blue rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">🔍</div>
                <h3 class="text-xl font-bold text-deep-navy mb-2">Không tìm thấy kết quả</h3>
                <p class="text-text-secondary">Thử từ khóa khác hoặc chọn danh mục khác nhé!</p>
            </div>

            <!-- Products Grid -->
            @if(isset($products) && count($products) > 0)
                <div id="products-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="product-card bg-white rounded-2xl overflow-hidden border border-light-border flex flex-col group cursor-pointer"
                            data-name="{{ strtolower($product->name) }}"
                            data-category="{{ $product->category_id }}"
                            data-price="{{ $product->price }}"
                            style="animation-delay: {{ $loop->index * 80 }}ms"
                            onclick="window.location.href='{{ route('product.show', $product->id) }}'">
                            
                            <!-- Image -->
                            <div class="relative overflow-hidden h-52">
                                <img src="{{ $product->image_url ?: 'https://placehold.co/500x500?text=Freshie' }}" onerror="this.onerror=null; this.src='https://placehold.co/500x500?text=Freshie';" alt="{{ $product->name }}" 
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                <!-- Category badge -->
                                <div class="absolute top-3 left-3">
                                    <span class="bg-deep-navy/80 text-sky-blue text-[11px] font-bold px-3 py-1 rounded-full backdrop-blur-sm">
                                        {{ $product->category->name ?? 'Đồ uống' }}
                                    </span>
                                </div>
                                <!-- Hover overlay -->
                                <div class="absolute inset-0 bg-deep-navy/40 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                                    <span class="text-white font-bold text-sm bg-white/20 px-4 py-2 rounded-xl backdrop-blur-sm">Xem chi tiết</span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5 flex flex-col flex-grow">
                                <h3 class="text-lg font-black text-deep-navy mb-1.5 group-hover:text-ocean-blue transition">{{ $product->name }}</h3>
                                <p class="text-text-secondary text-sm leading-relaxed mb-4 flex-grow">{{ $product->description }}</p>
                                
                                @php
                                    $maxQuantity = $product->max_orderable_quantity;
                                @endphp
                                @if($maxQuantity == 0)
                                    <p class="text-blush text-xs font-bold mb-2">Hết nguyên liệu</p>
                                @endif

                                <!-- Price & CTA -->
                                <div class="flex items-center justify-between mt-auto pt-4 border-t border-alice-blue">
                                    <div>
                                        <span class="text-xl font-black text-deep-navy">{{ number_format($product->price, 0, ',', '.') }}<span class="text-sm font-bold text-text-secondary">đ</span></span>
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST" onclick="event.stopPropagation()">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        @if($maxQuantity > 0)
                                            <button type="submit" 
                                                class="bg-deep-navy text-white px-4 py-2.5 rounded-xl font-bold hover:bg-ocean-blue transition text-sm flex items-center space-x-1.5 shadow-lg shadow-deep-navy/20 active:scale-95">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                                <span>Thêm vào giỏ</span>
                                            </button>
                                        @else
                                            <button type="button" disabled
                                                class="bg-gray-300 text-gray-500 px-4 py-2.5 rounded-xl font-bold cursor-not-allowed text-sm flex items-center space-x-1.5">
                                                <span>Tạm hết</span>
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center bg-white p-16 rounded-3xl shadow-xl max-w-2xl mx-auto border border-light-border">
                    <div class="text-6xl mb-6">🧋</div>
                    <h2 class="text-2xl font-black mb-3 text-deep-navy">Chào mừng đến với Freshie!</h2>
                    <p class="text-text-secondary mb-8">Chạy <code class="bg-alice-blue px-2 py-1 rounded text-ocean-blue font-mono text-sm">php artisan db:seed</code> để thêm dữ liệu mẫu nhé.</p>
                </div>
            @endif

            <!-- Result counter -->
            <div class="mt-8 text-center">
                <p id="result-count" class="text-text-secondary text-sm"></p>
            </div>
        </div>
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-deep-navy text-white">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">
                <!-- Brand -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="text-2xl font-black text-white">freshie<span class="text-aquamarine">.</span></span>
                    </div>
                    <p class="text-white/60 text-sm leading-relaxed">Thức uống tươi mát, đặt hàng nhanh chóng. Freshie mang hương vị tươi mới đến tận tay bạn mỗi ngày.</p>
                </div>
                <!-- Links -->
                <div>
                    <h4 class="font-black text-sm uppercase tracking-wider text-sky-blue mb-4">Liên kết nhanh</h4>
                    <ul class="space-y-2 text-white/70 text-sm">
                        <li><a href="/" class="hover:text-sky-blue transition">Trang chủ</a></li>
                        <li><a href="#menu" class="hover:text-sky-blue transition">Thực đơn</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-sky-blue transition">Giỏ hàng</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-sky-blue transition">Đăng nhập</a></li>
                    </ul>
                </div>
                <!-- Info -->
                <div>
                    <h4 class="font-black text-sm uppercase tracking-wider text-sky-blue mb-4">Thông tin</h4>
                    <ul class="space-y-2 text-white/70 text-sm">
                        <li class="flex items-center space-x-2"><span>📍</span><span>123 Đường Freshie, TP.HCM</span></li>
                        <li class="flex items-center space-x-2"><span>📞</span><span>1800 1234</span></li>
                        <li class="flex items-center space-x-2"><span>✉️</span><span>hello@freshie.vn</span></li>
                        <li class="flex items-center space-x-2"><span>🕐</span><span>7:00 - 22:00 hàng ngày</span></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row justify-between items-center gap-2">
                <p class="text-white/40 text-sm">&copy; 2026 Freshie. Dự án MVC - FPT Polytechnic.</p>
                <div class="flex gap-4">
                    <span class="inline-block bg-alice-blue/10 text-alice-blue text-xs px-3 py-1 rounded-full">Laravel 12</span>
                    <span class="inline-block bg-alice-blue/10 text-alice-blue text-xs px-3 py-1 rounded-full">Tailwind CSS v4</span>
                    <span class="inline-block bg-alice-blue/10 text-alice-blue text-xs px-3 py-1 rounded-full">MVC Pattern</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- ===== JS: Search + Filter + Sort ===== -->
    <script>
        const searchInput = document.getElementById('search-input');
        const sortSelect = document.getElementById('sort-select');
        const grid = document.getElementById('products-grid');
        const noResults = document.getElementById('no-results');
        const resultCount = document.getElementById('result-count');
        const filterBtns = document.querySelectorAll('.filter-btn');

        let activeFilter = 'all';

        function getCards() {
            return grid ? Array.from(grid.querySelectorAll('.product-card')) : [];
        }

        function applyFilters() {
            if (!grid) return;
            const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
            let cards = getCards();

            // Filter by search + category
            let visible = cards.filter(card => {
                const nameMatch = card.dataset.name.includes(searchTerm);
                const catMatch = activeFilter === 'all' || card.dataset.category === activeFilter;
                return nameMatch && catMatch;
            });

            // Sort
            if (sortSelect) {
                const sort = sortSelect.value;
                visible.sort((a, b) => {
                    if (sort === 'price-asc') return parseInt(a.dataset.price) - parseInt(b.dataset.price);
                    if (sort === 'price-desc') return parseInt(b.dataset.price) - parseInt(a.dataset.price);
                    if (sort === 'name-asc') return a.dataset.name.localeCompare(b.dataset.name, 'vi');
                    return 0;
                });
            }

            // Detach & reorder
            visible.forEach(c => grid.appendChild(c));

            // Show/hide
            cards.forEach(card => {
                const isVisible = visible.includes(card);
                card.style.display = isVisible ? 'flex' : 'none';
            });

            // No results state
            if (visible.length === 0) {
                noResults.classList.remove('hidden');
                grid.classList.add('hidden');
            } else {
                noResults.classList.add('hidden');
                grid.classList.remove('hidden');
            }

            // Result count
            if (resultCount) {
                if (searchTerm || activeFilter !== 'all') {
                    resultCount.textContent = `Hiển thị ${visible.length} trong ${cards.length} sản phẩm`;
                } else {
                    resultCount.textContent = '';
                }
            }
        }

        // Category filter buttons
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activeFilter = btn.dataset.filter;
                applyFilters();
            });
        });

        // Search input with debounce
        let debounceTimer;
        if (searchInput) {
            searchInput.addEventListener('input', () => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(applyFilters, 250);
            });
        }

        // Sort
        if (sortSelect) {
            sortSelect.addEventListener('change', applyFilters);
        }
    </script>
</body>
</html>
