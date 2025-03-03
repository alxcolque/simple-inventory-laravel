<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'product_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'price' => 'required|numeric',
            'price_sale' => 'required|numeric',
            'qty' => 'required|numeric',
            'unit' => 'required|string',
            'expiration_date' => 'nullable|date',
            'created_at' => 'required|date',
            //'iva' => 'boolean',
        ];
    }
}
