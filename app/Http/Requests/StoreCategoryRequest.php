<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name_en'        => 'required|string|max:255',
            'name_ar'        => 'required|string|max:255',
            'parent_id'   => 'nullable|exists:categories,id',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
        ];
    }
}
