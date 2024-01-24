<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::latest()->paginate(10);
        return view('admin.roles.index',compact('roles'));
    }

    public function create(){
        $permissions = Permission::all();
        return view('admin.roles.create',compact('permissions'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => $request->name,
            ]);

            $permissions = $request->except('_token','name');
            $role->givePermissionTo($permissions);

            DB::commit();
        } catch (\Exception $x) {
            DB::rollBack();
            alert()->warning('ذخیر با خطا روبرو شد','خطا');
            return redirect()->back();
        }

        alert()->success('The new role was created','Well');
        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role){
        $permissions = Permission::all();
        return view('admin.roles.edit',compact('role','permissions'));
    }

    public function update(Request $request, Role $role){
        $request->validate([
            'name' => 'required'
        ]);

        try {
            DB::beginTransaction();
            $role->update([
                'name' => $request->name
            ]);

            $permissions = $request->except('_token','_method','name');

            $role->syncPermissions($permissions);

            DB::commit();
        } catch (\Exception $x) {
            DB::rollBack();
            alert()->warning('ذخیر با خطا روبرو شد','خطا');
            return redirect()->back();
        }

        alert()->success('The role was updated','Well');
        return redirect()->route('admin.roles.index');

    }
}
