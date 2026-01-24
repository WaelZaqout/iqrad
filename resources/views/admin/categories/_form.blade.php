    <!-- Responsive Modal -->
    <div id="modalOverlay" class="modal-overlay">
        <div class="custom-modal">
            <div class="modal-header">
                <h3 id="modalTitle" class="modal-title">{{ __('admin.add_new_category') }}</h3>
                <button id="closeModalBtn" class="close-btn">&times;</button>
            </div>

            <div class="modal-body">
                {{-- {{ __('admin.note_dynamic_method') }} --}}
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data"
                    id="categoryForm">
                    @csrf
                    <input type="hidden" id="methodSpoof" name="_method" value=""> {{-- 'PUT' عند التعديل --}}
                    <input type="hidden" id="formAction" value="{{ route('categories.store') }}"> {{-- للتبديل JS --}}

                    <div class="form-grid">
                        {{-- الاسم --}}
                        <div class="form-group has-icon">
                            <label class="form-label" for="name_en">
                                <i class="fas fa-tag me-2"></i> {{ __('admin.category_name_en') }}
                            </label>
                            <input type="text" id="name_en" name="name_en"
                                class="form-control @error('name_en') is-invalid @enderror"
                                    placeholder=" {{ __('admin.category_name_en') }} " value="{{ old('name_en') }}" required>
                            @error('name_en')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group has-icon">
                            <label class="form-label" for="name_ar">
                                <i class="fas fa-tag me-2"></i> {{ __('admin.category_name_ar') }}
                            </label>
                            <input type="text" id="name_ar" name="name_ar"
                                class="form-control @error('name_ar') is-invalid @enderror"
                                placeholder=" {{ __('admin.category_name_ar') }} " value="{{ old('name_ar') }}" required>
                            @error('name_ar')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group full-width ">
                            <label class="form-label" for="image">
                                <i class="fas fa-image me-2"></i>{{ __('admin.category_image') }}
                            </label>
                            <input type="file" id="image" name="image"
                                class="form-control @error('image') is-invalid @enderror" value="{{ old('image') }}">
                            @error('image')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror

                            <div class="mt-2">
                                <img id="imagePreview" src="" alt="{{ __('admin.image_preview') }}"
                                    style="width: 120px; height: 120px; object-fit: cover; display: none; border:1px solid #ccc; padding:4px; border-radius:6px;">
                            </div>
                        </div>

                        {{-- الوصف --}}
                        <div class="form-group has-icon">
                            <label for="description_en">
                                <i class="fas fa-newspaper me-2"></i> {{ __('admin.category_description_en') }}
                            </label>
                            <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror" rows="8">{{ old('description_en', $category->description_en ?? '') }}</textarea>
                            @error('description_en')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group has-icon ">
                            <label for="description_ar">
                                <i class="fas fa-newspaper me-2"></i> {{ __('admin.category_description_ar') }}
                            </label>
                            <textarea name="description_ar" class="form-control @error('description_ar') is-invalid @enderror" rows="8">{{ old('description_ar', $category->description_ar ?? '') }}</textarea>
                            @error('description_ar')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="cancelBtn" class="btn btn-secondary">{{ __('admin.cancel') }}</button>
                <button id="saveBtn" type="button" class="btn btn-primary">{{ __('admin.save') }}</button>
            </div>
        </div>
    </div>
