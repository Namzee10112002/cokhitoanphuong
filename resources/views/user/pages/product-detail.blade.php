@extends('user.layout')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <!-- Ảnh sản phẩm -->
            <div class="col-md-6">
                <div id="product-zoom" class="border p-2">
                    <img src="{{ $product->image_product }}" class="img-fluid product-image"
                        alt="{{ $product->name_product }}" width="100%" height="500px">
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-md-6">
                <h2>{{ $product->name_product }}</h2>
                <p><strong>Mã sản phẩm:</strong> {{ $product->code_product }}</p>
                <p><strong>Danh mục:</strong> {{ $product->name_category }}</p>
                <p><strong>Nhà cung cấp:</strong> {{ $product->name_supplier }}</p>
                <p><strong>Mô tả:</strong> {!! nl2br(e($product->description)) !!}</p>
                <p><strong>Kho còn:</strong> <strong class="text-danger">{{ $product->quantity }}
                        {{ $product->unit }}</strong> </p>
                <p>@if ($product->promotion_id != null)
                    <p class="text-danger"><strong class="text-dark">Giá mới:</strong>
                        <del>{{ number_format($product->price, 0, ',', '.') }} </del><span class="text-success">
                            {{ number_format($product->price * ((100 - $product->value) / 100), 0, ',', '.') }} VND</span></p>
                @else
                    <p class="text-danger"><strong class="text-dark">Giá:</strong>
                        {{ number_format($product->price, 0, ',', '.') }} VND</p>
                @endif
                </p>
                <p><strong>Đánh giá:</strong>
                    <span class="star-rating">★★★★☆</span> (120 đánh giá)
                </p>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}"
                        class="form-control mb-2" style="width: 100px;">
                    <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
                </form>
                <a href="{{ route('home') }}" class="btn btn-secondary mt-3">Quay lại</a>
            </div>
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

        <!-- Bình luận -->
        {{-- <h3 class="mt-5">Bình luận của khách hàng</h3>
        <div class="border p-3 rounded bg-light">
            <div class="mb-3">
                <textarea class="form-control" rows="3" placeholder="Viết bình luận của bạn..."></textarea>
                <button class="btn btn-primary mt-2">Gửi bình luận</button>
            </div>

            <!-- Bình luận mẫu -->
            <div class="mt-3">
                <div class="d-flex mb-3">
                    <img src="{{ asset('assets/images/Sam_Altman_TechCrunch_SF.jpg') }}" width="50" height="50"
                        class="rounded-circle me-2" alt="User">
                    <div>
                        <strong>Sam Altman</strong> <span class="text-muted">- 2 ngày trước</span>
                        <p>Mình đã mua sản phẩm này và rất hài lòng. Chất lượng tốt, giao hàng nhanh. Sẽ ủng hộ shop lâu
                            dài!</p>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <img src="{{ asset('assets/images/putin.jpg') }}" width="50" height="50" class="rounded-circle me-2"
                        alt="User">
                    <div>
                        <strong>Vladimir Putin</strong> <span class="text-muted">- 1 tuần trước</span>
                        <p>Giá cả hợp lý, sản phẩm đúng mô tả. Tuy nhiên, mình nghĩ shop có thể cải thiện khâu đóng gói một
                            chút.</p>
                    </div>
                </div>

                <div class="d-flex">
                    <img src="{{ asset('assets/images/elon_musk.jpg') }}" width="50" height="50" class="rounded-circle me-2"
                        alt="User">
                    <div>
                        <strong>Elon Musk</strong> <span class="text-muted">- 5 ngày trước</span>
                        <p>Hàng đẹp, đúng như hình. Nhưng giao hơi chậm, mong shop cải thiện dịch vụ vận chuyển.</p>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Sản phẩm liên quan -->
        <h3 class="mt-5">Sản phẩm liên quan</h3>
        <div class="row">
            @foreach ($related_products as $related)
                <div class="col-md-3 product-item">
                    @if ($related->promotion_id != null)
                        <div class="sale">Sale {{ $product->value }}%</div>
                    @endif
                    <div class="card mb-3">
                        <img src="{{ $related->image_product }}" class="card-img-top" alt="{{ $related->name_product }}"
                            height="200px">
                        <div class="card-body">
                            <h6 class="card-title">{{ $related->name_product }}</h6>
                            @if ($product->promotion_id != null)
                                <p class="text-danger">Giá mới: <del>{{ number_format($product->price, 0, ',', '.') }} đ</del><span
                                        class="text-success">
                                        {{ number_format($product->price * ((100 - $product->value) / 100), 0, ',', '.') }} đ</span></p>
                            @else
                                <p class="text-danger">Giá: {{ number_format($product->price, 0, ',', '.') }} đ</p>
                            @endif
                            <a href="{{ route('product.detail', $related->id) }}" class="btn btn-sm btn-outline-primary">Xem chi
                                tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection