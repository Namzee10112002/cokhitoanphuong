<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route('home')}}">
                <img src="{{ asset('images/logo.png')}}" alt="Logo" width="50" height="auto"
                    class="d-inline-block align-text-center">
                Cơ khí Toàn Phương
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="{{route('home')}}">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{route('about')}}">Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{route('contact')}}">Liên hệ</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link active" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Danh mục sản phẩm
                        </a>
                        <ul class="dropdown-menu" style="width: 200px; overflow-y: scroll; max-height:200px">
                            <div class="container-fluid">
                                <li><a class="dropdown-item" href="{{ route('product')}}">Tất cả sản phẩm</a></li>
                                <hr class="dropdown-divider m-0">
                                <div class="row">
                                    <div class="col-6">
                                        @foreach ($categories as $category)
                                            <li><a class="dropdown-item"
                                                    href="{{ route('product', ['categories' => [$category->id]]) }}">
                                                    <h6>{{ $category->name_category }}</h6>
                                                </a></li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </li>
                    @if (Session::has('user'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown">
                                Xin chào, {{ Session::get('user')->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">Quản lý đơn hàng</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}">Thông tin cá nhân</a></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Đăng xuất</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link active" href="{{route('auth')}}">Đăng nhập</a></li>
                    @endif
                    <li class="nav-item">
                        @if (Session::has('user'))
                        <a href="{{ route(name: 'cart.index') }}" class="btn btn-outline-primary">
                            Giỏ hàng <span class="badge bg-danger"></span>
                        </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>