<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(){
        $permissions = Permission::latest()->paginate();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create(){
        return view('admin.permissions.create');
    }

    public function store(Request $request){
        //dd($request->all());
        $request->validate([
            'name' => 'required'
        ]);

        Permission::create([
            'name' => $request->name,
        ]);

        alert()->success('The new permission was created', 'Well');
        return redirect()->route('admin.permissions.index');
    }

    public function edit(Permission $permission){
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission){
        $request->validate([
            'name' => 'required'
        ]);
        $permission->update([
            'name' => $request->name
        ]);
        alert()->success('The permission name was updated', 'Well');
        return redirect()->route('admin.permissions.index');
    }
}
