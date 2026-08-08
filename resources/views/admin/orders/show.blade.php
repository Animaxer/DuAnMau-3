@extends('admin.layout')

@section('title', 'Chi tiết Đơn hàng #' . $order->id)

@section('content')
    <!-- Back -->
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-800 transition group">
            <svg class="w-4 h-4 mr-1.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Quay lại danh sách
        </a>
    </div>

    <!-- Header -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Đơn hàng <span class="text-blue-500">#{{ $order->id }}</span></h2>
            <p class="text-slate-500 text-sm mt-1">Đặt lúc {{ $order->created_at->format('H:i, d/m/Y') }}</p>
        </div>
        @php
            $badges = [
                0 => ['bg' => 'bg-amber-100 border-amber-200 text-amber-700', 'dot' => 'bg-amber-500', 'label' => 'Chờ xử lý'],
                1 => ['bg' => 'bg-blue-100 border-blue-200 text-blue-700', 'dot' => 'bg-blue-500', 'label' => 'Đang giao'],
                2 => ['bg' => 'bg-emerald-100 border-emerald-200 text-emerald-700', 'dot' => 'bg-emerald-500', 'label' => 'Hoàn thành'],
                3 => ['bg' => 'bg-red-100 border-red-200 text-red-700', 'dot' => 'bg-red-500', 'label' => 'Đã hủy'],
            ];
            $badge = $badges[$order->status] ?? $badges[0];
        @endphp
        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold border {{ $badge['bg'] }}">
            <span class="w-2 h-2 rounded-full mr-2 {{ $badge['dot'] }}"></span>
            {{ $badge['label'] }}
        </span>
    </div>

    @if(session('success'))
        <div class="flex items-center bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl mb-6">
            <svg class="w-5 h-5 mr-3 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Items Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h3 class="font-black text-slate-800">Sản phẩm đã đặt</h3>
                    <p class="text-slate-400 text-sm mt-0.5">{{ $order->orderDetails->count() }} món</p>
                </div>
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Sản phẩm</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">SL</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Đơn giá</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($order->orderDetails as $detail)
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden border border-slate-100 shadow-sm flex-shrink-0">
                                            <img src="{{ $detail->product->image_url ?: 'https://placehold.co/100x100?text=No+Img' }}"
                                                onerror="this.src='https://placehold.co/100x100?text=No+Img'"
                                                alt="{{ $detail->product->name ?? 'Sản phẩm' }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 text-sm">{{ $detail->product->name ?? 'Sản phẩm đã bị xóa' }}</p>
                                            <p class="text-xs text-slate-400">{{ $detail->product->category->name ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-bold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg text-sm">x{{ $detail->quantity }}</span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm text-slate-600 font-medium">{{ number_format($detail->price, 0, ',', '.') }}đ</td>
                                <td class="px-6 py-4 text-right font-black text-slate-800">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t-2 border-slate-100 bg-slate-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-bold text-slate-600">Tổng thanh toán</td>
                            <td class="px-6 py-4 text-right font-black text-xl text-blue-600">{{ number_format($order->total_price, 0, ',', '.') }}<span class="text-sm font-normal text-slate-400">đ</span></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Right: Info & Actions -->
        <div class="space-y-6">
            <!-- Customer Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-black text-slate-700 uppercase tracking-wider mb-4 pb-3 border-b border-slate-100">Thông tin khách hàng</h3>
                @if($order->user)
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-black text-lg flex-shrink-0">
                            {{ strtoupper(substr($order->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">{{ $order->user->name }}</p>
                            <p class="text-xs text-slate-400">{{ $order->user->email }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-slate-500 text-sm">Khách vãng lai</p>
                @endif
            </div>

            <!-- Update Status -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-black text-slate-700 uppercase tracking-wider mb-4 pb-3 border-b border-slate-100">Cập nhật trạng thái</h3>
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition text-slate-800 font-medium bg-white mb-4 text-sm">
                        <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>⏳ Chờ xử lý</option>
                        <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>🚚 Đang giao</option>
                        <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>✅ Hoàn thành</option>
                        <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>❌ Đã hủy</option>
                    </select>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-black py-3 rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all shadow-lg shadow-blue-200 hover:-translate-y-0.5 flex items-center justify-center text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Lưu trạng thái
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-black text-slate-700 uppercase tracking-wider mb-4 pb-3 border-b border-slate-100">Tóm tắt</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Mã đơn hàng</span>
                        <span class="font-bold text-slate-800">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Số món</span>
                        <span class="font-bold text-slate-800">{{ $order->orderDetails->sum('quantity') }} ly</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Ngày đặt</span>
                        <span class="font-bold text-slate-800">{{ $order->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between pt-3 border-t border-slate-100">
                        <span class="text-slate-700 font-bold">Tổng tiền</span>
                        <span class="font-black text-blue-600">{{ number_format($order->total_price, 0, ',', '.') }}đ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
