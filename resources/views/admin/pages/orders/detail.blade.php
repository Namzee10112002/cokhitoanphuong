@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>
    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá mua</th>
                <th>Số lượng</th>
                <th>Tổng tiền mặt hàng</th>
                <th>Trạng thái</th>
                <th>Cập nhật</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderDetails as $detail)
            <tr id="detail-{{ $detail->id }}">
                <td><img src="{{ $detail->product->image_product }}" width="60"></td>
                <td>{{ $detail->product->name_product }}</td>
                <td>{{ number_format($detail->total_detail/$detail->quantity) }} VNĐ</td>
                <td>{{ $detail->quantity }}</td>
                <td>{{ number_format($detail->total_detail) }} VNĐ</td>
                <td>
                    <select class="form-select status-detail-select" data-id="{{ $detail->id }}">
                        <option value="0" {{ $detail->status_detail == 0 ? 'selected' : '' }}>Sản phẩm bình thường</option>
                        <option value="1" {{ $detail->status_detail == 1 ? 'selected' : '' }}>Sản phẩm lỗi chờ thu hồi</option>
                        <option value="2" {{ $detail->status_detail == 2 ? 'selected' : '' }}>Đã thu hồi sản phẩm</option>
                        <option value="3" {{ $detail->status_detail == 3 ? 'selected' : '' }}>Đã xử lý xong</option>
                    </select>
                </td>
                <td>
                    <button class="btn btn-success btn-sm update-detail-btn" data-id="{{ $detail->id }}">Cập nhật</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.orders.exportInvoice', $order->id) }}" class="btn btn-danger" target="_blank">
    Xuất hóa đơn PDF
</a>
<div class="mt-4">
    <h4>Hóa đơn</h4>
    {{-- Danh sách hóa đơn --}}
    @if($order->invoices->count())
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Mã hóa đơn</th>
                    <th>Người xuất</th>
                    <th>Ngày xuất</th>
                    <th>Tải về</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->invoices as $invoice)
                    <tr>
                        <td>HD{{ $invoice->id }}</td>
                        <td>{{ $invoice->user->name ?? 'N/A' }}</td>
                        <td>{{ $invoice->date_export }}</td>
                        <td>
                            <a href="{{ route('admin.orders.downloadInvoice', [$order->id, $invoice->id]) }}" 
                               class="btn btn-primary btn-sm">
                               Xem/Tải PDF
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Chưa có hóa đơn nào cho đơn hàng này.</p>
    @endif
</div>

</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.update-detail-btn').forEach(button => {
        button.addEventListener('click', function() {
            const detailId = this.dataset.id;
            const statusDetail = document.querySelector(`.status-detail-select[data-id='${detailId}']`).value;

            fetch(`/admin/orders/${detailId}/update-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status_detail: statusDetail })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    alert('Cập nhật trạng thái chi tiết thành công');
                }
            });
        });
    });
</script>
@endpush
