<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{
public function addToCart(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity'   => 'required|integer|min:1'
    ]);

    $userId = session('user')->id;
    $productId = $request->product_id;
    $quantity = $request->quantity;

    $result = Cart::addToCart($userId, $productId, $quantity);

    if (!$result['success']) {
        return redirect()->back()->withErrors(['cart' => $result['message']])->withInput();
    }

    return redirect()->back()->with('success', $result['message']);
}

public function cart()
{
    $userId = session('user')->id;
    $cartItems = Cart::getCartByUser($userId);

    return view('user.pages.cart', compact('cartItems'));
}
public function delete($id)
{
    $cartItem = Cart::find($id);

    if ($cartItem && $cartItem->user_id == session('user')->id) {
        $cartItem->delete();
    }

    return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
}
public function update(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $cartItem = Cart::find($id);

    if ($cartItem && $cartItem->user_id == session('user')->id) {
        // Kiểm tra tồn kho
        if ($request->quantity > $cartItem->product->quantity) {
            return redirect()->back()->withErrors(['quantity' => 'Số lượng vượt quá tồn kho']);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();
    }

    return redirect()->route('cart.index')->with('success', 'Cập nhật số lượng thành công.');
}
public function checkout(Request $request)
{
    $request->validate([
        'name_order'    => 'required|string',
        'phone_order'   => 'required|string',
        'address_order' => 'required|string',
        'method_pay'   => 'required|in:0,1,2',
    ]);

    $userId = session('user')->id;
    $cartItems = Cart::with('product.promotion')->where('user_id', $userId)->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->withErrors(['cart' => 'Giỏ hàng của bạn đang trống.']);
    }

    DB::beginTransaction();

    try {
        // Bước 1: Kiểm tra sản phẩm khả dụng & tồn kho
        foreach ($cartItems as $item) {
            $product = $item->product;

            if ($product->status_product == 1) {
                DB::rollBack();
                return redirect()->route('cart.index')->withErrors(['cart' => 'Sản phẩm "' . $product->name_product . '" hiện không khả dụng.']);
            }

            if ($item->quantity > $product->quantity) {
                DB::rollBack(); // Rollback trước khi update giỏ hàng

                // Cập nhật lại số lượng giỏ hàng (Nằm ngoài Transaction)
                $item->quantity = $product->quantity;
                $item->save();

                return redirect()->route('cart.index')->withErrors(['cart' => 'Số lượng sản phẩm "' . $product->name_product . '" vượt quá tồn kho. Số lượng đã được cập nhật.']);
            }
        }

        // Bước 2: Thêm vào bảng orders
        $order = Order::create([
            'user_id'          => $userId,
            'name_order'    => $request->name_order,
            'phone_order'   => $request->phone_order,
            'address_order' => $request->address_order,
            'method_pay'   => $request->method_pay,
            'status_order'           => 0, // 0: Chờ xử lý
            'total_order'           => $request->total_order,
            'note_order'           => $request->note_order,
        ]);

        // Bước 3: Thêm vào bảng order_details + trừ tồn kho
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'order_id'    => $order->id,
                'product_id'  => $item->product_id,
                'quantity'    => $item->quantity,
                'total_detail' => $item->product->promotion_id != null ? $item->product->price*((100-$item->product->promotion->value)/100) * $item->quantity : $item->product->price * $item->quantity
            ]);

            // Trừ tồn kho
            $item->product->quantity -= $item->quantity;
            $item->product->sold += $item->quantity;
            $item->product->save();
        }

        // Xóa giỏ hàng
        Cart::where('user_id', $userId)->delete();

        DB::commit();
        if ($request->method_pay == 2) {
    $momoResponse = $this->callMomoPayment($request->total_order);

    if (isset($momoResponse['payUrl'])) {
        return redirect()->route('cart.index')
                         ->with('success', 'Đặt hàng thành công.')
                         ->with('momo_pay_url', $momoResponse['payUrl']);
    } else {
        return redirect()->route('cart.index')->withErrors(['cart' => 'Không thể kết nối đến MOMO.']);
    }
}

return redirect()->route('cart.index')->with('success', 'Đặt hàng thành công.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('cart.index')->withErrors(['cart' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
    }
}
public function callMomoPayment($amount)
{
    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

    $partnerCode = 'MOMOBKUN20180529';
    $accessKey = 'klm05TvNBzhg7h7j';
    $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

    $orderInfo = "Thanh toán đơn hàng";
    $orderId = time() . "";
    $redirectUrl = route('payment.momo.return');
    $ipnUrl = route('payment.momo.return');
    $extraData = "";
    $requestId = time() . "";

    $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=captureWallet";
    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    $data = [
        'partnerCode' => $partnerCode,
        'accessKey' => $accessKey,
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'extraData' => $extraData,
        'requestType' => 'captureWallet',
        'signature' => $signature
    ];

    $response = Http::post($endpoint, $data);
    return $response->json();
}


public function momoReturn(Request $request)
{
    if ($request->resultCode == 0) {
        return redirect()->route('orders.index')->with('success', 'Thanh toán MOMO thành công!');
    } else {
        return redirect()->route('cart.index')->with('error', 'Thanh toán MOMO thất bại!');
    }
}


}
