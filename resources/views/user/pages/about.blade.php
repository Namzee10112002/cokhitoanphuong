@extends('user.layout')
@section('content')
    <section class="hero-section">
        <div class="container">
            <h1>Chào Mừng Đến Với Toàn Phương JSC</h1>
            <p>"AN TOÀN - CHẤT LƯỢNG - TIẾN ĐỘ - HIỆU QUẢ"</p>
        </div>
    </section>

    <!-- GIỚI THIỆU -->
    <div class="container my-5">
        <h2 class="section-title">Về Chúng Tôi</h2>
        <p class="text-center">
            Công ty TNHH TM Dịch vụ Kỹ thuật Toàn Phương là một doanh nghiệp có lịch sử phát triển từ Công ty cổ phần
            LISEMCO 2,
            thành lập vào năm 2008. Với đội ngũ quản lý giàu kinh nghiệm, công nhân lành nghề và thợ hàn đạt chứng chỉ quốc
            tế,
            Toàn Phương JSC tự hào là đơn vị hàng đầu trong lĩnh vực cơ khí chế tạo, xây dựng và cung cấp vật tư công
            nghiệp.
        </p>
    </div>

    <!-- DỊCH VỤ -->
    <div class="container my-5">
        <h2 class="section-title">Sản Phẩm & Dịch Vụ</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card service-card">
                    <img src="{{ asset('images/Xe-nâng.jpg') }}" class="card-img-top" alt="Vật tư xe nâng">
                    <div class="card-body">
                        <h5 class="card-title">Cung Cấp Vật Tư Xe Nâng</h5>
                        <p class="card-text">Cung cấp linh kiện chất lượng cao cho xe nâng, đảm bảo hoạt động bền bỉ.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card">
                    <img src="{{ asset('images/ac-quy-xe-nang-rocket.jpg') }}" class="card-img-top" alt="Ắc quy xe nâng">
                    <div class="card-body">
                        <h5 class="card-title">Cung Cấp Ắc Quy Xe Nâng Điện</h5>
                        <p class="card-text">Ắc quy hiệu suất cao giúp tối ưu hóa hoạt động xe nâng điện.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card">
                    <img src="{{ asset('images/huong-dan-sua-chua-va-thay-the-phu-tung-xe-nang-1.jpg') }}" class="card-img-top"
                        alt="Sửa chữa xe nâng">
                    <div class="card-body">
                        <h5 class="card-title">Sửa Chữa Xe Nâng</h5>
                        <p class="card-text">Dịch vụ sửa chữa chuyên nghiệp, giúp xe nâng vận hành trơn tru.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection