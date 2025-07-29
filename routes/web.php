<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\HomeUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAdminOrStaff;
use App\Http\Middleware\CheckUser;
use App\Http\Middleware\CheckLoggedIn;
use App\Http\Middleware\CheckGuest;

//route không cần xác thực
Route::get('/', [HomeUserController::class, 'index']);
Route::get('/home', [HomeUserController::class, 'index'])->name('home');
Route::get('/about', [HomeUserController::class, 'about'])->name('about');
Route::get('/contact', [HomeUserController::class, 'contact'])->name('contact');
Route::get('/product/{id}', [HomeUserController::class, 'productDetail'])->name('product.detail');
Route::get('/product', [HomeUserController::class, 'product'])->name('product');
Route::post('/chatbot/message', [ChatController::class, 'sendMessage'])->name('chatbot.message');
Route::get('/chatbot/history', [ChatController::class, 'getHistory'])->name('chatbot.history');
//

Route::middleware([CheckGuest::class])->group(function () {
    Route::get('/auth', [AuthController::class, 'index'])->name('auth');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware([CheckLoggedIn::class])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware([CheckLoggedIn::class, CheckUser::class])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
    Route::post('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/orders', [HomeUserController::class, 'ordered'])->name('orders.index');
    Route::get('/chat/{order_id}', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/fetch/{order_id}', [ChatController::class, 'fetch'])->name('chat.fetch');
    Route::post('/chat-send', [ChatController::class, 'send'])->name('chat.send');
    Route::post('/payment/momo', [CartController::class, 'momoPayment'])->name('payment.momo');
    Route::get('/payment/momo/return', [CartController::class, 'momoReturn'])->name('payment.momo.return');
});


//route chi truy cập nếu là admin hoặc staff
Route::prefix('admin')->as('admin.')->middleware([CheckLoggedIn::class, CheckAdminOrStaff::class])->group(function () {
    Route::get('/', [HomeAdminController::class, 'index']);
    Route::get('/home', [HomeAdminController::class, 'index'])->name('home');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::post('/categories/toggle-status/{category}', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');

    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::post('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::post('/suppliers/{supplier}/toggle-status', [SupplierController::class, 'toggleStatus'])->name('suppliers.toggleStatus');

    Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');
    Route::get('/promotions/create', [PromotionController::class, 'create'])->name('promotions.create');
    Route::post('/promotions', [PromotionController::class, 'store'])->name('promotions.store');
    Route::post('/promotions/{promotion}/delete', [PromotionController::class, 'delete'])->name('promotions.delete');
    Route::get('/promotions/{promotion}/products', [PromotionController::class, 'products'])->name('promotions.products');
    Route::post('/promotions/{promotion}/assign-product', [PromotionController::class, 'assignProduct'])->name('promotions.assignProduct');
    Route::post('/promotions/{promotion}/remove-product/{product}', [PromotionController::class, 'removeProduct'])->name('promotions.removeProduct');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::post('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/update', [OrderController::class, 'update'])->name('orders.update');
    Route::get('/orders/{order}/detail', [OrderController::class, 'detail'])->name('orders.detail');
    Route::post('/orders/{orderDetail}/update-status', [OrderController::class, 'updateDetailStatus'])->name('orders.updateDetailStatus');

    Route::get('/chat/{orderId}', [ChatController::class, 'index'])->name('chat');
    Route::get('/chat/fetch/{orderId}', [ChatController::class, 'fetch'])->name('chat.fetch');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');

    Route::get('/warranty', [OrderController::class, 'warranty'])->name('warranty');
    Route::post('/warranty/update-status/{orderDetail}', [OrderController::class, 'updateDetailStatus'])->name('warranty.updateStatus');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/filter-revenue', [DashboardController::class, 'filterRevenue'])->name('dashboard.filterRevenue');
});
//
