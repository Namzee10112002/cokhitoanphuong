@extends('admin.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">Báo cáo tổng hợp</h2>

    <form method="GET" action="{{ route('admin.dashboard.reports') }}" class="mb-3">
        <div class="row">
            <div class="col-md-2">
                <input type="number" name="year" class="form-control" placeholder="Năm" value="{{ $year }}">
            </div>
            <div class="col-md-2">
                <input type="number" name="month" class="form-control" placeholder="Tháng (tùy chọn)" value="{{ $month }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Lọc</button>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.dashboard.reports.export', ['year' => $year, 'month' => $month]) }}" class="btn btn-success">
                    Xuất Excel
                </a>
            </div>
        </div>
    </form>

    <hr>

    {{-- 1. Báo cáo đổi trả / bảo hành --}}
    <h4>1. Báo cáo đổi trả / bảo hành</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Sản phẩm</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orderIssues as $od)
                <tr>
                    <td>#{{ $od->order_id }}</td>
                    <td>{{ $od->product->name_product ?? '' }}</td>
                    <td>{{ $od->status_text }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">Không có dữ liệu</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- 2. Báo cáo khuyến mãi --}}
    <h4>2. Chương trình khuyến mãi</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Tên khuyến mãi</th>
                <th>Giá trị</th>
                <th>Số sản phẩm áp dụng</th>
            </tr>
        </thead>
        <tbody>
            @forelse($promotions as $promo)
                <tr>
                    <td>{{ $promo->name_promotion }}</td>
                    <td>{{ $promo->value }}%</td>
                    <td>{{ $promo->products_count }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">Không có chương trình khuyến mãi</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- 3. Báo cáo phản hồi --}}
    <h4>3. Đơn hàng có phản hồi</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Số phản hồi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($feedbackOrders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->feedbacks->count() }}</td>
                </tr>
            @empty
                <tr><td colspan="2" class="text-center">Không có phản hồi</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- 4. Top 5 sản phẩm tồn kho --}}
    <h4>4. Top 5 sản phẩm tồn kho</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng tồn</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topProductsStock as $p)
                <tr>
                    <td>{{ $p->name_product }}</td>
                    <td>{{ $p->quantity }}</td>
                </tr>
            @empty
                <tr><td colspan="2" class="text-center">Không có dữ liệu</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- 5. Doanh thu & bán hàng --}}
    <h4>5. Doanh thu & bán hàng</h4>
    <p><strong>Tổng doanh thu:</strong> {{ number_format($totalRevenue,0,',','.') }} VND</p>

    <h5>Top 5 sản phẩm bán chạy</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng bán</th>
                <th>Doanh thu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bestSelling as $p)
                <tr>
                    <td>{{ is_object($p['product']) ? $p['product']->name_product : $p['product'] }}</td>
                    <td>{{ $p['quantity'] }}</td>
                    <td>{{ number_format($p['revenue'],0,',','.') }} VND</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">Không có dữ liệu</td></tr>
            @endforelse
        </tbody>
    </table>

    <h5>Top 5 sản phẩm bán chậm nhất</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng bán</th>
                <th>Doanh thu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($worstSelling as $p)
                <tr>
                    <td>{{ is_object($p['product']) ? $p['product']->name_product : $p['product'] }}</td>
                    <td>{{ $p['quantity'] }}</td>
                    <td>{{ number_format($p['revenue'],0,',','.') }} VND</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">Không có dữ liệu</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
