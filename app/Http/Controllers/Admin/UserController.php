<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController
{

public function index(Request $request)
{
    $currentUser = session('user');
    $users = User::select('id', 'name', 'email', 'phone', 'address', 'last_login', 'status', 'role')
        ->when($currentUser->role == 1, function($query) {
            return $query->where('role', 0);
        })
        ->when($currentUser->role == 2, function($query) {
            return $query->whereIn('role', [0, 1]);
        })
        ->withSum(['orders as total_spent' => function($query) {
            $query->select(DB::raw('SUM(total_order)'));
        }], 'total_order')
        ->get();

    return view('admin.pages.users.index', compact('users'));
}

public function create()
{
    return view('admin.pages.users.create');
}

public function store(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'phone'    => 'required|string|max:10',
        'address'  => 'required|string|max:255',
        'password' => 'required|string|min:6|confirmed',
        'role'     => 'required|in:0,1'
    ]);

    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'phone'    => $request->phone,
        'address'  => $request->address,
        'password' => Hash::make($request->password),
        'role'     => $request->role,
        'status'   => 0
    ]);

    return redirect()->route('admin.users.index')->with('success', 'Tạo người dùng thành công');
}
public function toggleStatus(User $user)
    {
        $user->status = $user->status == 0 ? 1 : 0;
        $user->save();

        return response()->json(['success' => true, 'new_status' => $user->status]);
    }

}

