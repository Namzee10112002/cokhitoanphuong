@extends('user.layout')

@section('content')
<div class="container mt-4" style="margin-bottom:300px">
    <h2>Danh sách đơn hàng của bạn</h2>

    @if($orders->isEmpty())
        <p>Chưa có đơn hàng nào.</p>
    @else
        <div class="accordion" id="orderAccordion">
            @foreach($orders as $index => $order)
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="heading{{ $order->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $order->id }}" aria-expanded="false" aria-controls="collapse{{ $order->id }}">
                            Đơn hàng #{{ $order->id }} |
                            Trạng thái: 
                            @switch($order->status_order)
                                @case(0) <span class="badge bg-secondary ms-2">Chờ xử lý</span> @break
                                @case(1) <span class="badge bg-info ms-2">Đang giao</span> @break
                                @case(2) <span class="badge bg-success ms-2">Đã hoàn thành</span> @break
                                @case(3) <span class="badge bg-danger ms-2">Đã hủy</span> @break
                            @endswitch
                        </button>
                    </h2>
                    <div id="collapse{{ $order->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $order->id }}" data-bs-parent="#orderAccordion">
                        <div class="accordion-body">
                            <p><strong>Người nhận:</strong> {{ $order->name_order }}</p>
                            <p><strong>Số điện thoại:</strong> {{ $order->phone_order }}</p>
                            <p><strong>Địa chỉ:</strong> {{ $order->address_order }}</p>
                            <p><strong>Phương thức thanh toán:</strong>
                                @switch($order->method_pay)
                                    @case(0) Thanh toán khi nhận hàng @break
                                    @case(1) Chuyển khoản @break
                                    @case(2) Ví điện tử @break
                                @endswitch
                            </p>
                            <p><strong>Tổng đơn hàng:</strong> {{ number_format($order->total_order, 0, ',', '.') }} đ</p>
                            <p><strong>Ngày đặt:</strong> {{ $order->date_order->format('d/m/Y H:i') }}</p>

                            <h5 class="mt-4">Danh sách sản phẩm</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Đơn vị</th>
                                        <th>Đơn Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->product->name_product }}</td>
                                            <td>{{ $detail->product->unit }}</td>
                                            <td>{{ number_format($detail->total_detail / $detail->quantity, 0, ',', '.') }} đ</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>{{ number_format($detail->total_detail, 0, ',', '.') }} đ</td>
                                            <td>
                                                @switch($detail->status_detail)
                                    @case(0) Không vấn đề @break
                                    @case(1) Chờ thu hồi @break
                                    @case(2) Đã thu hồi chờ xử lý @break
                                    @case(3) Đã xử lý @break
                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button class="btn btn-primary "><a class="text-white" style="text-decoration:none" href="{{ route('chat.index', ['order_id' => $order->id]) }}">Chăm sóc khách hàng</a></button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
