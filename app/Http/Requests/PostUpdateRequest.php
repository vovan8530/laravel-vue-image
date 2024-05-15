<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3'],
            'content' => ['nullable', 'string', 'min:3'],
            'images' => ['nullable', 'array'],
            'image_ids_delete' => ['nullable', 'array'],
            'image_urls_delete' => ['nullable', 'array'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
