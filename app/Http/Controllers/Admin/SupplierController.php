<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('admin.pages.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.pages.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_supplier' => 'required|string|max:255'
        ]);

        Supplier::create([
            'name_supplier' => $request->name_supplier,
            'status_supplier' => 0
        ]);

        return redirect()->route('admin.suppliers.index')->with('success', 'Tạo nhà cung cấp thành công');
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.pages.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name_supplier' => 'required|string|max:255'
        ]);

        $supplier->name_supplier = $request->name_supplier;
        $supplier->save();

        return redirect()->route('admin.suppliers.index')->with('success', 'Cập nhật nhà cung cấp thành công');
    }

    public function toggleStatus(Supplier $supplier)
    {
        $supplier->status_supplier = $supplier->status_supplier == 0 ? 1 : 0;
        $supplier->save();

        return response()->json(['success' => true, 'new_status' => $supplier->status_supplier]);
    }
}
