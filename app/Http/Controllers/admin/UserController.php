<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = DB::table('logins')
            ->when($request->search, fn($q) =>
                $q->where('username', 'like', '%' . $request->search . '%')
            )
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.itemMenu.user-list', compact('users'));
    }

    public function create()
    {
        return view('admin.itemMenu.user-form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:logins,username',
            'role'     => 'required|in:Admin,User',
            'password' => 'required|string|min:6|confirmed',
        ]);

        DB::table('logins')->insert([
            'username'   => $request->username,
            'role'       => $request->role,
            'password'   => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('user.index')
            ->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = DB::table('logins')->where('id', $id)->first();

        if (!$user) {
            return redirect()->route('user.index')
                ->with('success', 'User not found.');
        }

        return view('admin.itemMenu.user-form', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:logins,username,' . $id,
            'role'     => 'required|in:Admin,User',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'username'   => $request->username,
            'role'       => $request->role,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('logins')->where('id', $id)->update($data);

        return redirect()->route('user.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('logins')->where('id', $id)->delete();

        return redirect()->route('user.index')
            ->with('success', 'User deleted successfully.');
    }
}