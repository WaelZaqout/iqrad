<!-- Responsive Modal -->
<div id="modalOverlay" class="modal-overlay">
    <div class="custom-modal">
        <div class="modal-header">
            <h3 id="modalTitle" class="modal-title">إضافة قسم جديد</h3>
            <button id="closeModalBtn" class="close-btn">&times;</button>
        </div>

        <div class="modal-body">
            {{-- ملاحظة: سيُستبدل الـaction و _method ديناميكياً عند التعديل --}}
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data"
                id="categoryForm">
                @csrf
                <input type="hidden" id="methodSpoof" name="_method" value=""> {{-- 'PUT' عند التعديل --}}
                <input type="hidden" id="formAction" value="{{ route('categories.store') }}"> {{-- للتبديل JS --}}

                <div class="form-grid">
                    {{-- الاسم --}}
                    <div class="form-group full-width">
                        <label class="form-label" for="name">
                            <i class="fas fa-tag me-2"></i>اسم القسم
                        </label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="أدخل اسم القسم"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- الرابط المختصر (slug) --}}
                    {{-- <div class="form-group has-icon">
                        <label class="form-label" for="slug">
                            <i class="fas fa-link me-2"></i>الرابط المختصر
                        </label>
                        <input type="text" id="slug" name="slug"
                            class="form-control @error('slug') is-invalid @enderror"
                            placeholder="أدخل الرابط المختصر (مثال: web-development)" value="{{ old('slug') }}"
                            >
                        @error('slug')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <div class="form-group full-width ">
                        <label class="form-label" for="image">
                            <i class="fas fa-image me-2"></i>صورة القسم
                        </label>
                        <input type="file" id="image" name="image"
                            class="form-control @error('image') is-invalid @enderror" value="{{ old('image') }}">
                        @error('image')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror

                        <div class="mt-2">
                            <img id="imagePreview" src="" alt="معاينة الصورة"
                                style="width: 120px; height: 120px; object-fit: cover; display: none; border:1px solid #ccc; padding:4px; border-radius:6px;">
                        </div>
                    </div>


                    {{-- التصنيف الأب --}}
                    {{-- <div class="form-group has-icon">
                        <label class="form-label" for="parent_id">
                            <i class="fas fa-sitemap me-2"></i>التصنيف الأب
                        </label>
                        <select
                            id="parent_id"
                            name="parent_id"
                            class="form-control @error('parent_id') is-invalid @enderror"
                            {{ !auth()->user()->can('إضافة تصنيف') && !auth()->user()->can('تعديل تصنيف') ? 'disabled' : '' }}
                        >
                            <option value="">— جذر —</option>
                            @foreach ($parents ?? [] as $p)
                                <option value="{{ $p->id }}" {{ old('parent_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div> --}}


                    {{-- الوصف --}}
                    <div class="form-group full-width">
                        <label for="description">
                            <i class="fas fa-newspaper me-2"></i>وصف القسم
                        </label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                            rows="8">{{ old('description', $category->description ?? '') }}</textarea>
                        @error('description')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button id="cancelBtn" class="btn btn-secondary">إلغاء</button>
           <button id="saveBtn" type="button" class="btn btn-primary">حفظ</button>
        </div>
    </div>
</div>
