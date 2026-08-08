@extends('admin.layout')

@section('title', 'Quản lý Đơn hàng')

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Quản lý Đơn hàng</h2>
            <p class="text-slate-500 text-sm mt-1">Theo dõi và xử lý tất cả các đơn đặt hàng</p>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-md shadow-amber-100">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Chờ xử lý</p>
                <p class="text-2xl font-black text-slate-800">{{ $pendingCount }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-400 to-green-500 flex items-center justify-center shadow-md shadow-green-100">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Doanh thu hoàn tất</p>
                <p class="text-2xl font-black text-slate-800">{{ number_format($totalRevenue, 0, ',', '.') }}<span class="text-sm font-normal text-slate-400">đ</span></p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col sm:flex-row gap-3">
            <!-- Search -->
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Tìm mã đơn, tên khách hàng..." 
                    class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition">
            </div>
            <!-- Status Filter -->
            <div class="flex gap-2 flex-wrap">
                @foreach(['all' => 'Tất cả', '0' => 'Chờ xử lý', '1' => 'Đang giao', '2' => 'Hoàn thành', '3' => 'Đã hủy'] as $val => $label)
                    <a href="{{ route('admin.orders.index', ['status' => $val, 'search' => $search]) }}"
                        class="px-3 py-2 rounded-xl text-xs font-bold transition {{ $status == $val ? 'bg-blue-500 text-white shadow-md shadow-blue-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $label }}
                    </a>
                @endforeach
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-xl text-xs font-bold hover:bg-blue-600 transition">Tìm kiếm</button>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="flex items-center bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl mb-6">
            <svg class="w-5 h-5 mr-3 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Mã đơn</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Khách hàng</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Tổng tiền</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Ngày đặt</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-700 text-sm bg-slate-100 px-2 py-1 rounded-lg">#{{ $order->id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-xs font-black flex-shrink-0">
                                    {{ strtoupper(substr($order->user->name ?? 'K', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-700 text-sm">{{ $order->user->name ?? 'Khách lẻ' }}</p>
                                    <p class="text-xs text-slate-400">{{ $order->user->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-black text-slate-800">{{ number_format($order->total_price, 0, ',', '.') }}<span class="text-slate-400 font-normal text-xs">đ</span></span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $badges = [
                                    0 => ['bg' => 'bg-amber-100 border-amber-200 text-amber-700', 'dot' => 'bg-amber-500', 'label' => 'Chờ xử lý'],
                                    1 => ['bg' => 'bg-blue-100 border-blue-200 text-blue-700', 'dot' => 'bg-blue-500', 'label' => 'Đang giao'],
                                    2 => ['bg' => 'bg-emerald-100 border-emerald-200 text-emerald-700', 'dot' => 'bg-emerald-500', 'label' => 'Hoàn thành'],
                                    3 => ['bg' => 'bg-red-100 border-red-200 text-red-700', 'dot' => 'bg-red-500', 'label' => 'Đã hủy'],
                                ];
                                $badge = $badges[$order->status] ?? $badges[0];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badge['bg'] }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $badge['dot'] }}"></span>
                                {{ $badge['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $order->created_at->format('d/m/Y') }}<span class="block text-xs text-slate-400">{{ $order->created_at->format('H:i') }}</span></td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                class="inline-flex items-center text-xs font-bold text-slate-600 hover:text-blue-600 bg-slate-100 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 px-3 py-1.5 rounded-lg transition-all duration-200">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Xem
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                <p class="text-slate-400 font-semibold">Không có đơn hàng nào</p>
                                <p class="text-slate-300 text-sm mt-1">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
            <p class="text-sm text-slate-500">
                Hiển thị {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }} / {{ $orders->total() }} đơn hàng
            </p>
            <div class="text-sm">{{ $orders->links() }}</div>
        </div>
    </div>
@endsection
