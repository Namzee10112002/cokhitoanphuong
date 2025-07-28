<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\Product;
class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::all();
        return view('admin.pages.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.pages.promotions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_promotion' => 'required|string|max:255',
            'value' => 'required|integer|min:0|max:100'
        ]);

        Promotion::create([
            'name_promotion' => $request->name_promotion,
            'value' => $request->value,
            'status_promotion' => 0
        ]);

        return redirect()->route('admin.promotions.index')->with('success', 'Tạo promotion thành công');
    }

    public function delete(Promotion $promotion)
    {
        Product::where('promotion_id', $promotion->id)->update(['promotion_id' => null]);
        $promotion->delete();

        return response()->json(['success' => true]);
    }

    public function products(Promotion $promotion)
    {
        $productsUsing = Product::where('promotion_id', $promotion->id)->get();
        $productsNotUsing = Product::whereNull('promotion_id')->get();

        return view('admin.pages.promotions.products', compact('promotion', 'productsUsing', 'productsNotUsing'));
    }

    public function assignProduct(Request $request, Promotion $promotion)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $product = Product::find($request->product_id);
        $product->promotion_id = $promotion->id;
        $product->save();

        return response()->json(['success' => true]);
    }

    public function removeProduct(Promotion $promotion, Product $product)
    {
        if ($product->promotion_id == $promotion->id) {
            $product->promotion_id = null;
            $product->save();
        }

        return response()->json(['success' => true]);
    }
}
