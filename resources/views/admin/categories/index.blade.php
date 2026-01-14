@extends('admin.master')
@section('content')
@section('title', 'إدارة الأقسام')


<div class="container">

    {{-- Header + إحصائيات + زر إضافة --}}
    <div class="header">
        <div class="search-bar mb-3">
            <input id="searchByName" type="text" placeholder="الاسم" class="form-control" value="{{ $q ?? '' }}">

        </div>

        <a href="#" class="add-button">
            <i class="fas fa-plus"></i> إضافة قسم
        </a>
    </div>
    <div class="table-container">
        <table class="table category-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>صورة القسم</th>
                    <th>الرابط المختصر</th>
                    <th>الوصف</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody id="categoriesTbody">
                @include('admin.categories._rows', ['categories' => $categories])
            </tbody>

        </table>
        <div id="categoriesPagination" class="mt-3">
            {{ $categories->links() }}
        </div>

    </div>

</div>



@include('admin.categories._form')

<script>
    // عناصر المودال والحقول
    const modalOverlay = document.getElementById('modalOverlay');
    const modalTitle = document.getElementById('modalTitle');
    const categoryForm = document.getElementById('categoryForm');
    const methodSpoof = document.getElementById('methodSpoof');

    const openModalBtn = document.querySelector('.add-button');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const saveBtn = document.getElementById('saveBtn');

    const nameInput = document.getElementById('name');
    const descInput = document.querySelector('[name="description"]'); // textarea
    const imagePreview = document.getElementById('imagePreview');

    // ==========================
    // فتح المودال للإضافة
    // ==========================
    function openAddModal() {
        modalTitle.innerText = 'إضافة قسم جديد';
        categoryForm.reset();
        methodSpoof.value = ''; // POST
        categoryForm.action = "{{ route('categories.store') }}";
        imagePreview.src = '';
        imagePreview.style.display = 'none';

        if (window.CKEDITOR && CKEDITOR.instances.editor) {
            CKEDITOR.instances.editor.setData('');
        }

        modalOverlay.classList.add('active');
    }

    // ==========================
    // فتح المودال للتعديل
    // ==========================
    function openEditModal(btn) {
        modalTitle.innerText = 'تعديل القسم';

        nameInput.value = btn.dataset.name || '';
        descInput.value = btn.dataset.description || '';

        if (window.CKEDITOR && CKEDITOR.instances.editor) {
            CKEDITOR.instances.editor.setData(btn.dataset.description || '');
        }

        // صورة المعاينة
        if (btn.dataset.image) {
            imagePreview.src = btn.dataset.image;
            imagePreview.style.display = 'block';
        } else {
            imagePreview.src = '';
            imagePreview.style.display = 'none';
        }

        // تغيير الفورم
        categoryForm.action = btn.dataset.updateUrl; // استخدم data-update-url من Blade
        methodSpoof.value = 'PUT';

        modalOverlay.classList.add('active');
    }

    // ==========================
    // إغلاق المودال
    // ==========================
    function closeModal() {
        modalOverlay.classList.remove('active');
    }

    // ==========================
    // Event Listeners
    // ==========================
    if (openModalBtn) {
        openModalBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openAddModal();
        });
    }

    // تفويض أحداث لجميع أزرار التعديل (يعمل مع AJAX + Pagination)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.edit-btn');
        if (btn) {
            e.preventDefault();
            openEditModal(btn);
        }
    });

    // إغلاق
    closeModalBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', function(e) {
        if (e.target === modalOverlay) closeModal();
    });
    let isSubmitting = false;

    // حفظ البيانات
    saveBtn.addEventListener('click', function(e) {
        e.preventDefault();

        // منع الإرسال المتكرر
        if (isSubmitting) return;

        if (window.CKEDITOR && CKEDITOR.instances.editor) {
            CKEDITOR.instances.editor.updateElement();
        }

        if (!categoryForm.checkValidity()) {
            categoryForm.reportValidity();
            return;
        }

        // 🔒 قفل الإرسال
        isSubmitting = true;
        saveBtn.disabled = true;
        saveBtn.innerText = 'جاري الحفظ...';

        categoryForm.submit();
    });
</script>


<script>
    (function() {
        const input = document.getElementById('searchByName');
        const tbody = document.getElementById('categoriesTbody');
        const pagerBox = document.getElementById('categoriesPagination');
        const baseIndex = "{{ route('categories.index') }}";

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
