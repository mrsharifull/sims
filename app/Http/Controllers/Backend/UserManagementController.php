<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
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
    public function index():View
    {
        $s['users'] = User::with('role')->where('deleted_at',null)->get();
        return view('backend.user_management.user.index',$s);
    }
    public function create():View
    {
        $s['roles'] = Role::where('deleted_at',null)->latest()->get();
        return view('backend.user_management.user.create',$s);
    }
    public function store(UserRequest $req):RedirectResponse
    {
        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->save();

        $user->assignRole($user->role->name);

        return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' created successfully.'));
    }
    public function edit($id):View
    {
        $s['user'] = User::findOrFail($id);
        $s['roles'] = Role::where('deleted_at',null)->latest()->get();
        return view('backend.user_management.user.edit',$s);
    }
    public function update(UserRequest $req, $id):RedirectResponse
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
    public function delete($id):RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('um.user.user_list')->withStatus(__('User '.$user->name.' deleted successfully.'));

    }


     // Permission Methods PermissionRequest
     public function p_index():View
     {
        $s['permissions'] = Permission::orderBy('prefix')->get();
        return view('backend.user_management.permission.index',$s);
    }
    public function p_create(){
        return view('backend.user_management.permission.create');
    }

    public function p_store(PermissionRequest $req):RedirectResponse
    {
        $permission = new Permission();
        $permission->name = $req->name;
        $permission->prefix = $req->prefix;
        $permission->created_by = auth()->user()->id;
        $permission->save();
        return redirect()->route('um.permission.permission_list')->withStatus(__("$permission->name permission created successfully"));     
    }
    public function p_edit($id):View
    {
        $s['permission'] = Permission::findOrFail($id);
        return view('backend.user_management.permission.edit',$s);
    }
    public function p_update(PermissionRequest $req, $id):RedirectResponse
    {
        $permission = Permission::findOrFail($id);
        $permission->name = $req->name;
        $permission->prefix = $req->prefix;
        $permission->updated_by = auth()->user()->id;
        $permission->update();
        return redirect()->route('um.permission.permission_list')->withStatus(__("$permission->name permission updated successfully"));     
    }



    // User Methods 
    public function r_index():View
    {
        $s['roles'] = Role::where('deleted_at', null)->with('permissions')->latest()->get()
        ->map(function($role){
            $permissionNames = $role->permissions->pluck('name')->implode(' | ');
            $role->permissionNames = $permissionNames;
            return $role;
        });
        return view('backend.user_management.role.index', $s);
    }
    // public function r_create(){
    //     $s['roles'] = Role::where('deleted_at',null)->latest()->get();
    //     return view('backend.user_management.user.create',$s);
    // }
    // public function r_store(UserRequest $req){
    //     $user = new User();
    //     $user->name = $req->name;
    //     $user->email = $req->email;
    //     $user->role_id = $req->role;
    //     $user->password = Hash::make($req->password);
    //     $user->created_by = auth()->user()->id;
    //     $user->save();
    //     $user->assignRole($user->role->name);
    //     return redirect()->route('um.user.user_list')->with('success',"$user->name created successfully");     
    // }
    // public function r_edit($id){
    //     $s['user'] = User::with('role')->first();
    //     $s['roles'] = Role::where('deleted_at',null)->latest()->get();
    //     return view('backend.user_management.user.edit',$s);
    // }
    // public function r_update(UserRequest $req, $id){
    //     $user = User::findOrFail($id);
    //     $user->name = $req->name;
    //     $user->email = $req->email;
    //     $user->role_id = $req->role;
    //     if($req->password){
    //         $user->password = Hash::make($req->password);
    //     }
    //     $user->updated_by = auth()->user()->id;
    //     $user->update();
    //     $user->assignRole($user->role->name);
    //     return redirect()->route('um.user.user_list')->with('success',"$user->name updated successfully");     
    // }
    // public function r_delete($id){
    //     $user = User::findOrFail($id);
    //     $user->delete();
    //     return redirect()->route('um.user.user_list')->with('error',"$user->name deleted successfully");   

    // }

    // public function r_status($id){
    //     $user = User::findOrFail($id);
    //     $this->changeStatus($user);
    //     return redirect()->route('um.user.user_list')->with('success',"$user->name status change successfully");   

    // }
}
