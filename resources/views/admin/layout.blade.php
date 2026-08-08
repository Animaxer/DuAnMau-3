<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Freshie Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 antialiased font-sans flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-deep-navy shadow-xl h-full flex flex-col transition-all duration-300">
        <div class="p-6 text-center border-b border-white/10">
            <h1 class="text-3xl font-black text-white tracking-wide">freshie<span class="text-aquamarine">.</span><span class="text-sm font-normal text-slate-400 block mt-1">Admin Panel</span></h1>
        </div>
        <nav class="flex-grow p-4">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="block p-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-ocean-blue text-white font-bold' : '' }}">
                        <span class="flex items-center"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg> Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="block p-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-ocean-blue text-white font-bold' : '' }}">
                        <span class="flex items-center"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg> Quản lý Sản phẩm</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="block p-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-ocean-blue text-white font-bold' : '' }}">
                        <span class="flex items-center"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg> Quản lý Đơn hàng</span>
                    </a>
                </li>
                {{-- 
                <li>
                    <a href="#" class="block p-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-colors duration-200">
                        <span class="flex items-center"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> Khách hàng</span>
                    </a>
                </li>
                --}}
            </ul>
        </nav>
        <div class="p-4 border-t border-white/10">
            <a href="/" class="block p-3 rounded-xl hover:bg-white/10 text-white/80 hover:text-white transition-colors duration-200 text-center font-semibold border border-white/20">
                Về trang mua hàng
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <!-- Topbar -->
        <header class="bg-white/80 backdrop-blur-sm shadow-sm px-6 py-4 flex justify-between items-center z-10 border-b border-slate-200/80">
            <h2 class="text-lg font-black text-slate-800">@yield('title', 'Admin Panel')</h2>
            <div class="flex items-center space-x-4">
                <a href="/" target="_blank" class="text-xs font-semibold text-slate-500 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 px-3 py-2 rounded-lg transition flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    Trang khách hàng
                </a>
                <div class="flex items-center space-x-2">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-700">Admin</p>
                        <p class="text-xs text-slate-400">Quản trị viên</p>
                    </div>
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white text-sm font-black shadow-md">
                        AD
                    </div>
                </div>
            </div>
        </header>

        <!-- Dynamic Content -->
        <div class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-100 p-6">
            @yield('content')
        </div>
    </main>
</body>
</html>
