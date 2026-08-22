<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            "code_no"=>'required',
            'name'=>'required',
            'image'=> 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'price'=>'required',
             'in_stock'=> 'required|boolean',
            'description'=>'required',
            'category_id'=>'required',
        ];
    }
}
