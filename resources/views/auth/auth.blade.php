@extends('user.layout')

@section('content')
<div class="container mt-5" style="max-width: 400px;">
    {{-- Form Đăng Nhập --}}
    <div class="form-box active" id="login-form">
        <h2 class="mb-3">Đăng nhập</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
            <a class="switch-link mt-2 d-block text-center" id="to-register">Bạn chưa có tài khoản?</a>
        </form>
    </div>

    {{-- Form Đăng Ký --}}
    <div class="form-box" id="register-form">
        <h2 class="mb-3">Đăng ký</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Họ và tên" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" maxlength="10" required>
            </div>
            <div class="mb-3">
                <input type="text" name="address" class="form-control" placeholder="Địa chỉ" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" minlength="8" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Đăng ký</button>
            <a class="switch-link mt-2 d-block text-center" id="to-login">Bạn đã có tài khoản?</a>
        </form>
    </div>

    {{-- Hiển thị lỗi --}}
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
</div>
@endsection

@push('styles')
    <style>
        .form-box { display: none; }
        .form-box.active { display: block; }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById('to-register').addEventListener('click', function () {
            document.getElementById('login-form').classList.remove('active');
            document.getElementById('register-form').classList.add('active');
        });

        document.getElementById('to-login').addEventListener('click', function () {
            document.getElementById('register-form').classList.remove('active');
            document.getElementById('login-form').classList.add('active');
        });
    </script>
@endpush
