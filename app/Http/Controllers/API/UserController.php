<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Permission;
use App\Role;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        return User::latest()->get();
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
            // echo $request['first_name'];
        $role = Role::where('slug', $request['role'])->first();
        $permission_row = $role->permissions()->first();
        $permission = Permission::where('slug', $permission_row->slug)->first();

        $user = new User();
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->email = $request['email'];
        $user->email_verified_at = now();
        $user->password = \Hash::make($request['password']);
        $user->tel_mobile = $request['tel_mobile'];
        $user->title = $request['title'];
        $user->role = $request['role'];
        $user->save();
        $user->roles()->attach($role);        
        $user->permissions()->attach($permission);        
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        $role = Role::where('slug', $request['role'])->first();
        // $permission_row = $role->permissions()->first();
        // $permission = Permission::where('slug', $permission_row->slug)->first();
        $user = User::findOrFail($id);
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->email = $request['email'];
        $user->email_verified_at = now();
        $user->password = \Hash::make($request['password']);
        $user->tel_mobile = $request['tel_mobile'];
        $user->title = $request['title'];
        $user->role = $request['role'];
        $user->save();
        // $user->update($request->all());
        $user->roles()->attach($role);        
        // $user->permissions()->attach($permission);        

    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
         'message' => 'User deleted successfully'
        ]);
    }
}
