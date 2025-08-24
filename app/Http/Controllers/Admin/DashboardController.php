<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderFeedback;
use App\Models\Product;
use App\Models\Promotion;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DashboardController extends Controller
{
    public function reports(Request $request)
    {
        // 1. Báo cáo đổi trả / bảo hành
        $orderIssues = OrderDetail::with(['order', 'product'])
            ->whereIn('status_detail', [1,2,3])
            ->get();

        // 2. Báo cáo khuyến mãi
        $promotions = Promotion::withCount('products')->get();

        // 3. Báo cáo phản hồi
        $feedbackOrders = Order::whereHas('feedbacks')->with('feedbacks')->get();

        // 4. Báo cáo tồn kho
        $topProductsStock = Product::orderBy('quantity', 'desc')->take(5)->get();

        // 5. Doanh thu + bán chạy
        $year = $request->year ?? Carbon::now()->year;
        $month = $request->month ?? null;

        $ordersQuery = Order::with(['orderDetails.product']);
        if ($month) {
            $ordersQuery->whereYear('date_order', $year)->whereMonth('date_order', $month);
        } else {
            $ordersQuery->whereYear('date_order', $year);
        }
        $orders = $ordersQuery->get();

        $totalRevenue = $orders->sum('total_order');

        $productsSold = [];
        foreach ($orders as $order) {
            foreach ($order->orderDetails as $detail) {
                $pid = $detail->product_id;
                if (!isset($productsSold[$pid])) {
                    $productsSold[$pid] = [
                        'product' => $detail->product,
                        'quantity' => 0,
                        'revenue' => 0,
                    ];
                }
                $productsSold[$pid]['quantity'] += $detail->quantity;
                $productsSold[$pid]['revenue'] += $detail->total_detail;
            }
        }

        $bestSelling = collect($productsSold)->sortByDesc('quantity')->take(5);
        $worstSelling = collect($productsSold)->sortBy('quantity')->take(5);

        return view('admin.pages.dashboard.index', compact(
            'orderIssues',
            'promotions',
            'feedbackOrders',
            'topProductsStock',
            'totalRevenue',
            'bestSelling',
            'worstSelling',
            'year',
            'month'
        ));
    }

    public function exportReportsExcel(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year;
        $month = $request->month ?? null;

        // Lấy lại dữ liệu y hệt reports()
        $orderIssues = OrderDetail::with(['order', 'product'])
            ->whereIn('status_detail', [1,2,3])
            ->get();
        $promotions = Promotion::withCount('products')->get();
        $feedbackOrders = Order::whereHas('feedbacks')->with('feedbacks')->get();
        $topProductsStock = Product::orderBy('quantity', 'desc')->take(5)->get();

        $ordersQuery = Order::with(['orderDetails.product']);
        if ($month) {
            $ordersQuery->whereYear('date_order', $year)->whereMonth('date_order', $month);
        } else {
            $ordersQuery->whereYear('date_order', $year);
        }
        $orders = $ordersQuery->get();
        $totalRevenue = $orders->sum('total_order');

        $productsSold = [];
        foreach ($orders as $order) {
            foreach ($order->orderDetails as $detail) {
                $pid = $detail->product_id;
                if (!isset($productsSold[$pid])) {
                    $productsSold[$pid] = [
                        'product' => $detail->product->name_product ?? '',
                        'quantity' => 0,
                        'revenue' => 0,
                    ];
                }
                $productsSold[$pid]['quantity'] += $detail->quantity;
                $productsSold[$pid]['revenue'] += $detail->total_detail;
            }
        }
        $bestSelling = collect($productsSold)->sortByDesc('quantity')->take(5);
        $worstSelling = collect($productsSold)->sortBy('quantity')->take(5);

        // ============ Tạo file Excel bằng PhpSpreadsheet ============
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $row = 1;

        // 1. Đổi trả
        $sheet->setCellValue("A{$row}", '=== Báo cáo đổi trả / bảo hành ==='); $row++;
        foreach ($orderIssues as $od) {
            $sheet->setCellValue("A{$row}", $od->order_id);
            $sheet->setCellValue("B{$row}", $od->product->name_product ?? '');
            $sheet->setCellValue("C{$row}", $od->status_text);
            $row++;
        }

        $row += 1;

        // 2. Khuyến mãi
        $sheet->setCellValue("A{$row}", '=== Báo cáo khuyến mãi ==='); $row++;
        foreach ($promotions as $promo) {
            $sheet->setCellValue("A{$row}", $promo->name_promotion);
            $sheet->setCellValue("B{$row}", $promo->value . '%');
            $sheet->setCellValue("C{$row}", $promo->products_count);
            $row++;
        }

        $row += 1;

        // 3. Phản hồi
        $sheet->setCellValue("A{$row}", '=== Báo cáo phản hồi ==='); $row++;
        foreach ($feedbackOrders as $order) {
            $sheet->setCellValue("A{$row}", "Order #{$order->id}");
            $sheet->setCellValue("B{$row}", $order->feedbacks->count() . ' phản hồi');
            $row++;
        }

        $row += 1;

        // 4. Tồn kho
        $sheet->setCellValue("A{$row}", '=== Top 5 sản phẩm tồn kho ==='); $row++;
        foreach ($topProductsStock as $p) {
            $sheet->setCellValue("A{$row}", $p->name_product);
            $sheet->setCellValue("B{$row}", $p->quantity);
            $row++;
        }

        $row += 1;

        // 5. Doanh thu + bán chạy
        $sheet->setCellValue("A{$row}", '=== Doanh thu & bán hàng ==='); $row++;
        $sheet->setCellValue("A{$row}", 'Tổng doanh thu');
        $sheet->setCellValue("B{$row}", $totalRevenue);
        $row++;

        $sheet->setCellValue("A{$row}", '--- Top 5 bán chạy ---'); $row++;
        foreach ($bestSelling as $p) {
            $sheet->setCellValue("A{$row}", $p['product']);
            $sheet->setCellValue("B{$row}", $p['quantity']);
            $sheet->setCellValue("C{$row}", $p['revenue']);
            $row++;
        }

        $row++;
        $sheet->setCellValue("A{$row}", '--- Top 5 bán chậm nhất ---'); $row++;
        foreach ($worstSelling as $p) {
            $sheet->setCellValue("A{$row}", $p['product']);
            $sheet->setCellValue("B{$row}", $p['quantity']);
            $sheet->setCellValue("C{$row}", $p['revenue']);
            $row++;
        }

        // Xuất file
        $writer = new Xlsx($spreadsheet);
        $filename = "reports.xlsx";
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $filename);
    }
}
