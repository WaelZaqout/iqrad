{{-- resources/views/admin/categories/_rows.blade.php --}}
@php
    use Illuminate\Support\Str;
@endphp

@forelse ($categories as $category)
    <tr>
        {{-- # --}}
        <td>{{ $categories->firstItem() + $loop->index }}</td>
        <td>
            @if ($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" width="40">
            @else
                <span class="text-muted">—</span>
            @endif
        </td>
        {{-- الاسم --}}
        <td class="name">{{ $category->name }}</td>


        {{-- السلاج --}}
        <td class="slug">{{ $category->slug }}</td>

        {{-- الوصف (مختصر) --}}
        <td class="description">
            {{ Str::limit(strip_tags($category->description), 50) }}
        </td>


        {{-- الإجراءات --}}
        <td class="actions">
            <a href="#" class="edit-btn btn-action btn-edit" title="تعديل" data-id="{{ $category->id }}"
                data-name_en="{{ $category->name_en }}" data-name_ar="{{ $category->name_ar }}"
                data-description_en="{{ e($category->description_en) }}"
                data-description_ar="{{ e($category->description_ar) }}"
                data-image="{{ $category->image ? asset('storage/' . $category->image) : '' }}"
                data-update-url="{{ route('categories.update', $category->id) }}">
                <i class="fas fa-edit"></i>
            </a>


            <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
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
    <tr
        <td colspan="8" class="text-center text-muted">{{ __('admin.no_matching_results') }}</td>
    </tr>
@endforelse
