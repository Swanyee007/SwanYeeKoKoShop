<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'parent_id' => [
                'nullable',
                'exists:categories,id',
            ],

            'image' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                File::image(),
            ],
        ];
    }
}
