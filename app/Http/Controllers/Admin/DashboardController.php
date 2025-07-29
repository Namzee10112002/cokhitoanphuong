<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderFeedback;
use App\Models\OrderDetail;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index()
{
    $totalOrders = Order::count();
    $totalProducts = Product::count();

    $totalStock = Product::sum(DB::raw('quantity - sold'));

    $totalFeedbacks = OrderFeedback::distinct('order_id')->count('order_id');

    $totalReturns = OrderDetail::where('status_detail', '!=', 0)->count();

    $activePromotions = Promotion::withCount('products')->get();

    $revenueToday = Order::whereDate('date_order', now()->toDateString())->sum('total_order');
    $revenueThisMonth = Order::whereMonth('date_order', now()->month)->sum('total_order');

    return view('admin.pages.dashboard.index', compact(
        'totalOrders',
        'totalProducts',
        'totalStock',
        'totalFeedbacks',
        'totalReturns',
        'activePromotions',
        'revenueToday',
        'revenueThisMonth'
    ));
}

public function filterRevenue(Request $request)
{
    $type = $request->input('type'); // 'day' or 'month'
    $value = $request->input('value'); // date or month number

    if ($type === 'day') {
        $revenue = Order::whereDate('date_order', $value)->sum('total_order');
    } else {
        $revenue = Order::whereMonth('date_order', $value)->sum('total_order');
    }

    return response()->json(['revenue' => $revenue]);
}
}
