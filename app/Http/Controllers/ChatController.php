<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderFeedback;

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

        return view('user.pages.order-feedback', compact('orderId'));
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



}
