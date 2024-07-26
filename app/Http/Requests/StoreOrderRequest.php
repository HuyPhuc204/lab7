<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'customer' => 'array|required_array_keys:customer_name,address,phone,email',
            'customer.customer_name' => 'required',
            'customer.address' => 'required',
            'customer.phone' => 'required|unique:customers,phone',
            'customer.email' => 'required|email|unique:customers,email',

            'supplier' => 'array|required_array_keys:supplier_name,address,phone,email',
            'supplier.supplier_name' => 'required',
            'supplier.address' => 'required',
            'supplier.phone' => 'required|unique:customers,phone',
            'supplier.email' => 'required|email|unique:customers,email',

            'products' => 'array',
            'products.*' => 'array|required_array_keys:product_name,description,price,quantity',
            'products.*.product_name' => 'required|unique:products,product_name',
            'products.*.description' => 'required',
            'products.*.image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'products.*.price' => 'required|integer|min:0',
            'products.*.quantity' => 'required|integer|min:0',

            'order_details' => 'array',
            'order_details.*' => 'array|required_array_keys:quantity',
            'order_details.*.quantity' => 'required|integer|min:0',
        ];
    }
}
