@extends('user.layout')
@section('content')
    <div class="container mt-5">
        <!-- Giới thiệu tổng quan -->
        <div class="text-center mb-4">
            <h1>Về Chúng Tôi</h1>
            <p class="lead">Công ty Cơ Khí Toàn Phượng - Đối tác tin cậy của bạn trong ngành cơ khí.</p>
        </div>

        <!-- Hình ảnh & Mô tả -->
        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <img src="{{ asset('images/banner.jpg')}}" class="img-fluid rounded" alt="Hình ảnh công ty">
            </div>
            <div class="col-md-6">
                <h3>Chúng tôi là ai?</h3>
                <p>Với hơn 10 năm kinh nghiệm, chúng tôi chuyên cung cấp các sản phẩm cơ khí chất lượng cao, từ tôn, sắt,
                    thép đến các sản phẩm gia công theo yêu cầu.</p>
                <p>Chúng tôi cam kết mang đến những giải pháp tối ưu, giúp khách hàng đạt được hiệu quả cao trong sản xuất
                    và xây dựng.</p>
            </div>
        </div>

        <!-- Giá trị cốt lõi -->
        <div class="text-center mb-5">
            <h3>Giá Trị Cốt Lõi</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="card p-3">
                        <h5 class="text-primary">Chất lượng</h5>
                        <p>Sản phẩm đạt tiêu chuẩn cao, đáp ứng mọi nhu cầu của khách hàng.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3">
                        <h5 class="text-primary">Uy tín</h5>
                        <p>Luôn đặt chữ tín lên hàng đầu, đảm bảo đúng tiến độ và cam kết.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3">
                        <h5 class="text-primary">Đổi mới</h5>
                        <p>Không ngừng cải tiến công nghệ để mang lại sản phẩm tốt nhất.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sản phẩm bán chạy -->
        <h2 class="text-center">Sản phẩm bán chạy</h2>
        <div class="row mb-4">
            @foreach ($products as $product)
                <div class="col-md-3 text-center product-item">
                    @if ($product->promotion_id != null)
                        <div class="sale">Sale {{ $product->value }}%</div>
                    @endif
                    <img src="{{ $product->image_product }}" class="img-fluid" alt="" width="100%">
                    <h5>{{ $product->name_product }}</h5>
                    @if ($product->promotion_id != null)
                        <p class="text-danger">Giá mới: <del>{{ number_format($product->price, 0, ',', '.') }} đ</del><span
                                class="text-success"> {{ number_format($product->price * ((100 - $product->value) / 100), 0, ',', '.') }}
                                đ</span></p>
                    @else
                        <p class="text-danger">Giá: {{ number_format($product->price, 0, ',', '.') }} đ</p>
                    @endif
                    <a href="{{ route('product.detail', ['id' => $product->id]) }}" class="btn btn-primary">Xem chi tiết</a>
                </div>
            @endforeach

        </div>
        <!-- Đội ngũ nhân sự -->
        <div class="text-center mb-5">
            <h3>Đội Ngũ Của Chúng Tôi</h3>
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('images/Sam_Altman_TechCrunch_SF_2019_Day_2_Oct_3_(cropped)_(cropped).jpg') }}"
                        class="rounded-circle" height="150" alt="CEO">
                    <h5>Sam Altman</h5>
                    <p>Giám đốc điều hành</p>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('images/Владимир_Путин_(08-03-2024)_(cropped).jpg') }}" class="rounded-circle"
                        height="150" alt="Manager">
                    <h5>Vladimir Putin</h5>
                    <p>Trưởng phòng Kinh doanh</p>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('images/anh-man-hinh-2025-03-11-luc-09-05-04.png') }}" class="rounded-circle"
                        height="150" alt="Engineer">
                    <h5>Elon Musk</h5>
                    <p>Kỹ sư trưởng</p>
                </div>
            </div>
        </div>

        <!-- Lời cam kết -->
        <div class="text-center mb-5">
            <h3>Lời Cam Kết</h3>
            <p>Chúng tôi cam kết mang đến những sản phẩm chất lượng, dịch vụ tận tâm và luôn đồng hành cùng sự phát triển
                của khách hàng.</p>
        </div>
    </div>
@endsection