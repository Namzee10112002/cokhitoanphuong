@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Quản lý danh mục sản phẩm</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-success mb-3">Tạo danh mục</a>
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Tên danh mục</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr id="category-{{ $category->id }}">
                <td>{{ $category->name_category }}</td>
                <td>
                    @if($category->status_category == 0)
                        <span class="badge bg-success">Hiển thị</span>
                    @else
                        <span class="badge bg-danger">Đã ẩn</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                    <button class="btn btn-sm btn-{{ $category->status_category == 0 ? 'danger' : 'success' }} toggle-status-btn"
                        data-id="{{ $category->id }}">
                        {{ $category->status_category == 0 ? 'Ẩn' : 'Hiện' }}
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
            const categoryId = this.dataset.id;
            fetch(`/admin/categories/toggle-status/${categoryId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.getElementById('category-' + categoryId);
                    const badge = row.querySelector('span.badge');
                    const btn = row.querySelector('.toggle-status-btn');

                    if (data.new_status == 0) {
                        badge.className = 'badge bg-success';
                        badge.textContent = 'Hiển thị';
                        btn.className = 'btn btn-sm btn-danger toggle-status-btn';
                        btn.textContent = 'Ẩn';
                    } else {
                        badge.className = 'badge bg-danger';
                        badge.textContent = 'Đã ẩn';
                        btn.className = 'btn btn-sm btn-success toggle-status-btn';
                        btn.textContent = 'Hiện';
                    }
                }
            });
        });
    });
</script>
@endpush
