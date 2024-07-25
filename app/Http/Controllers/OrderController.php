<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        DB::transaction(function () use ($request) {
            $price = [];
            $quantity = [];
            $productIds = [];
            $customer = Customer::create($request->validated()['customer']);
            $supplier =Supplier::create($request->validated()['supplier']);

            foreach ($request->validated()['products'] as $productData) {
                $product = Product::create([
                    'product_name' => $productData['product_name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'quantity' => $productData['quantity'],
                    'supplier_id' => $supplier->id,
                ]);
                $price[] = $productData['price'];
                $productIds[] = $product->id;
            }
            foreach ($request->validated()['order_details'] as $data) {
                $quantity[] = $data['quantity'];
            }
            $totalPrice = $price[0]*$quantity[0] + $price[1]*$quantity[1];
            $order = Order::create([
                'customer_id' => $customer->id,
                'total_price' => $totalPrice,
            ]);

            foreach ($request->validated()['order_details'] as $key => $data) {
                $quantity[] = $data['quantity'];
                DB::table('order_details')->insert([
                    'order_id' => $order->id,
                    'product_id' => $productIds[$key],
                    'quantity' => $data['quantity'],
                    'price' => $price[$key],
                ]);
            }
        });

        session()->flash('success', 'Thêm đơn hàng thành công');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
