{{-- resources/views/admin/investors/_rows.blade.php --}}
@php
    use Illuminate\Support\Str;
@endphp

@forelse ($investors as $investor)
    <tr>
        {{-- رقم تسلسلي --}}
        <td>{{ $loop->iteration }}</td>

        {{-- صورة المشروع --}}
        {{-- <td style="min-width: 140px;">
            <div id="carousel-{{ $investor->id }}" class="carousel slide" data-bs-ride="carousel" style="width:120px;">
                <div class="carousel-inner">
                    @if ($investor->image)
                        <div class="carousel-item active">
                            <img src="{{ asset('storage/' . $investor->image) }}" alt="{{ $investor->name }}"
                                style="width:120px; height:100px; object-fit:cover; border-radius:6px;">
                        </div>
                    @endif
                    @foreach ($investor->images as $img)
                        <div class="carousel-item">
                            <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $investor->name }}"
                                style="width:120px; height:100px; object-fit:cover; border-radius:6px;">
                        </div>
                    @endforeach
                </div>
                @if (count($investor->images) > 0 || $investor->image)
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $investor->id }}"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $investor->id }}"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                @endif
            </div>
        </td> --}}

        {{-- اسم المشروع --}}
        <td class="title"><a href="{{ route('investors.show', $investor->id) }}">{{ $investor->name }}</a></td>
        <td class="email">{{ $investor->email }}</td>
        <td class="phone">{{ $investor->phone }}</td>
        <td class="created_at">{{ $investor->created_at->format('Y-m-d H:i') }}</td>

        {{-- نوع القطاع (اسم وليس رقم) --}}
        <td class="role">
            {{ $investor->role === 'investor' ? 'مستثمر' : ($investor->role === 'borrower' ? 'مقترض' : 'غير محدد') }}
        </td>


        {{-- الحالة --}}
        <td class="status">
            <div class="d-flex align-items-center">
                @php
                    $badgeClass =
                        $investor->status == 'active'
                            ? 'success'
                            : ($investor->status == 'inactive'
                                ? 'warning'
                                : 'danger');
                    $statusLabel =
                        $investor->status == 'inactive'
                            ? 'غير نشط'
                            : ($investor->status == 'active'
                                ? ' نشط'
                                : 'مرفوض');
                @endphp
                <span id="badge-{{ $investor->id }}" class="badge me-2 bg-{{ $badgeClass }}">{{ $statusLabel }}</span>

                <form action="{{ route('admin.investors.updateStatus', $investor->id) }}" method="POST"
                    style="margin:0;">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="form-select form-select-sm" style="min-width: 140px;"
                        data-prev="{{ $investor->status }}" onchange="handleStatusChange(this)">
                        <option value="inactive" {{ $investor->status == 'inactive' ? 'selected' : '' }}>غير نشط
                        </option>
                        <option value="active" {{ $investor->status == 'active' ? 'selected' : '' }}>نشط
                        </option>
                    </select>
                </form>
            </div>
        </td>


        {{-- الأكشن --}}
        <td class="actions">

            {{-- زر حذف --}}
            <form action="{{ route('investors.destroy', $investor->id) }}" method="POST"
                class="d-inline-block delete-form">
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
        <td colspan="13" class="text-center text-muted">{{ __('admin.no_matching_results') }}</td>
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
