<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminProjectRequest extends FormRequest
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
        $isStore = $this->isMethod('post');

        return [
            'title' => $isStore ? 'required|string|max:255' : 'sometimes|required|string|max:255',
            'category' => 'nullable|string|in:web,mobile,desktop,other',
            'year' => 'nullable|integer|min:1900|max:2100',
            'description' => 'nullable|string',
            'tech' => 'nullable|string',
            'role' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'client' => 'nullable|string|max:255',
            'client_url' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            'comment_name' => 'nullable|string|max:255',
            'comment_position' => 'nullable|string|max:255',
            'comment_text' => 'nullable|string',
            'status' => 'nullable|string',
            'featured' => 'nullable|boolean',
            'view_type' => 'nullable|string|in:live,preview',
            'live_url' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'github_url' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,heic,heif|max:35840',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg,heic,heif|max:10240',
            'sections' => 'nullable|array',
            'sections.*.type' => 'nullable|string',
            'sections.*.order' => 'nullable|integer',
            'sections.*.is_visible' => 'nullable|boolean',
            'sections.*.title' => 'nullable|string',
            'sections.*.body' => 'nullable|string',
            'sections.*.header' => 'nullable|string',
            'sections.*.paragraph' => 'nullable|string',
            'sections.*.headline' => 'nullable|string',
            'sections.*.subheadline' => 'nullable|string',
            'sections.*.roles' => 'nullable|string',
            'sections.*.tags' => 'nullable|string',
            'sections.*.btn_text' => 'nullable|string',
            'sections.*.btn_url' => 'nullable|string',
            'sections.*.code' => 'nullable|string',
            'sections.*.name' => 'nullable|string',
            'sections.*.position' => 'nullable|string',
            'sections.*.comment' => 'nullable|string',
            'sections.*.comment_name' => 'nullable|string',
            'sections.*.comment_position' => 'nullable|string',
            'sections.*.comment_text' => 'nullable|string',
            'sections.*.metrics' => 'nullable|array',
            'sections.*.metrics.*.key' => 'nullable|string',
            'sections.*.metrics.*.value' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The project title is required.',
            'category.in' => 'Please select a valid project category.',
            'year.integer' => 'Year must be a valid integer.',
            'image.image' => 'Cover image must be a valid image file.',
            'image.max' => 'Cover image size must not exceed 5MB.',
        ];
    }
}
