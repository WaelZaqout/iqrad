<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'summary_en' => 'nullable|string|max:500',
            'summary_ar' => 'nullable|string|max:500',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'funding_goal' => 'required|numeric|min:0',
            'funded_amount' => 'nullable|numeric|min:0',
            'interest_rate' => 'required|numeric|min:1|max:50',
            'term_months' => 'required|integer|min:1',
            'status' => 'nullable|in:draft,pending,approved,funding,active,completed,defaulted',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120', // 5MB
            'gallery' => 'nullable|array|max:10', // أقصى عدد للصور
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',

        ];
    }
}
