<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        //si el metodo es put, se elimina la regla unique
        if ($this->isMethod('put')) {
            $unique = '';
        } else {
            $unique = '|unique:products,code';
        }
        return [
            'category_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255' . $unique,
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
