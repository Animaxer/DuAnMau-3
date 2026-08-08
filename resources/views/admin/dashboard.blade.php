@extends('admin.layout')

@section('title', 'Tổng quan')

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Tổng quan hệ thống</h2>
            <p class="text-slate-500 text-sm mt-1">{{ now()->format('l, d/m/Y') }} — Chào mừng trở lại, Admin!</p>
        </div>
        <div class="flex items-center space-x-2 bg-green-50 border border-green-200 text-green-700 text-sm font-semibold px-4 py-2 rounded-xl">
            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
            <span>Hệ thống hoạt động</span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Products -->
        <div class="relative bg-white rounded-2xl p-6 shadow-sm border border-slate-100 overflow-hidden group hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="absolute inset-0 bg-gradient-to-br from-cyan-50 to-blue-50 opacity-60"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Tổng sản phẩm</p>
                    <h3 class="text-4xl font-black text-slate-800 mb-1">{{ $productCount }}</h3>
                    <p class="text-xs text-slate-500">Hiện đang kinh doanh</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center shadow-lg shadow-blue-200">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
            <div class="relative mt-4 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold text-blue-500 hover:text-blue-700 transition flex items-center">
                    Xem danh sách <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="relative bg-white rounded-2xl p-6 shadow-sm border border-slate-100 overflow-hidden group hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-50 to-purple-50 opacity-60"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Tổng đơn hàng</p>
                    <h3 class="text-4xl font-black text-slate-800 mb-1">{{ $orderCount }}</h3>
                    <p class="text-xs text-slate-500">Từ trước đến nay</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center shadow-lg shadow-purple-200">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>
            <div class="relative mt-4 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-blue-500 hover:text-blue-700 transition flex items-center">
                    Xem danh sách <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="relative bg-white rounded-2xl p-6 shadow-sm border border-slate-100 overflow-hidden group hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="absolute inset-0 bg-gradient-to-br from-rose-50 to-pink-50 opacity-60"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Khách hàng</p>
                    <h3 class="text-4xl font-black text-slate-800 mb-1">{{ $userCount }}</h3>
                    <p class="text-xs text-slate-500">Tài khoản đã đăng ký</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-400 to-pink-500 flex items-center justify-center shadow-lg shadow-rose-200">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
            </div>
            <div class="relative mt-4 pt-4 border-t border-slate-100">
                <span class="text-xs font-semibold text-slate-400">Tài khoản đã đăng ký</span>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-5 flex justify-between items-center border-b border-slate-100">
            <div>
                <h3 class="font-black text-slate-800 text-lg">Đơn hàng gần đây</h3>
                <p class="text-slate-400 text-sm mt-0.5">Theo dõi trạng thái các đơn hàng mới nhất</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-bold text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition">Xem tất cả</a>
        </div>

        <table class="w-full">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Mã đơn</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Khách hàng</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Tổng tiền</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Ngày đặt</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($recentOrders as $order)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-800 text-sm bg-slate-100 px-2 py-1 rounded-lg">#{{ $order->id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-xs font-black flex-shrink-0">
                                    {{ strtoupper(substr($order->user->name ?? 'K', 0, 1)) }}
                                </div>
                                <span class="font-semibold text-slate-700 text-sm">{{ $order->user->name ?? 'Khách lẻ' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-black text-slate-800">{{ number_format($order->total_price, 0, ',', '.') }}<span class="text-slate-400 font-normal text-xs">đ</span></span>
                        </td>
                        <td class="px-6 py-4">
                            @if($order->status == 0)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5"></span>Chờ xử lý
                                </span>
                            @elseif($order->status == 2)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>Hoàn thành
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mr-1.5"></span>Khác
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                <p class="text-slate-400 font-semibold">Chưa có đơn hàng nào</p>
                                <p class="text-slate-300 text-sm mt-1">Các đơn hàng sẽ xuất hiện tại đây khi có khách đặt hàng.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
