<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'product'])->latest('id')->paginate(10);
        return view('index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add');
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
            $totalPrice = 0;
            $customer = Customer::create($request->customer);
            $supplier = Supplier::create($request->validated()['supplier']);

            foreach ($request->products as $key => $productData) {
                // dd($request->file("products.$key.image"));
                $imagePath = $request->file("products.$key.image")->store('images', 'public');
                if (!Storage::exists('images')) {
                    Storage::makeDirectory('images');
                }
                $product = Product::create([
                    'product_name' => $productData['product_name'],
                    'description' => $productData['description'],
                    'image' => $imagePath,
                    'price' => $productData['price'],
                    'quantity' => $productData['quantity'],
                    'supplier_id' => $supplier->id,
                ]);
                $price[] = $productData['price'];
                $productIds[] = $product->id;
            }
            foreach ($request->order_details as $key => $data) {
                // dd($key);
                $quantity[] = $data['quantity'];
                $totalPrice += $price[$key] * $quantity[$key];
            }

            $order = Order::create([
                'customer_id' => $customer->id,
                'total_price' => $totalPrice,
            ]);

            foreach ($request->order_details as $key => $data) {
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
        $order->load(['customer', 'product']);
        $spl = 0;
        $detail = [];
        foreach ($order->product as $pr) {
            $spl = $pr->supplier_id;
            $detail[] = $pr->id;
        }
        $supplier = Supplier::find($spl);
        $orderDetail = DB::table('order_details')
            ->whereIn('product_id', $detail)
            ->get();
        return view('edit', compact('order', 'supplier', 'orderDetail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        DB::transaction(function () use ($request, $order) {
            $price = [];
            $quantity = [];
            $productIds = [];
            $totalPrice = 0;
            $imagePath = null;
            // dd($order->id);
            Customer::where('id', $order->customer_id)
                ->update($request->customer);

            Supplier::where('id', $request->supplier['id'])
                ->update($request->supplier);

            foreach ($request->products as $key => $pro) {
                // dd($request->hasFile("products.$key.id.image"));
                if(!$request->hasFile("products.$key.image")) {
                    $imagePath = $pro['image_old'];
                }
                else{
                    $imagePath = $request->file("products.$key.image")->store('images', 'public');
                }

                Product::where('id', $pro['id'])
                    ->update([
                        'product_name' => $pro['product_name'],
                        'description' => $pro['description'],
                        'image' => $imagePath,
                        'price' => $pro['price'],
                        'quantity' => $pro['quantity'],
                        'supplier_id' => $request->supplier['id'],
                    ]);
                    $price[] = $pro['price'];
                    $productIds[] = $pro['id'];
            }

            foreach ($request->order_details as $key => $data) {
                $quantity[] = $data['quantity'];
                $totalPrice += $price[$key] * $quantity[$key];
            }
            Order::where('id', $order->id)
                ->update([
                    'customer_id' => $order->customer_id,
                    'total_price' => $totalPrice,
                ]);

            foreach ($request->order_details as $key => $data) {
                // dd($key);
                $quantity[] = $data['quantity'];
                DB::table('order_details')->where('product_id', $productIds[$key])->update([
                    'order_id' => $order->id,
                    'product_id' => $productIds[$key],
                    'quantity' => $data['quantity'],
                    'price' => $price[$key],
                ]);
            }
        });

        session()->flash('success', 'Cập nhật đơn hàng thành công');
        return redirect()->route('edit', ['order' => $order->id]); // Chuyển hướng về trang edit của order
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        DB::transaction(function () use ($order) {
            $order->product()->sync([]);

            $order->delete();
        });
        return back();
    }
}
