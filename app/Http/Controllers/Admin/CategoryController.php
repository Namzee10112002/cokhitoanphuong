<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;

class CategoryController extends Controller
{
     public function index()
    {
        $categories = CategoryProduct::all();
        return view('admin.pages.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.pages.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_category' => 'required|string|max:255'
        ]);

        CategoryProduct::create([
            'name_category' => $request->name_category,
            'status_category' => 0
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Tạo danh mục thành công');
    }

    public function edit(CategoryProduct $category)
    {
        return view('admin.pages.categories.edit', compact('category'));
    }

    public function update(Request $request, CategoryProduct $category)
    {
        $request->validate([
            'name_category' => 'required|string|max:255'
        ]);

        $category->name_category = $request->name_category;
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công');
    }

    public function toggleStatus(CategoryProduct $category)
    {
        $category->status_category = $category->status_category == 0 ? 1 : 0;
        $category->save();

        return response()->json(['success' => true, 'new_status' => $category->status_category]);
    }
}
