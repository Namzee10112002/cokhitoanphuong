<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use App\Models\OrderFeedback;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function index($orderId)
    {
        $user = session('user');

        // Nếu không phải admin thì phải kiểm tra chủ đơn hàng
        if ($user->role == 0) {
            $order = \App\Models\Order::find($orderId);

            if (!$order || $order->user_id != $user->id) {
                abort(403, 'Bạn không có quyền truy cập vào đơn hàng này.');
            }
        }

        return view('admin.pages.orders.chat', compact('orderId'));
    }
    public function fetch($orderId)
{
    $messages = OrderFeedback::where('order_id', $orderId)
                             ->orderBy('time_message', 'asc')
                             ->get();

    $user = session('user');

    $html = '';

    foreach ($messages as $message) {
        // Nếu belong khác với user hiện tại thì là đối phương
        $isSelf = ($message->belong == ($user->role == 0 ? 0 : 1));

        if ($isSelf) {
            // Tin nhắn của bản thân (phải)
            $html .= '<div class="text-end mb-2">
                        <span class="badge bg-primary">' . htmlspecialchars($message->message) . '</span>
                      </div>';
        } else {
            // Tin nhắn đối phương (trái)
            $html .= '<div class="text-start mb-2">
                        <span class="badge bg-secondary">' . htmlspecialchars($message->message) . '</span>
                      </div>';
        }
    }

    return $html;
}


public function send(Request $request)
{
    $data = $request->json()->all();  // Lấy dữ liệu từ JSON body
    $user = session('user');

    // Check quyền sở hữu đơn hàng nếu là user thường
    if ($user->role == 0) {
        $order = \App\Models\Order::find($data['order_id']);

        if (!$order || $order->user_id != $user->id) {
            return response()->json(['success' => false, 'message' => 'Bạn không có quyền gửi tin nhắn cho đơn hàng này.'], 403);
        }
    }

    OrderFeedback::create([
        'order_id'     => $data['order_id'],
        'message'      => $data['message'],
        'belong'       => ($user->role == 0) ? 0 : 1,  // Tự động gán belong
        'time_message' => now()
    ]);

    return response()->json(['success' => true]);
}

public function sendMessage(Request $request)
{
    $message = strtolower($request->input('message'));  // chuyển về lowercase để so sánh dễ

    $reply = '';

    // Check xem message có chứa keyword truy vấn dữ liệu không
    if (strpos($message, 'danh mục sản phẩm') !== false) {
        $categories = CategoryProduct::where('status_category', 0)->get();
        if ($categories->isEmpty()) {
            $reply = 'Hiện tại chưa có danh mục sản phẩm nào.';
        } else {
            $reply = "Danh mục sản phẩm hiện có:<br>";
            foreach ($categories as $category) {
                $reply .= '- <a class="link" href="' . url('/product') . '?categories[]=' . $category->id . '">' . $category->name_category . '</a><br>';
            }
        }

    } elseif (strpos($message, 'nhà cung cấp') !== false) {
        $suppliers = Supplier::where('status_supplier', 0)->get();
        if ($suppliers->isEmpty()) {
            $reply = 'Hiện tại chưa có nhà cung cấp nào.';
        } else {
            $reply = "Danh sách nhà cung cấp hiện có:<br>";
            foreach ($suppliers as $supplier) {
                $reply .= '- <a class="link" href="' . url('/product') . '?suppliers[]=' . $supplier->id . '">' . $supplier->name_supplier . '</a><br>';
            }
        }

    } elseif (strpos($message, 'sản phẩm') !== false) {
        $products = Product::where('status_product', '!=', 1)->limit(5)->get();
        if ($products->isEmpty()) {
            $reply = 'Hiện tại chưa có sản phẩm nào.';
        } else {
            $reply = "Một số sản phẩm nổi bật:<br>";
            foreach ($products as $product) {
                $reply .= '- <a class="link" href="' . url('/product/' . $product->id) . '">' . $product->name_product . '</a> (Giá: ' . number_format($product->price) . ' VND)<br>';
            }
            $reply .= '<br><a class="link" href="' . url('/product') . '">Xem thêm sản phẩm tại đây</a>';
        }

    } else {
        // Nếu không phải các câu lệnh trên thì gọi GPT như cũ
        $response = Http::withHeaders([
            'Authorization' => env('OPENAI_API_KEY') ,
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'Bạn là trợ lý hỗ trợ khách hàng ngành cơ khí. Chỉ trả lời các câu hỏi liên quan sản phẩm, chính sách mua hàng.'],
                ['role' => 'user', 'content' => $message],
            ],
            'max_tokens' => 500,
        ]);

        $data = $response->json();
        $reply = $data['choices'][0]['message']['content'] ?? 'Xin lỗi, tôi chưa hiểu câu hỏi của bạn.';
    }

    // Lưu lịch sử vào session
    $chatHistory = session()->get('chatbot_history', []);
    $chatHistory[] = ['role' => 'user', 'message' => $message];
    $chatHistory[] = ['role' => 'bot', 'message' => $reply];
    session(['chatbot_history' => $chatHistory]);

    return response()->json(['reply' => $reply]);
}

public function getHistory()
{
    $chatHistory = session()->get('chatbot_history', []);
    return response()->json($chatHistory);
}


}
