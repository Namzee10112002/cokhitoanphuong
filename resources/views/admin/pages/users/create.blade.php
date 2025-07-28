<!-- resources/views/admin/users/create.blade.php -->
@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Tạo người dùng</h2>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Họ tên</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" required maxlength="10">
        </div>
        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control" minlength="8" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nhập lại mật khẩu</label>
            <input type="password" name="password_confirmation" class="form-control" minlength="8" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Loại tài khoản</label>
            <select name="role" class="form-select" required>
                <option value="0">Khách hàng</option>
                <option value="1">Nhân viên</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tạo tài khoản</button>
    </form>
</div>
@endsection
