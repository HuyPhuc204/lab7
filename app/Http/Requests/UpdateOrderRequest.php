<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'customer.phone' => 'required',
            'customer.email' => 'required|email',

            'supplier' => 'array|required_array_keys:supplier_name,address,phone,email',
            'supplier.supplier_name' => 'required',
            'supplier.address' => 'required',
            'supplier.phone' => 'required',
            'supplier.email' => 'required|email',

            'products' => 'array',
            'products.*' => 'array|required_array_keys:id,product_name,description,price,quantity',
            'products.*.id' => 'required',
            'products.*.product_name' => 'required',
            'products.*.description' => 'required',
            'products.*.image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'products.*.price' => 'required|integer|min:0',
            'products.*.quantity' => 'required|integer|min:0',

            'order_details' => 'array',
            'order_details.*' => 'array|required_array_keys:quantity',
            'order_details.*.quantity' => 'required|integer|min:1',
        ];
    }
}
