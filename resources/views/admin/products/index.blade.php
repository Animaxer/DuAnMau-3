@extends('admin.layout')

@section('title', 'Quản lý Sản phẩm')

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Quản lý Sản phẩm</h2>
            <p class="text-slate-500 text-sm mt-1">Tổng cộng <span class="font-bold text-slate-700">{{ $products->total() }}</span> sản phẩm trong hệ thống</p>
        </div>
        <a href="{{ route('admin.products.create') }}" 
            class="inline-flex items-center bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-bold px-5 py-2.5 rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all duration-200 shadow-lg shadow-blue-200 hover:shadow-blue-300 hover:-translate-y-0.5">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Thêm sản phẩm
        </a>
    </div>

    @if(session('success'))
        <div class="flex items-center bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl mb-6 shadow-sm">
            <svg class="w-5 h-5 mr-3 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Product Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider w-12">ID</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider w-16">Ảnh</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Tên sản phẩm</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Danh mục</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Giá bán</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($products as $product)
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold text-slate-400">#{{ $product->id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="w-12 h-12 rounded-xl overflow-hidden border border-slate-100 shadow-sm flex-shrink-0">
                                <img src="{{ $product->image_url ?: 'https://placehold.co/100x100?text=No+Img' }}"
                                    onerror="this.onerror=null; this.src='https://placehold.co/100x100?text=No+Img';"
                                    alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-bold text-slate-800 text-sm">{{ $product->name }}</p>
                                <p class="text-slate-400 text-xs mt-0.5 truncate max-w-[200px]">{{ $product->description }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1 rounded-full border border-blue-100">
                                {{ $product->category->name ?? 'Không có' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-black text-slate-800">{{ number_format($product->price, 0, ',', '.') }}<span class="text-slate-400 font-normal text-xs">đ</span></span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" 
                                    class="inline-flex items-center text-xs font-bold text-slate-600 hover:text-blue-600 bg-slate-100 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 px-3 py-1.5 rounded-lg transition-all duration-200">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Sửa
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" 
                                    onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="inline-flex items-center text-xs font-bold text-slate-600 hover:text-red-600 bg-slate-100 hover:bg-red-50 border border-slate-200 hover:border-red-200 px-3 py-1.5 rounded-lg transition-all duration-200">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                <p class="text-slate-400 font-semibold">Chưa có sản phẩm nào</p>
                                <a href="{{ route('admin.products.create') }}" class="mt-3 text-blue-500 font-bold text-sm hover:underline">Thêm sản phẩm đầu tiên →</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
            <p class="text-sm text-slate-500">Hiển thị {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} / {{ $products->total() }} sản phẩm</p>
            <div class="text-sm">{{ $products->links() }}</div>
        </div>
    </div>
@endsection
