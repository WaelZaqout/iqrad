    function createProject() {
        // إعادة ضبط الحقول
        const form = document.getElementById('projectForm');
        form.reset();
        form.action = "{{ route('projects.store') }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('fundingModalLabel').innerText = 'نموذج طلب التمويل';
        document.getElementById('submitBtn').innerText = 'إرسال طلب التمويل';
        // ضبط رسالة النجاح
        document.getElementById('successModal').querySelector('h3').innerText = 'تم إرسال مشروعك بنجاح!';
        document.getElementById('successModal').querySelector('p').innerText =
            'سيتم مراجعة طلبك خلال 48 ساعة، وستصلك إشعارات بالتحديثات.';
    }

    function editProject(button) {
        const form = document.getElementById('projectForm');
        const id = button.getAttribute('data-id');
        const title_en = button.getAttribute('data-title_en');
        const title_ar = button.getAttribute('data-title_ar');
        const category_id = button.getAttribute('data-category_id');
        const funding_goal = button.getAttribute('data-funding_goal');
        const term_months = button.getAttribute('data-term_months');
        const interest_rate = button.getAttribute('data-interest_rate');
        const min_investment = button.getAttribute('data-min_investment');
        const summary_en = button.getAttribute('data-summary_en');
        const summary_ar = button.getAttribute('data-summary_ar');
        const description_en = button.getAttribute('data-description_en');
        const description_ar = button.getAttribute('data-description_ar');

        // ملء الحقول
        document.getElementById('title_en').value = title_en;
        document.getElementById('title_ar').value = title_ar;
        document.getElementById('category_id').value = category_id;
        document.getElementById('funding_goal').value = funding_goal;
        document.getElementById('term_months').value = term_months;
        document.getElementById('interest_rate').value = interest_rate;
        document.getElementById('min_investment').value = min_investment;
        document.getElementById('summary_en').value = summary_en;
        document.getElementById('summary_ar').value = summary_ar;
        document.getElementById('description_en').value = description_en;
        document.getElementById('description_ar').value = description_ar;

        // تغيير action للفورم ليصبح PUT
        form.action = `/projects/${id}`;
        document.getElementById('formMethod').value = 'PUT';

        // تغيير نصوص المودال
        document.getElementById('fundingModalLabel').innerText = 'تعديل طلب التمويل';
        document.getElementById('submitBtn').innerText = 'تعديل المشروع';

        // ضبط رسالة النجاح الخاصة بالتعديل
        document.getElementById('successModal').querySelector('h3').innerText = 'تم تعديل المشروع بنجاح!';
        document.getElementById('successModal').querySelector('p').innerText =
            'تم تعديل المشروع بنجاح! بانتظار الموافقة.';
        var modal = new bootstrap.Modal(document.getElementById('fundingModal'));
        modal.show();

    }
