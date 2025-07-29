<nav class="col-2 sidebar d-flex flex-column p-0">
                <div class="p-3 text-center border-bottom">
                    <h5>Trang quản trị</h5>
                </div>
                <ul class="nav flex-column p-2">
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{route('admin.users.index')}}">Quản lý người dùng</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{route('admin.categories.index')}}">Quản lý danh mục sản phẩm</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{route('admin.suppliers.index')}}">Quản lý nhà cung cấp</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{route('admin.products.index')}}">Quản lý sản phẩm</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{route('admin.orders.index')}}">Quản lý đơn hàng</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{route('admin.promotions.index')}}">Quản lý khuyến mãi</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{route('admin.warranty')}}">Quản lý đổi trả bảo hành</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{route('admin.dashboard')}}">Báo cáo - thống kê</a>
                    </li>
                    <li class="nav-item mt-auto border-top">
                        <a class="nav-link text-danger" href="{{route('logout')}}">Đăng xuất</a>
                    </li>
                </ul>
            </nav>