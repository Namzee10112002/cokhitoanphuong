<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderFeedback;
class OrderController extends Controller
{
    public function index()
{
    $orders = Order::with(['user', 'feedbacks'])
        ->orderBy('status_order')
        ->orderByDesc('date_order')
        ->get();

    return view('admin.pages.orders.index', compact('orders'));
}

public function update(Request $request, Order $order)
{
    $request->validate([
        'status_order' => 'required|integer',
        'method_pay' => 'required|in:0,1,2'
    ]);

    $order->status_order = $request->status_order;
    $order->method_pay = $request->method_pay;
    $order->save();

    return response()->json(['success' => true]);
}

public function detail(Order $order)
{
    $order->load('orderDetails.product');
    return view('admin.pages.orders.detail', compact('order'));
}

public function updateDetailStatus(Request $request, OrderDetail $orderDetail)
{
    $request->validate([
        'status_detail' => 'required|integer'
    ]);

    $orderDetail->status_detail = $request->status_detail;
    $orderDetail->save();

    return response()->json(['success' => true]);
}
public function warranty()
{
    $orderDetails = OrderDetail::with(['product', 'order'])
        ->where('status_detail', '!=', 0)
        ->orderBy('status_detail')
        ->get();

    return view('admin.pages.orders.warranty', compact('orderDetails'));
}
}
