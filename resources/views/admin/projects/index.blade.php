@extends('admin.master')
@section('title', 'إدارة المشاريع')
@section('content')

    @php
        use App\Enums\ProjectStatus;
    @endphp


    <div class="container">
        {{-- Header + إحصائيات --}}
        <div class="header-section mb-4">
            <div class="row align-items-center mb-4">
                <div class="col-lg-6">
                    <h2 class="mb-2 fw-bold text-primary">{{__('admin.project_management')}}</h2>
                    <p class="text-muted mb-0">{{ __('admin.manage_all_projects_in_system') }}</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <div class="search-container">
                        <div class="input-group" style="width: 300px;">
                            <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                            <input id="searchByName" type="text" placeholder="{{__('admin.search_projects')}}" class="form-control"
                                value="{{ $q ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="stats-section">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="stat-card card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center p-3">
                                <div class="stat-icon bg-primary text-white rounded me-3 d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-project-diagram"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-primary fw-bold">{{ $stats['total'] }}
                                    </h4>
                                    <small class="text-muted">{{__('admin.total_projects')}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center p-3">
                                <div class="stat-icon bg-warning text-white rounded me-3 d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-warning fw-bold">{{ $stats['pending'] }}</h4>

                                    <small class="text-muted">{{__('admin.pending_projects')}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center p-3">
                                <div class="stat-icon bg-success text-white rounded me-3 d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 text-success fw-bold">{{ $stats['approved'] }}</h4>

                                    <small class="text-muted">{{__('admin.approved_projects')}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table project-table">
                    <thead>
                        <tr>
                            <th style="white-space: nowrap; min-width: 50px;">#</th>
                            <th style="white-space: nowrap; min-width: 140px;">{{__('admin.main_project_image')}}</th>
                            <th style="min-width: 150px;">{{__('admin.project_title')}}</th>
                            <th style="min-width: 120px;">{{__('admin.category')}}</th>
                            <th style="min-width: 120px;">{{__('admin.borrower_name')}}</th>
                            <th style="white-space: nowrap; min-width: 120px;">{{__('admin.funding_goal')}} </th>
                            <th style="white-space: nowrap; min-width: 120px;">{{__('admin.funded_amount')}} </th>
                            <th style="white-space: nowrap; min-width: 100px;">{{__('admin.interest_rate_percent')}} </th>
                            <th style="white-space: nowrap; min-width: 120px;">{{ __('admin.term_in_months') }}</th>
                            <th style="white-space: nowrap; min-width: 120px;">{{__('admin.minimum_investment')}}</th>
                            <th style="min-width: 100px;">{{__('admin.status')}}</th>
                            <th style="min-width: 200px;">{{__('admin.summary')}} </th>
                            <th style="min-width: 200px;">{{__('admin.short_description')}}</th>
                            <th style="white-space: nowrap; min-width: 100px;">{{__('admin.actions')}}</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTbody">
                        @include('admin.projects._rows', ['projects' => $projects])
                    </tbody>

                </table>
                <div id="categoriesPagination" class="mt-3">
                    {{ $projects->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <!-- Modal for Add/Edit Project -->
            {{-- <div id="modalOverlay" class="modal-overlay">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="modalTitle">إضافة مشروع جديد</h5>
                        <button type="button" id="closeModalBtn" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="categoryForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" id="methodSpoof" value="">

                            <div class="mb-3">
                                <label for="title" class="form-label">عنوان المشروع</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">القطاع</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    <option value="">اختر القطاع</option>
                                    @foreach (\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="summary" class="form-label">ملخص المشروع</label>
                                <textarea class="form-control" id="summary" name="summary" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">وصف المشروع</label>
                                <textarea class="form-control" id="editor" name="description"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="funding_goal" class="form-label">مبلغ التمويل المطلوب</label>
                                <input type="number" class="form-control" id="funding_goal" name="funding_goal"
                                    step="0.01" required>
                            </div>

                            <div class="mb-3">
                                <label for="interest_rate" class="form-label">نسبة الفائدة (%)</label>
                                <input type="number" class="form-control" id="interest_rate" name="interest_rate"
                                    step="0.01" required>
                            </div>

                            <div class="mb-3">
                                <label for="term_months" class="form-label">مدة السداد (بالأشهر)</label>
                                <input type="number" class="form-control" id="term_months" name="term_months" required>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">صورة المشروع الرئيسية</label>
                                <input type="file" class="form-control" id="image" name="image"
                                    accept="image/*">
                                <img id="imagePreview" src="" alt="Preview"
                                    style="max-width: 200px; margin-top: 10px; display: none;">
                            </div>

                            <div class="mb-3">
                                <label for="gallery" class="form-label">معرض الصور (يمكن اختيار عدة صور)</label>
                                <input type="file" class="form-control" id="gallery" name="imageproduct[]"
                                    accept="image/*" multiple>
                            </div>

                            <div class="modal-footer">
                                <button type="button" id="cancelBtn" class="btn btn-secondary">إلغاء</button>
                                <button type="submit" id="saveBtn" class="btn btn-primary">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}

        </div>

        {{-- <script>
            // عناصر المودال والحقول
            const modalOverlay = document.getElementById('modalOverlay');
            const modalTitle = document.getElementById('modalTitle');
            const categoryForm = document.getElementById('categoryForm');
            const methodSpoof = document.getElementById('methodSpoof');

            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const saveBtn = document.getElementById('saveBtn');

            const titleInput = document.getElementById('title');
            const categoryInput = document.getElementById('category_id');
            const summaryInput = document.getElementById('summary');
            const fundingGoalInput = document.getElementById('funding_goal');
            const interestRateInput = document.getElementById('interest_rate');
            const termMonthsInput = document.getElementById('term_months');
            const descInput = document.getElementById('editor'); // textarea للوصف
            const imagePreview = document.getElementById('imagePreview');

            let currentProjectId = null;

            // فتح المودال
            function openModal(editMode = false, data = null) {
                modalOverlay.classList.add('active');

                if (editMode && data) {
                    modalTitle.textContent = 'تعديل المشروع';
                    currentProjectId = data.id;

                    titleInput.value = data.title || '';
                    categoryInput.value = data.category || '';
                    summaryInput.value = data.summary || '';
                    fundingGoalInput.value = data.funding_goal || '';
                    interestRateInput.value = data.interest_rate || '';
                    termMonthsInput.value = data.term_months || '';

                    // الوصف
                    if (window.CKEDITOR && CKEDITOR.instances.editor) {
                        CKEDITOR.instances.editor.setData(data.description || '');
                    } else {
                        descInput.value = data.description || '';
                    }

                    // الفورم -> Update
                    categoryForm.action = data.updateUrl;
                    methodSpoof.value = 'PUT';

                    // صورة
                    if (imagePreview) {
                        imagePreview.src = data.image ? `/storage/${data.image}` : '';
                        imagePreview.style.display = data.image ? 'block' : 'none';
                    }
                } else {
                    modalTitle.textContent = 'إضافة مشروع جديد';
                    currentProjectId = null;

                    categoryForm.reset();

                    if (window.CKEDITOR && CKEDITOR.instances.editor) {
                        CKEDITOR.instances.editor.setData('');
                    } else {
                        descInput.value = '';
                    }

                    categoryForm.action = "{{ route('projects.store') }}";
                    methodSpoof.value = '';

                    if (imagePreview) {
                        imagePreview.src = '';
                        imagePreview.style.display = 'none';
                    }
                }
            }

            function closeModal() {
                modalOverlay.classList.remove('active');
            }

            // زر إضافة
            const openModalBtn = document.querySelector('.add-button');
            if (openModalBtn) {
                openModalBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    openModal(false, null);
                });
            }

            // معاينة الصورة
            const imageInput = document.getElementById('image');
            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        imagePreview.src = '';
                        imagePreview.style.display = 'none';
                    }
                });
            }

            // زر تعديل
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.edit-btn');
                if (!btn) return;

                e.preventDefault();

                const data = {
                    id: btn.dataset.id,
                    title: btn.dataset.title,
                    category_id: btn.dataset.category_id,
                    summary: btn.dataset.summary,
                    description: btn.dataset.description || '',
                    funding_goal: btn.dataset.funding_goal,
                    interest_rate: btn.dataset.interest_rate,
                    term_months: btn.dataset.term_months,
                    image: btn.dataset.image,
                    updateUrl: btn.dataset.updateUrl
                };

                openModal(true, data);
            });

            // إغلاق
            closeModalBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);
            modalOverlay.addEventListener('click', (e) => {
                if (e.target === modalOverlay) closeModal();
            });

            // حفظ
            saveBtn.addEventListener('click', (e) => {
                e.preventDefault();

                if (window.CKEDITOR && CKEDITOR.instances.editor) {
                    CKEDITOR.instances.editor.updateElement();
                }

                if (categoryForm.checkValidity()) {
                    categoryForm.submit();
                } else {
                    categoryForm.reportValidity();
                }
            });
        </script> --}}

    <script>
            const PROJECTS_INDEX_URL = "{{ route('projects.index') }}";
        </script>
        <script src="{{ asset('assets/admin/project.js') }}"></script>

    @section('js')

    @endsection
@endsection
