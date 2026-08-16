<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'slug' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,heic,heif,svg|max:35840',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'read_time' => 'nullable|string|max:100',
            'is_published' => 'nullable|boolean',
            'status' => 'nullable|string',
        ];
    }
}
