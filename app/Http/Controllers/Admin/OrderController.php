<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderFeedback;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

public function exportInvoice($orderId)
{
    $order = Order::with(['orderDetails.product', 'user'])->findOrFail($orderId);

    // Render ra view hóa đơn
$pdf = Pdf::loadView('admin.pages.orders.invoices', compact('order'))
        ->setPaper('A4')
          ->setOptions([
              'isHtml5ParserEnabled' => true,
              'isRemoteEnabled' => true,
              'defaultFont' => 'DejaVuSans'
          ]);
          
    // Tạo tên file
    $fileName = 'invoice_order_' . $order->id . '.pdf';
    $filePath = 'invoices/' . $fileName;

    // Lưu file PDF vào storage (storage/app/invoices/)
    Storage::disk('local')->put($filePath, $pdf->output());

    // Lưu vào DB invoices
    $invoice = new Invoice();
    $invoice->order_id = $order->id;
    $invoice->invoice_pdf = $filePath;
    $invoice->user_id = session('user')->id;
    $invoice->save();

    // Tải về cho người dùng
    return $pdf->download($fileName);
}
public function downloadInvoice(Order $order, Invoice $invoice)
{
    // Kiểm tra invoice có thuộc order không
    if ($invoice->order_id !== $order->id) {
        abort(403, 'Bạn không có quyền xem hóa đơn này');
    }

    $filePath = $invoice->invoice_pdf; // ví dụ: private/invoices/invoice_order_14.pdf

    if (!Storage::exists($filePath)) {
        abort(404, 'Hóa đơn không tồn tại');
    }

    // Trả về file PDF để tải về/xem
    return Storage::download($filePath, 'HD'.$invoice->id.'.pdf', [
        'Content-Type' => 'application/pdf'
    ]);
}
}
