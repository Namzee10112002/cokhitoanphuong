<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\HomeUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeUserController::class, 'index']);
Route::get('/home', [HomeUserController::class, 'index'])->name('home');
Route::get('/about', [HomeUserController::class, 'about'])->name('about');
Route::get('/contact', [HomeUserController::class, 'contact'])->name('contact');
Route::get('/auth', [AuthController::class, 'index'])->name('auth');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

Route::get('/product/{id}', [HomeUserController::class, 'productDetail'])->name('product.detail');
Route::get('/product', [HomeUserController::class, 'product'])->name('product');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
Route::post('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::get('/orders', [HomeUserController::class, 'ordered'])->name('orders.index');

Route::get('/chat/{order_id}', [ChatController::class, 'index'])->name('chat.index');
Route::get('/chat/fetch/{order_id}', [ChatController::class, 'fetch'])->name('chat.fetch');
Route::post('/chat-send', [ChatController::class, 'send'])->name('chat.send');

