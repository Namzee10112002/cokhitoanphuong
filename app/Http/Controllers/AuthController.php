<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.auth');
    }
    public function profile()
    {
        $user = Session::get('user');
        return view('user.pages.profile', compact('user'));
    }
    public function updateProfile(Request $request)
{
    $user = Session::get('user');

    $request->validate([
        'name'    => 'required|string',
        'email'   => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        'phone'   => 'required|string|max:10',
        'address' => 'required|string',
    ], [
        'email.unique' => 'Email này đã tồn tại.', // Custom message
    ]);

    $user->update([
        'name'    => $request->name,
        'email'   => $request->email,
        'phone'   => $request->phone,
        'address' => $request->address,
    ]);

    Session::put('user', $user->fresh()); // Cập nhật lại session

    return redirect()->route('profile')->with('success', 'Cập nhật thông tin thành công.');
}

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email',
            'phone'    => 'required|string|max:10',
            'address'  => 'required|string',
            'password' => 'required|string|min:8'
        ]);

        // Check email tồn tại chưa
        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'Email này đã tồn tại.'])->withInput();
        }

        // Tạo tài khoản
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('auth')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Tài khoản không tồn tại.'])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Mật khẩu không đúng.'])->withInput();
        }
        if ($user->status==1) {
            return back()->withErrors(['password' => 'Tài khoản bạn đang bị khóa.'])->withInput();
        }

        // Đăng nhập thành công - Lưu Session
        Session::put('user', $user);

        // Cập nhật lần đăng nhập cuối
        $user->update(['last_login' => now()]);

        return redirect()->route('home')->with('success', 'Đăng nhập thành công.');
    }
    public function logout()
    {
        Session::forget('user'); // Xóa session user
        return redirect()->route('home')->with('success', 'Đăng xuất thành công.');
    }
}
