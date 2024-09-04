<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The product name is required.',
            'name.string' => 'The product name must be a string.',
            'name.max' => 'The product name may not be greater than 255 characters.',
            'price.required' => 'The product price is required.',
            'price.numeric' => 'The product price must be a number.',
            'price.min' => 'The product price must be at least 0.',
            'stock.required' => 'The product stock is required.',
            'stock.integer' => 'The product stock must be an integer.',
            'stock.min' => 'The product stock must be at least 0.',
        ];
    }
}
