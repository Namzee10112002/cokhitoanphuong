@extends('admin.layout')
@section('content')
<div class="container">
    <a href="{{ route('admin.users.create') }}" class="btn btn-success mb-3">Tạo Người Dùng</a>
    <h2>Quản lý người dùng</h2>
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Cuối đăng nhập</th>
                <th>Chi tiêu</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr id="user-{{ $user->id }}">
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->address }}</td>
                <td>{{ $user->last_login }}</td>
                <td>{{ number_format($user->total_spent, 0, ',', '.') }} VNĐ</td>
                <td>
                    @if($user->status == 0)
                        <span class="badge bg-success">Hoạt động</span>
                    @else
                        <span class="badge bg-danger">Đã khóa</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-{{ $user->status == 0 ? 'danger' : 'success' }} toggle-status-btn" 
                        data-id="{{ $user->id }}">
                        {{ $user->status == 0 ? 'Khóa' : 'Mở khóa' }}
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.toggle-status-btn').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.id;
            fetch(`/admin/users/${userId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.getElementById('user-' + userId);
                    const badge = row.querySelector('span.badge');
                    const btn = row.querySelector('.toggle-status-btn');

                    if (data.new_status == 0) {
                        badge.className = 'badge bg-success';
                        badge.textContent = 'Hoạt động';
                        btn.className = 'btn btn-sm btn-danger toggle-status-btn';
                        btn.textContent = 'Khóa';
                    } else {
                        badge.className = 'badge bg-danger';
                        badge.textContent = 'Đã khóa';
                        btn.className = 'btn btn-sm btn-success toggle-status-btn';
                        btn.textContent = 'Mở khóa';
                    }
                }
            });
        });
    });
</script>
@endpush
