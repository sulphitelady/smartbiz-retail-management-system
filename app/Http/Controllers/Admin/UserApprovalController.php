<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    public function index()
    {
        $users = User::where('status', 'pending')->latest()->get();

        return view('admin.users.index', compact('users'));
    }
    public function approve(Request $request, $id)
{
    $user = User::findOrFail($id);

    // approve user
    $user->status = 'approved';
    $user->save();

    // assign role from form
    $role = $request->input('role', 'staff'); // default staff

    $user->syncRoles([$role]);

    return back()->with('success', 'User approved and role assigned!');
}

    public function reject($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'User rejected successfully');
    }
}