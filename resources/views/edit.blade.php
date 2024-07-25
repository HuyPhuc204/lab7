@extends('layouts.master')

@section('title')
    Cập nhật đơn hàng
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <a href="{{ route('list')}}" class="btn btn-info mt-4">Quay lại</a>
    <form action="{{ route('update', $order) }}" method="post">
        @csrf
        @method('PUT')
        <div class="row mt-5">
            <div class="col-md-6">
                <h4>Thông tin khách hàng:</h4>
                <div class="mb-3">
                    <label for="customer_name" class="form-label">Tên khách hàng</label>
                    <input type="text" class="form-control" id="customer_name" name="customer[customer_name]"
                        value="{{ $order->customer->customer_name }}">
                    @error('customer.customer_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="customer_address" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" id="customer_address" name="customer[address]"
                        value="{{ $order->customer->address }}">
                    @error('customer.address')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="customer_phone" class="form-label">Số điện thoại</label>
                    <input type="tel" class="form-control" id="customer_phone" name="customer[phone]"
                        value="{{ $order->customer->phone }}">
                    @error('customer.phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="customer_email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="customer_email" name="customer[email]"
                        value="{{ $order->customer->email }}">
                    @error('customer.email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <h4>Thông tin nhà cung cấp:</h4>
                <div class="mb-3">
                    <input type="hidden" class="form-control" id="supplier_id" name="supplier[id]"
                        value="{{ $supplier->id }}">
                    <label for="supplier_name" class="form-label">Tên nhà cung cấp</label>
                    <input type="text" class="form-control" id="supplier_name" name="supplier[supplier_name]"
                        value="{{ $supplier->supplier_name }}">
                    @error('supplier.supplier_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="supplier_address" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" id="supplier_address" name="supplier[address]"
                        value="{{ $supplier->address }}">
                    @error('supplier.address')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="supplier_phone" class="form-label">Số điện thoại</label>
                    <input type="tel" class="form-control" id="supplier_phone" name="supplier[phone]"
                        value="{{ $supplier->phone }}">
                    @error('supplier.phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="supplier_email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="supplier_email" name="supplier[email]"
                        value="{{ $supplier->email }}">
                    @error('supplier.email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h4>Sản phẩm:</h4>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Mô tả</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Số lượng bán</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 2; $i++)
                        <tr>
                            <input type="hidden" class="form-control" name="products[{{ $i }}][id]"
                                value="{{ $order->product[$i]->id }}">
                            <td>
                                <input type="text" class="form-control"
                                    name="products[{{ $i }}][product_name]"
                                    value="{{ $order->product[$i]->product_name }}">
                                @error("products.$i.product_name")
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="text" class="form-control"
                                    name="products[{{ $i }}][description]"
                                    value="{{ $order->product[$i]->description }}">
                                @error("products.$i.description")
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="text" class="form-control" name="products[{{ $i }}][price]"
                                    value="{{ $order->product[$i]->price }}">
                                @error("products.$i.price")
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="number" class="form-control"
                                    name="products[{{ $i }}][quantity]"
                                    value="{{ $order->product[$i]->quantity }}">
                                @error("products.$i.quantity")
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="number" class="form-control"
                                    name="order_details[{{ $i }}][quantity]"
                                    value="{{ $orderDetail[$i]->quantity }}">
                                @error("order_details.$i.quantity")
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-outline-success col-md-12">Cập nhật đơn hàng</button>
    </form>
@endsection
