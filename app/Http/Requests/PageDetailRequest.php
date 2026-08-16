<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PageDetailRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'slug' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keywords' => 'required|string',
            'sections' => 'nullable|array',
            'sections.*.id' => 'nullable|integer|exists:page_sections,id',
            'sections.*.section_name' => 'nullable|string',
            'sections.*.content' => 'nullable|array',
            'sections.*.content.*' => 'nullable',
            'sections.*.order' => 'nullable|integer',
            'sections.*.type' => 'nullable|string',
            'sections.*.title' => 'nullable|string',
            'sections.*.body' => 'nullable|string',
            'sections.*.is_visible' => 'nullable|boolean',
            'robots' => 'nullable|string',
            'status' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'slug.required' => 'Slug is required',
            'meta_description.required' => 'Meta description is required',
            'meta_keywords.required' => 'Meta keywords is required',
        ];
    }
}
