<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];
    public $timestamps = false;
    public static function addToCart($userId, $productId, $quantity)
    {
        $product = \App\Models\Product::find($productId);

        if (!$product) {
            return ['success' => false, 'message' => 'Sản phẩm không tồn tại.'];
        }

        // Kiểm tra sản phẩm đã có trong giỏ chưa
        $cartItem = self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        $currentQuantityInCart = $cartItem ? $cartItem->quantity : 0;
        $totalQuantityAfterAdd = $currentQuantityInCart + $quantity;

        if ($totalQuantityAfterAdd > $product->quantity) {
            return [
                'success' => false,
                'message' => 'Số lượng trong giỏ hàng vượt quá số lượng tồn kho (' . $product->quantity . ').'
            ];
        }

        if ($cartItem) {
            // Nếu đã có sản phẩm trong giỏ -> tăng số lượng
            $cartItem->quantity = $totalQuantityAfterAdd;
            $cartItem->save();
        } else {
            // Nếu chưa có -> thêm mới
            self::create([
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => $quantity
            ]);
        }

        return ['success' => true, 'message' => 'Thêm vào giỏ hàng thành công.'];
    }
    public static function getCartByUser($userId)
    {
        return self::with(['product.promotion'])
            ->where('user_id', $userId)
            ->get();
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
