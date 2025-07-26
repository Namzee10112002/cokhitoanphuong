<?php

namespace App\Http\Controllers\User;

use App\Models\CategoryProduct;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class HomeUserController
{
    public function index()
    {
        $products = Product::getActiveProducts();
        return view('user.pages.home', compact('products'));
    }
    public function about()
    {
        return view('user.pages.about');
    }
    public function contact()
    {
        return view('user.pages.contact');
    }
    public function productDetail($id)
    {
        $product = Product::getProductWithRelationsById($id);

        if (!$product) {
            abort(404, 'Sản phẩm không tồn tại hoặc đã bị khóa.');
        }

        $related_products = Product::getRelatedProducts($product->category_id, $product->id);

        return view('user.pages.product-detail', compact('product','related_products'));
    }
    public function product(Request $request)
{
   $suppliers = Supplier::where('status_supplier', 0)->get();
    $categories = CategoryProduct::getActiveCategories();

    $selectedCategories = $request->input('categories', []);
    $selectedSuppliers = $request->input('suppliers', []);

    $productsQuery = Product::select('products.*','promotion.name_promotion',
            'promotion.value')
    ->leftJoin('promotion', function($join) {
        $join->on('products.promotion_id', '=', 'promotion.id')
             ->whereNotNull('products.promotion_id');
    })
    ->where('products.status_product', '!=', 1);


    // Lọc theo danh mục
    if (!empty($selectedCategories)) {
        $productsQuery->whereIn('category_id', $selectedCategories);
    }

    // Lọc theo khoảng giá
    if ($request->filled('price_min')) {
        $productsQuery->where('price', '>=', $request->price_min);
    }
    if ($request->filled('price_max')) {
        $productsQuery->where('price', '<=', $request->price_max);
    }

    // Lọc theo nhà cung cấp
    if (!empty($selectedSuppliers)) {
        $productsQuery->whereIn('supplier_id', $selectedSuppliers);
    }
    if (!empty($request->input('name_product'))) {
        $productsQuery->where('name_product', 'like', '%' . $request->input('name_product') . '%');
    }

    // Lọc sản phẩm có giảm giá
    if ($request->filled('promotion_only')) {
        $productsQuery->whereNotNull('promotion_id');
    }

    $products = $productsQuery->orderBy('id', 'desc')->get();

    return view('user.pages.product-category', compact('products', 'suppliers', 'categories', 'selectedCategories', 'selectedSuppliers'));
}
public function ordered()
{
    $userId = session('user')->id;

    $orders = Order::with(['orderDetails.product'])
                   ->where('user_id', $userId)
                   ->orderBy('id', 'desc')
                   ->get();

    return view('user.pages.ordered', compact('orders'));
}
}
