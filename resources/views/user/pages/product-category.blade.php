@extends('user.layout')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <!-- Filter Sidebar (20%) -->
            <aside class="col-md-3">
                <form method="GET" action="{{ route('product') }}">
                    <!-- Danh mục sản phẩm -->
                    <div class="mb-3 ">
                        <strong>Tìm kiếm theo tên</strong>
                        <input type="text" class="form-control" name="name_product"
                            value="{{ request('name_product') ? request('name_product') : '' }}">
                    </div>
                    <div class="mb-3">
                        <strong>Danh mục sản phẩm</strong>
                        @foreach($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}"
                                    id="category{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}>
                                <label class="form-check-label" for="category{{ $category->id }}">
                                    {{ $category->name_category }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Nhà cung cấp -->
                    <div class="mb-3">
                        <strong>Nhà cung cấp</strong>
                        @foreach($suppliers as $supplier)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="suppliers[]" value="{{ $supplier->id }}"
                                    id="supplier{{ $supplier->id }}" {{ in_array($supplier->id, $selectedSuppliers) ? 'checked' : '' }}>
                                <label class="form-check-label" for="supplier{{ $supplier->id }}">
                                    {{ $supplier->name_supplier }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Khoảng giá -->
                    <div class="mb-3">
                        <label class="form-label">Giá từ:</label>
                        <input type="number" name="price_min" class="form-control" value="{{ request('price_min') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá đến:</label>
                        <input type="number" name="price_max" class="form-control" value="{{ request('price_max') }}">
                    </div>

                    <!-- Sản phẩm giảm giá -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="promotion_only" name="promotion_only" {{ request('promotion_only') ? 'checked' : '' }}>
                        <label class="form-check-label" for="promotion_only">Chỉ hiển thị sản phẩm giảm giá</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Áp dụng lọc</button>
                </form>

            </aside>

            <!-- Danh sách sản phẩm (80%) -->
            <section class="col-md-9">
                <div class="row">
                    @forelse ($products as $product)
                        <div class="col-md-4 mb-4 product-item">
                            @if ($product->promotion_id != null)
                                <div class="sale">Sale {{ $product->value }}%</div>
                            @endif
                            <div class="card h-100">
                                <img src="{{ $product->image_product }}" class="card-img-top" alt="{{ $product->name_product }}"
                                    style="height: 200px;  width: 100%;">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title">{{ $product->name_product }}</h6>
                                    @if ($product->promotion_id != null)
                                        <p class="text-danger">Giá mới: <del>{{ number_format($product->price, 0, ',', '.') }}
                                                đ</del><span class="text-success">
                                                {{ number_format($product->price * ((100 - $product->value) / 100), 0, ',', '.') }}
                                                đ</span></p>
                                    @else
                                        <p class="text-danger">Giá: {{ number_format($product->price, 0, ',', '.') }} đ</p>
                                    @endif
                                    <a href="{{ route('product.detail', ['id' => $product->id]) }}"
                                        class="btn btn-sm btn-outline-primary mt-auto">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Không có sản phẩm nào phù hợp.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection