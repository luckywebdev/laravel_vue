<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Departments;



class DepartmentController extends Controller
{
    public function index()
    {
        return Departments::latest()->get();
    }

    public function store(Request $request)
    {   
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
