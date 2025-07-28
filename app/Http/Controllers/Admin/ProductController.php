<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\ImportProduct;
use App\Models\Supplier;
use App\Models\Promotion;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'supplier', 'promotion'])
            ->withSum('orderDetails', 'total_detail') // Sử dụng field total_detail đã có sẵn
            ->get();


        return view('admin.pages.products.index', compact('products'));
    }

    public function create()
    {
        $categories = CategoryProduct::all();
        $suppliers = Supplier::all();

        return view('admin.pages.products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code_product'   => 'required|string|max:100|unique:products,code_product',
            'name_product'   => 'required|string|max:255',
            'price_product'  => 'required|integer|min:0',
            'description'    => 'nullable|string',
            'unit'           => 'required|string|max:50',
            'image_product'  => 'required|url',
            'category_id'    => 'required|exists:category_product,id',
            'supplier_id'    => 'required|exists:suppliers,id'
        ]);

        Product::create([
            'code_product' => $request->code_product,
            'name_product' => $request->name_product,
            'price' => $request->price_product,
            'description' => $request->description,
            'unit' => $request->unit,
            'image_product' => $request->image_product,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'status_product' => 1,
            'sold' => 0
        ]);


        return redirect()->route('admin.products.index')->with('success', 'Tạo sản phẩm thành công');
    }

    public function edit(Product $product)
    {
        $categories = CategoryProduct::all();
        $suppliers = Supplier::all();

        return view('admin.pages.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'code_product'   => 'required|string|max:100|unique:products,code_product,' . $product->id,
            'name_product'   => 'required|string|max:255',
            'price_product'  => 'required|integer|min:0',
            'description'    => 'nullable|string',
            'unit'           => 'required|string|max:50',
            'image_product'  => 'required|url',
            'category_id'    => 'required|exists:category_product,id',
            'supplier_id'    => 'required|exists:suppliers,id'
        ]);

        $product->update([
            'code_product' => $request->code_product,
            'name_product' => $request->name_product,
            'price_product' => $request->price_product,
            'description' => $request->description,
            'unit' => $request->unit,
            'image_product' => $request->image_product,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id
        ]);

        if ($request->quantity_import && $request->quantity_import > 0) {
            $product->quantity += $request->quantity_import;
            $product->save();

            ImportProduct::create([
                'product_id' => $product->id,
                'quantity' => $request->quantity_import,
                'date_import' => now(),
                'user_id' => session('user')->id
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công');
    }

    public function toggleStatus(Product $product)
    {
        $product->status_product = $product->status_product == 0 ? 1 : 0;
        $product->save();

        return response()->json(['success' => true, 'new_status' => $product->status_product]);
    }
}
