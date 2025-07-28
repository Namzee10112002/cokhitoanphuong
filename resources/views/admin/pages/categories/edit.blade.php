@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Sửa danh mục sản phẩm</h2>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tên danh mục</label>
            <input type="text" name="name_category" class="form-control" value="{{ $category->name_category }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection
