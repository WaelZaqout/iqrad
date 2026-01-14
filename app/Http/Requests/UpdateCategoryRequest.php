<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Category $category): array
    {
        return [
            'name'        => 'required|string|max:255',
            'parent_id'   => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:10240', // 10MB
            'description' => 'nullable|string',
        ];
    }
}
