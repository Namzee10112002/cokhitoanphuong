@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Tạo danh mục sản phẩm</h2>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tên danh mục</label>
            <input type="text" name="name_category" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Tạo</button>
    </form>
</div>
@endsection
