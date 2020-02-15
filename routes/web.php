<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::group(['middleware' => 'role:developer'], function() {

//     Route::get('/admin', function() {
 
//        return 'Welcome Admin';
       
//     });
 
//  });

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin/', function () {
    if (Auth::check()) {
        return view('admin');
    }
    return redirect('/login');

});

Route::get('users', 'UserController@index');
Route::post('users', 'UserController@store');

// User CRUD
Route::get('api/user', 'API\UserController@index');
Route::post('api/user', 'API\UserController@store');
Route::put('api/user/{id}', 'API\UserController@update');
Route::put('api/user_department/{id}', 'API\UserController@update_department');
Route::delete('api/user/{id}', 'API\UserController@destroy');

// Department CRUD
Route::get('api/department', 'API\DepartmentController@index');
Route::post('api/department', 'API\DepartmentController@store');
Route::put('api/department/{id}', 'API\DepartmentController@update');
Route::delete('api/department/{id}', 'API\UserController@destroy');

// Role and Permission
Route::get('api/permissions', 'PermissionController@index');
Route::post('api/permissions', 'PermissionController@store');
Route::put('api/permissions/{id}', 'PermissionController@update');
Route::delete('api/permissions/{id}', 'PermissionController@destroy');
// Role and Permission
Route::get('api/roles', 'RoleController@index');
Route::post('api/roles', 'RoleController@store');
Route::put('api/roles/{id}', 'RoleController@update');
Route::delete('api/roles/{id}', 'RoleController@destroy');

