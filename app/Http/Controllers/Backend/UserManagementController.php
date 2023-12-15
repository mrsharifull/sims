<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Permission;


class UserManagementController extends Controller
{
    // User Methods 
    public function index(): View
    {
        $s['users'] = User::with('role')->where('deleted_at',null)->get();
        return view('backend.user_management.user.index',$s);
    }
    public function create(): View
    {
        $s['roles'] = Role::where('deleted_at',null)->latest()->get();
        return view('backend.user_management.user.create',$s);
    }
    public function store(UserRequest $req): RedirectResponse
    {
        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->save();

        $user->assignRole($user->role->name);

        return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' created successfully.'));
    }
    public function edit($id): View
    {
        $s['user'] = User::findOrFail($id);
        $s['roles'] = Role::where('deleted_at',null)->latest()->get();
        return view('backend.user_management.user.edit',$s);
    }
    public function update(UserRequest $req, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->name = $req->name;
        $user->email = $req->email;
        if($req->password){
            $user->password = Hash::make($req->password);
        }
        $user->update();

        $user->assignRole($user->role->name);
        
        return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' updated successfully.'));
    }
    public function status($id): RedirectResponse
    {
        $user = user::findOrFail($id);
        $this->statusChange($user);
        return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' status updated successfully.'));
    }
    public function delete($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' deleted successfully.'));

    }


     // Permission Methods PermissionRequest
     public function p_index(): View
     {
        $s['permissions'] = Permission::orderBy('prefix')->get();
        return view('backend.user_management.permission.index',$s);
    }
    public function p_create(){
        return view('backend.user_management.permission.create');
    }

    public function p_store(PermissionRequest $req): RedirectResponse
    {
        $permission = new Permission();
        $permission->name = $req->name;
        $permission->prefix = $req->prefix;
        $permission->created_by = auth()->user()->id;
        $permission->save();
        return redirect()->route('um.permission.permission_list')->withStatus(__("$permission->name permission created successfully"));     
    }
    public function p_edit($id): View
    {
        $s['permission'] = Permission::findOrFail($id);
        return view('backend.user_management.permission.edit',$s);
    }
    public function p_update(PermissionRequest $req, $id): RedirectResponse
    {
        $permission = Permission::findOrFail($id);
        $permission->name = $req->name;
        $permission->prefix = $req->prefix;
        $permission->updated_by = auth()->user()->id;
        $permission->update();
        return redirect()->route('um.permission.permission_list')->withStatus(__("$permission->name permission updated successfully"));     
    }



    // Role Methods 
    public function r_index(): View
    {
        $s['roles'] = Role::where('deleted_at', null)->with('permissions')->latest()->get()
        ->map(function($role){
            $permissionNames = $role->permissions->pluck('name')->implode(' | ');
            $role->permissionNames = $permissionNames;
            return $role;
        });
        return view('backend.user_management.role.index', $s);
    }
    public function r_create(): View
    {
        $permissions = Permission::orderBy('name')->get();
        $s['groupedPermissions'] = $permissions->groupBy(function ($permission) {
            return $permission->prefix;
        });
        return view('backend.user_management.role.create',$s);
    }
    public function r_store(RoleRequest $req): RedirectResponse
    {
        $role = new Role();
        $role->name = $req->name;
        $role->created_by = auth()->user()->id;
        $role->save();

        $permissions = Permission::whereIn('id', $req->permissions)->pluck('name')->toArray();
        $role->givePermissionTo($permissions);
        return redirect()->route('um.role.role_list')->withStatus(__("$role->name role created successfully"));   


    }
    public function r_edit($id): View
    {
        $s['role'] = Role::findOrFail($id);
        $s['permissions'] = Permission::orderBy('name')->get();
        $s['groupedPermissions'] = $s['permissions']->groupBy(function ($permission) {
            return explode('_', $permission->name)[0];
        });
        return view('backend.user_management.role.edit',$s);
    }

    public function r_update(RoleRequest $req, $id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->name = $req->name;
        $role->updated_by = auth()->user()->id;
        $role->save();
        $permissions = Permission::whereIn('id', $req->permissions)->pluck('name')->toArray();
        $role->syncPermissions($permissions);

        return redirect()->route('um.role.role_list')->withStatus(__($role->name.' role updated successfully.'));
    }

    public function r_delete($id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('um.role.role_list')->withStatus(__($role->name.' role deleted successfully.'));
    }
}
