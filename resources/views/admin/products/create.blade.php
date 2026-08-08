@extends('admin.layout')

@section('title', 'Thêm Sản phẩm')

@section('content')
    <!-- Back Link -->
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-800 transition group">
            <svg class="w-4 h-4 mr-1.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Quay lại danh sách
        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-black text-slate-800">Thêm Sản phẩm Mới</h2>
        <p class="text-slate-500 text-sm mt-1">Điền đầy đủ thông tin để tạo sản phẩm mới trong thực đơn</p>
    </div>

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

    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-sm font-black text-slate-700 uppercase tracking-wider mb-5 pb-3 border-b border-slate-100">Thông tin cơ bản</h3>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tên sản phẩm <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Ví dụ: Trà Đào Cam Sả" required 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition placeholder-slate-300 text-slate-800 font-medium">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Mô tả</label>
                            <textarea name="description" rows="4" placeholder="Mô tả hương vị, thành phần nổi bật của sản phẩm..." 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition placeholder-slate-300 text-slate-800 font-medium resize-none">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Image Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-sm font-black text-slate-700 uppercase tracking-wider mb-5 pb-3 border-b border-slate-100">Hình ảnh</h3>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Đường dẫn hình ảnh (URL)</label>
                        <input type="text" name="image_url" id="image_url_input" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/..." 
                            oninput="previewImage(this.value)"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition placeholder-slate-300 text-slate-800 font-medium">
                        <div id="img-preview" class="mt-3 hidden">
                            <img id="preview-img" src="" alt="Preview" class="h-32 w-auto rounded-xl border border-slate-200 shadow-sm object-cover">
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
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Giá bán (VNĐ) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" name="price" value="{{ old('price') }}" placeholder="35000" required min="0" 
                                    class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition placeholder-slate-300 text-slate-800 font-bold">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">đ</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-black py-3.5 px-6 rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all duration-200 shadow-lg shadow-blue-200 hover:shadow-blue-300 hover:-translate-y-0.5 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tạo sản phẩm
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="block text-center mt-3 text-sm font-semibold text-slate-400 hover:text-slate-600 transition">Hủy và quay lại</a>
                </div>
            </div>
        </div>
    </form>

    <script>
        function previewImage(url) {
            const preview = document.getElementById('img-preview');
            const img = document.getElementById('preview-img');
            if (url) {
                img.src = url;
                preview.classList.remove('hidden');
                img.onerror = () => preview.classList.add('hidden');
            } else {
                preview.classList.add('hidden');
            }
        }
    </script>
@endsection
