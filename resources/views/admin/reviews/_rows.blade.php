{{-- resources/views/admin/reviews/_rows.blade.php --}}
@php
    use Illuminate\Support\Str;
@endphp

@forelse ($reviews as $review)
    <tr>
        {{-- رقم تسلسلي --}}
        <td>{{ $loop->iteration }}</td>
        <td class="project">{{ $review->project->name ?? $review->project_id }}</td>
        <td class="user">{{ $review->user->name ?? $review->user_id }}</td>
        <td class="rating">{{ $review->rating }}</td>
        <td class="comment">{{ $review->comment }}</td>

        </div>
        </td>


        {{-- الأكشن --}}
        <td class="actions">

            {{-- زر حذف --}}
            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline-block delete-form">
                @csrf
                @method('delete')
                <button type="submit" class="btn-action btn-delete" title="حذف">
                    <i class="fas fa-trash"></i>
                </button>
            </form>

        </td>
    </tr>

@empty
    <tr>
        <td colspan="13" class="text-center text-muted">لا توجد نتائج مطابقة.</td>
    </tr>
@endforelse
<script>
    function handleStatusChange(select) {
        var form = select.closest('form');
        var prev = select.dataset.prev || select.getAttribute('data-prev');
        var newVal = select.value;

        if (confirm('هل أنت متأكد من تغيير حالة المشروع؟')) {
            // update badge immediately for better UX (server will be source of truth)
            var tr = select.closest('tr');
            var badge = tr.querySelector('[id^="badge-"]');
            if (badge) {
                badge.className = 'badge me-2 bg-' + (newVal === 'active' ? 'success' : 'warning');
                badge.textContent = (newVal === 'active' ? 'نشط' : 'غير نشط');

            }
            select.dataset.prev = newVal;
            form.submit();
        } else {
            // revert selection if cancelled
            select.value = prev;
        }
    }
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('هل أنت متأكد من الحذف؟')) e.preventDefault();
        });
    });
</script>
