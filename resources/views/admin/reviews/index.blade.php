@extends('admin.master')
@section('content')
@section('title', 'إدارة الاراء')

<div class="container">
    {{-- Header + إحصائيات --}}
    <div class="header-section mb-4">
        <div class="row align-items-center mb-4">
            <div class="col-lg-6">
                <h2 class="mb-2 fw-bold text-primary">إدارة الاراء</h2>
                <p class="text-muted mb-0">إدارة ومراقبة جميع الاراء في النظام</p>
            </div>
            <div class="col-lg-6 text-lg-end">
                <div class="search-container">
                    <div class="input-group" style="width: 300px;">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input id="searchByName" type="text" placeholder="البحث في الاراء..." class="form-control"
                            value="{{ $q ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table review-table">
                <thead>
                    <tr>
                        <th style="white-space: nowrap; min-width: 50px;">#</th>
                        <th style="min-width: 120px;">رقم المشروع</th>
                        <th style="min-width: 150px;">اسم المستثمر</th>
                        <th style="min-width: 120px;">التقييم </th>
                        <th style="min-width: 100px;">التعليق </th>
                        <th style="white-space: nowrap; min-width: 100px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="categoriesTbody">
                    @include('admin.reviews._rows', ['reviews' => $reviews])
                </tbody>

                <div id="categoriesPagination" class="mt-3">
                    {!! $reviews->links() !!}
                </div>

            </table>
        </div>


    </div>

    <script>
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

                categoryForm.action = "{{ route('reviews.store') }}";
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
                name: btn.dataset.name,
                description: btn.dataset.description || '',
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
    </script>


    <script>
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];

            $.ajax({
                url: '?page=' + page,
                success: function(data) {
                    $('#tableData').html(data);
                }
            });
        });
    </script>
    <script>
        (function() {
            const input = document.getElementById('searchByName');
            const tbody = document.getElementById('categoriesTbody');
            const pagerBox = document.getElementById('categoriesPagination');
            const baseIndex = "{{ route('reviews.index') }}";

            let timer = null;

            function runSearch(url) {
                const finalUrl = new URL(url || baseIndex, window.location.origin);
                // ضمّن قيمة البحث الحالية في الرابط
                const q = (input?.value || '').trim();
                if (q !== '') finalUrl.searchParams.set('q', q);
                else finalUrl.searchParams.delete('q');

                // حالة تحميل بسيطة
                if (input) input.disabled = true;

                fetch(finalUrl.toString(), {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (tbody && data.rows !== undefined) {
                            tbody.innerHTML = data.rows;
                        }
                        if (pagerBox && data.pagination !== undefined) {
                            pagerBox.innerHTML = data.pagination;
                        }
                        // حدّث شريط العنوان بدون إعادة تحميل
                        if (window.history && window.history.replaceState) {
                            window.history.replaceState({}, '', finalUrl.toString());
                        }
                    })
                    .catch(() => {
                        // تقدر تعرض Toast خطأ هنا لو عندك util
                        console.error('Search failed');
                    })
                    .finally(() => {
                        if (input) input.disabled = false;
                    });
            }

            // Debounce on input
            if (input) {
                input.addEventListener('input', function() {
                    clearTimeout(timer);
                    timer = setTimeout(() => runSearch(baseIndex), 300);
                });
            }

            // AJAX pagination (تفويض أحداث)
            document.addEventListener('click', function(e) {
                const a = e.target.closest('#categoriesPagination a');
                if (!a) return;
                e.preventDefault();
                runSearch(a.href);
            });


        })();
    </script>

    @section('js')
    @endsection
@endsection
