<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Departments;
use App\Permission;
use App\Role;
use App\User;



class DepartmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index()
    {
        return Departments::latest()->get();
    }

    public function store(Request $request)
    {   
        if($request->user()->can('create & edit')) {
            $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
            ]);
                // echo $request['first_name'];
            return Departments::create([
               'name' => $request['name'],
               'description' => $request['description'],
            ]);
        }
        else{
            return response()->json([
                'status' => 'failed',
                'message' => 'You can\'t create department with your authority'
               ]);
        }
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {   
        
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $user = Departments::findOrFail($id);

        $user->update($request->all());
    }

    public function destroy($id)
    {
        $user = Departments::findOrFail($id);
        $user->delete();
        return response()->json([
         'message' => 'Department deleted successfully'
        ]);
    }
}
