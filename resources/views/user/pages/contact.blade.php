@extends('user.layout')
@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- THÔNG TIN LIÊN HỆ -->
            <div class="col-lg-5 mb-4">
                <h2 class="mb-4 fw-bold text-primary">Thông Tin Liên Hệ</h2>

                <div class="d-flex align-items-center mb-3">
                    <img src="https://cdn-icons-png.flaticon.com/128/535/535239.png" alt="" height="30px">
                    <h5 class="ms-2 mb-0">Địa chỉ:</h5>
                </div>
                <p class="fs-5 text-muted">1/115 Đường Máng Nước – xã An Đồng – huyện An Dương - Hải Phòng.</p>

                <div class="d-flex align-items-center mb-3">
                    <img src="https://cdn-icons-png.flaticon.com/128/126/126509.png" alt="" height="30px">
                    <h5 class="ms-2 mb-0">Điện thoại:</h5>
                </div>
                <p class="fs-5 text-muted">0989 567 499 / 0225 359 3816 / 0855 766 388</p>

                <div class="d-flex align-items-center mb-3">
                    <img src="https://cdn-icons-png.flaticon.com/128/3178/3178165.png" alt="" height="30px">
                    <h5 class="ms-2 mb-0">Email:</h5>
                </div>
                <p class="fs-5 text-muted">tptecserco.ltd@gmail.com</p>
            </div>

            <!-- FORM LIÊN HỆ -->
            <div class="col-lg-7">
                <div class="p-4 shadow rounded bg-light">
                    <h3 class="text-center text-primary fw-bold mb-4">Liên hệ ngay với chúng tôi</h3>
                    <p class="text-center text-muted">Hãy để lại thông tin, chúng tôi sẽ phản hồi trong thời gian sớm nhất.
                    </p>

                    <form>
                        <div class="mb-3">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" placeholder="Nhập họ và tên của bạn">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="example@gmail.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" placeholder="Nhập số điện thoại của bạn">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nội dung</label>
                            <textarea class="form-control" rows="4" placeholder="Nhập nội dung cần liên hệ"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Gửi yêu cầu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection