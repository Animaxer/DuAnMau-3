<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập - Freshie</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-alice-blue to-baby-blue-ice min-h-screen flex items-center justify-center font-sans antialiased p-4">
    <div class="bg-white p-10 rounded-3xl shadow-xl w-full max-w-md border-t-4 border-sky-blue relative overflow-hidden">
        
        <!-- Decorative elements -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-petal-frost rounded-full opacity-50 blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-aquamarine rounded-full opacity-50 blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10 text-center mb-8">
            <h1 class="text-4xl font-bold text-sky-blue tracking-wide mb-2">Freshie</h1>
            <p class="text-slate-500">Đăng nhập để đặt đồ uống mát lạnh</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="relative z-10">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4 text-sm font-medium border border-red-200">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-5">
                <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="VD: customer@freshie.com" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-blue focus:border-transparent transition bg-gray-50">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Mật khẩu</label>
                <input type="password" name="password" id="password" required placeholder="Nhập mật khẩu của bạn" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-blue focus:border-transparent transition bg-gray-50">
            </div>

            <div class="flex items-center justify-between mb-8">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-sky-blue rounded border-slate-300 focus:ring-sky-blue">
                    <span class="ml-2 text-sm text-slate-600">Ghi nhớ đăng nhập</span>
                </label>
                <a href="#" class="text-sm font-semibold text-sky-blue hover:text-baby-blue-ice transition">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="w-full bg-sky-blue text-white font-bold py-3 px-4 rounded-xl hover:bg-baby-blue-ice transition duration-300 shadow-lg shadow-sky-blue/40">
                Đăng nhập
            </button>
            
            <div class="mt-6 text-center text-sm text-slate-500">
                Chưa có tài khoản? <a href="#" class="font-bold text-sky-blue hover:text-baby-blue-ice transition">Đăng ký ngay</a>
            </div>
            
            <div class="mt-4 text-center text-xs text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-slate-600 transition inline-flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Quay lại trang chủ
                </a>
            </div>
        </form>
    </div>
</body>
</html>
