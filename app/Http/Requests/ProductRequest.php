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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'quantity' => 'required|integer',
            'buyingPrice' => 'required|numeric',
            'sellingPrice' => 'required|numeric',
            'description' => 'nullable',
            'image_url' => 'nullable',
            'weight' => 'nullable|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('The name field is required.'),
            'quantity.required' => __('The quantity field is required.'),
            'quantity.integer' => __('The quantity must be an integer.'),
            'buyingPrice.required' => __('The buying price field is required.'),
            'buyingPrice.numeric' => __('The buying price must be a numeric value.'),
            'sellingPrice.required' => __('The selling price field is required.'),
            'sellingPrice.numeric' => __('The selling price must be a numeric value.'),
            'weight.numeric' => __('The weight must be a numeric value.'),
        ];
    }
}
