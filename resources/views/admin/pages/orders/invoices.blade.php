<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hóa đơn</title>
    <style>
        @font-face {
            font-family: 'DejaVuSans';
            src: url("{{ public_path('fonts/DejaVuSans.ttf') }}") format('truetype');
        }

        body {
            font-family: DejaVu Sans, sans-serif;
        }


        .header {
            text-align: center;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        .total {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="" style="display:flex; justify-content: left; width: 100%;">
            @php
                $logo = base64_encode(file_get_contents(public_path('images/logo.png')));
            @endphp

            <img src="data:image/png;base64,{{ $logo }}" width="120" alt="Logo công ty">
        </div>
        <h3>CÔNG TY TNHH TM DV KỸ THUẬT TOÀN PHƯƠNG</h3>
        <h4>HÓA ĐƠN</h4>
    </div>

    <p>Mã hóa đơn: {{ $order->id }}</p>
    <p>Ngày xuất hóa đơn: {{ now()->format('d/m/Y') }}</p>
    <hr>
    <h3>Thông tin thanh toán</h3>
    <p>Ngân hàng: MB BANK</p>
    <p>Số tài khoản: 3000110112002</p>
    <p>Tên tài khoản: NGUYỄN VŨ ĐẠI NAM</p>
    <hr>
    <div class="" style="display:flex; justify-content: center; width: 100%;">
        <h3>Thông tin khách hàng</h3>
    </div>
    <table>
        <tr>
            <td><strong>Khách hàng:</strong> {{ $order->user->name }}</td>
            <td><strong>SĐT:</strong> {{ $order->user->phone ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Địa chỉ:</strong> {{ $order->user->address ?? '' }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderDetails as $detail)
                <tr>
                    <td>{{ $detail->product->name_product ?? '' }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->total_detail, 0, ',', '.') }} VND</td>
                    <td>{{ number_format($detail->quantity * $detail->total_detail, 0, ',', '.') }} VND</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="3">TỔNG CỘNG</td>
                <td>{{ number_format($order->total_order, 0, ',', '.') }} VND</td>
            </tr>
        </tbody>
    </table>
</body>

</html>