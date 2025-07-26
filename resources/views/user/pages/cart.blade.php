@extends('user.layout')

@section('content')
    <div class="container mt-4">
        <h2>Giỏ hàng của bạn</h2>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn vị</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Tổng tiền</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @if($cartItems->isEmpty())
                    <tr>
                        <p>Giỏ hàng của bạn đang trống.</p>
                    </tr>
                @else
                    @foreach ($cartItems as $item)
                        @php
                            if ($item->product->promotion_id != null) {
                                $subtotal = $item->product->price * ((100 - $item->product->promotion->value) / 100) * $item->quantity;

                            } else {
                                $subtotal = $item->product->price * $item->quantity;

                            }
                            echo $item->product->value;
                            $grandTotal += $subtotal;
                        @endphp
                        <tr>
                            <td>
                                <img src="{{  $item->product->image_product }}" width="80" height="80"
                                    alt="{{ $item->product->name_product }}">
                            </td>
                            <td>{{ $item->product->name_product }}</td>
                            <td>{{ $item->product->unit }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" step="1"
                                        max="{{$item->product->quantity}}" class="form-control form-control-sm me-2"
                                        style="width: 80px;">
                                    <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                                </form>
                            </td>
                            @if ($item->product->promotion_id != null)
                                <td>
                                    <p class="text-danger">
                                        <del>{{ number_format($item->product->price, 0, ',', '.') }} đ</del>
                                        <span class="text-success">
                                            {{ number_format($item->product->price * ((100 - $item->product->promotion->value) / 100), 0, ',', '.') }}
                                            đ</span>
                                    </p>
                                </td>
                            @else
                                <td>{{ number_format($item->product->price, 0, ',', '.') }} đ</td>
                            @endif

                            <td>{{ number_format($subtotal, 0, ',', '.') }} đ</td>

                            <td>
                                <form action="{{ route('cart.delete', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td colspan="5" class="text-end"><strong>Tổng cộng:</strong></td>
                    <td><strong>{{ number_format($grandTotal, 0, ',', '.') }} đ</strong></td>
                </tr>
            </tbody>
        </table>
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Hiển thị success --}}
        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif
        <div class="border p-3 mt-4">
            <h4>Thông tin thanh toán</h4>
            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                <input type="number" name="total_order" required hidden value="{{$grandTotal}}">
                <div class="mb-3">
                    <label class="form-label">Tên người nhận</label>
                    <input type="text" name="name_order" class="form-control" value="{{ session('user')->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone_order" class="form-control" value="{{ session('user')->phone }}"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Địa chỉ nhận hàng</label>
                    <input type="text" name="address_order" class="form-control" value="{{ session('user')->address }}"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phương thức thanh toán</label>
                    <select name="method_pay" class="form-select" required>
                        <option value="0">Thanh toán khi nhận hàng</option>
                        <option value="1">Chuyển khoản</option>
                        <option value="2">Ví điện tử</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="note_order" class="form-select" id="" cols="30" rows="10"></textarea>
                </div>
                @if($cartItems->isEmpty())
                    <button type="submit" class="btn btn-secondary" disabled>Giỏ hàng đang trống</button>
                @else
                    <button type="submit" class="btn btn-success">Thanh toán</button>
                @endif
            </form>
        </div>
    </div>
@endsection