@extends('layouts.master')

@section('title')
    Danh sách đơn hàng
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mt-5">

            <a href="{{ route('add') }}" class="btn btn-success mb-3">Thêm mới</a>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Thông tin khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Chi tiết đặt hàng</th>
                            <th>Ngày tạo</th>
                            <th>Ngày sửa</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>
                                <ul>
                                    <li>Tên: {{ $order->customer->customer_name }}</li>
                                    <li>Email: {{ $order->customer->email }}</li>
                                    <li>Địa chỉ: {{ $order->customer->address }}</li>
                                    <li>SĐT: {{ $order->customer->phone }}</li>
                                </ul>
                            </td>
                            <td>{{ number_format($order->total_price) }}</td>
                            <td>
                                @foreach ($order->product as $product)
                                    <h6>Sản phẩm: {{ $product->product_name }}</h6>
                                    <ul>
                                        <li>Giá: {{ number_format($product->pivot->price) }}</li>
                                        <li>Số lượng: {{ $product->pivot->quantity }}</li>
                                    </ul>
                                @endforeach
                            </td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->updated_at }}</td>
                            <td>
                                <a href="{{ route('edit', $order) }}" class="btn btn-warning mt-3">Sửa</a>

                                <form action="{{ route('destroy', $order) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" onclick="return confirm('Bạn có muốn xóa!')"
                                        class="btn btn-danger mt-3">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
