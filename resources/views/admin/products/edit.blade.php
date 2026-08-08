@extends('admin.layout')

@section('title', 'Sửa Sản phẩm')

@section('content')
    <!-- Back Link -->
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-800 transition group">
            <svg class="w-4 h-4 mr-1.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Quay lại danh sách
        </a>
    </div>

    <!-- Page Header -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Chỉnh sửa Sản phẩm</h2>
            <p class="text-slate-500 text-sm mt-1">Cập nhật thông tin sản phẩm: <span class="font-bold text-slate-700">{{ $product->name }}</span></p>
        </div>
        <span class="text-xs font-bold text-slate-400 bg-slate-100 px-3 py-1.5 rounded-xl">#{{ $product->id }}</span>
    </div>

    @if(session('success'))
        <div class="flex items-center bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl mb-6">
            <svg class="w-5 h-5 mr-3 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="flex items-start bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6">
            <svg class="w-5 h-5 mr-3 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <p class="font-bold text-sm mb-1">Vui lòng kiểm tra lại thông tin:</p>
                <ul class="list-disc list-inside text-sm space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form id="update-form" action="{{ route('admin.products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-sm font-black text-slate-700 uppercase tracking-wider mb-5 pb-3 border-b border-slate-100">Thông tin cơ bản</h3>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tên sản phẩm <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition text-slate-800 font-medium">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Mô tả</label>
                            <textarea name="description" rows="4" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition text-slate-800 font-medium resize-none">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Image Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-sm font-black text-slate-700 uppercase tracking-wider mb-5 pb-3 border-b border-slate-100">Hình ảnh</h3>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Đường dẫn hình ảnh (URL)</label>
                        <input type="text" name="image_url" id="image_url_input" value="{{ old('image_url', $product->image_url) }}" 
                            oninput="previewImage(this.value)"
                            placeholder="https://images.unsplash.com/..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition text-slate-800 font-medium">
                        
                        <!-- Image Preview -->
                        <div class="mt-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Xem trước</p>
                            <div class="flex items-start space-x-4">
                                <img id="preview-img" 
                                    src="{{ $product->image_url ?: 'https://placehold.co/200x200?text=No+Image' }}"
                                    onerror="this.src='https://placehold.co/200x200?text=No+Image'"
                                    alt="Preview" class="w-28 h-28 rounded-xl object-cover border-2 border-white shadow-md">
                                <div class="text-xs text-slate-400 leading-relaxed mt-1">
                                    <p class="font-semibold text-slate-600 mb-1">{{ $product->name }}</p>
                                    <p>Nhập URL mới vào ô bên trên để thay đổi ảnh. Ảnh xem trước sẽ cập nhật ngay lập tức.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Pricing & Category Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-sm font-black text-slate-700 uppercase tracking-wider mb-5 pb-3 border-b border-slate-100">Phân loại & Giá</h3>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Danh mục <span class="text-red-500">*</span></label>
                            <select name="category_id" required 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition text-slate-800 font-medium bg-white">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Giá bán (VNĐ) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" 
                                    class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition text-slate-800 font-bold">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">đ</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-3">
                    <button type="submit" form="update-form"
                        class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-black py-3.5 px-6 rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all duration-200 shadow-lg shadow-blue-200 hover:shadow-blue-300 hover:-translate-y-0.5 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Lưu thay đổi
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="block text-center text-sm font-semibold text-slate-400 hover:text-slate-600 transition">Hủy và quay lại</a>

                    <!-- Danger Zone -->
                    <div class="pt-3 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Vùng nguy hiểm</p>
                        <button type="submit" form="delete-form"
                            onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn sản phẩm này?')"
                            class="w-full inline-flex items-center justify-center text-sm font-bold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 hover:border-red-300 py-2.5 px-4 rounded-xl transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Xóa sản phẩm này
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Form xóa sản phẩm (tách riêng khỏi form cập nhật để tránh nested form) --}}
    <form id="delete-form" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function previewImage(url) {
            const img = document.getElementById('preview-img');
            if (url) {
                img.src = url;
                img.onerror = () => { img.src = 'https://placehold.co/200x200?text=No+Image'; };
            } else {
                img.src = 'https://placehold.co/200x200?text=No+Image';
            }
        }
    </script>
@endsection
