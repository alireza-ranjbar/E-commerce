<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index(){
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user){
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.users.edit',compact('user','roles','permissions'));
    }

    public function update(Request $request, User $user){
        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        $user->syncRoles($request->role);

        alert()->success('The user role was updated');
        return redirect()->route('admin.users.index');

    }
}
