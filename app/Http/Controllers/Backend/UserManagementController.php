<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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
}
