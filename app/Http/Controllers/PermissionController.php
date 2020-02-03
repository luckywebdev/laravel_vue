<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function Permission()
    {   
    	$dev_permission = Permission::where('slug','create-tasks')->first();
		$manager_permission = Permission::where('slug', 'edit-users')->first();

		//RoleTableSeeder.php
		$dev_role = new Role();
		$dev_role->slug = 'developer';
		$dev_role->name = 'Front-end Developer';
		$dev_role->save();
		$dev_role->permissions()->attach($dev_permission);

		$manager_role = new Role();
		$manager_role->slug = 'manager';
		$manager_role->name = 'Assistant Manager';
		$manager_role->save();
		$manager_role->permissions()->attach($manager_permission);

		$dev_role = Role::where('slug','developer')->first();
		$manager_role = Role::where('slug', 'manager')->first();

		$createTasks = new Permission();
		$createTasks->slug = 'create-tasks';
		$createTasks->name = 'Create Tasks';
		$createTasks->save();
		$createTasks->roles()->attach($dev_role);

		$editUsers = new Permission();
		$editUsers->slug = 'edit-users';
		$editUsers->name = 'Edit Users';
		$editUsers->save();
		$editUsers->roles()->attach($manager_role);

		$dev_role = Role::where('slug','developer')->first();
		$manager_role = Role::where('slug', 'manager')->first();
		$dev_perm = Permission::where('slug','create-tasks')->first();
		$manager_perm = Permission::where('slug','edit-users')->first();

		$developer = new User();
		$developer->first_name = 'Mahedi';
		$developer->last_name = 'Hasan';
		$developer->email = 'mahedi@gmail.com';
        $developer->password = bcrypt('secrettt');
        $developer->title = "";
        $developer->tel_mobile = "";
        $developer->role = "";
		$developer->save();
		$developer->roles()->attach($dev_role);
		$developer->permissions()->attach($dev_perm);

		$manager = new User();
		$manager->first_name = 'Hafizul';
		$manager->last_name = 'Islam';
		$manager->email = 'hafiz@gmail.com';
		$manager->password = bcrypt('secrettt');
        $manager->title = "";
        $manager->tel_mobile = "";
        $manager->role = "";
		$manager->save();
		$manager->roles()->attach($manager_role);
		$manager->permissions()->attach($manager_perm);

		
		return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Permission::latest()->get();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'required',
        //     'slug' => 'required',
        // ]);
            // echo $request['name'];
        return Permission::create([
           'name' => $request['name'],
           'slug' => $request['slug'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required',
        ]);

        $user = Permission::findOrFail($id);

        $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Permission::findOrFail($id);
        $user->delete();
        return response()->json([
         'message' => 'Permission deleted successfully'
        ]);
    }
}
