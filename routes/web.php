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

Route::get('/', function () {
    return view('welcome');
});

// 后台路由
Route::redirect('admin', 'admin/index', 301);
Route::any('admin/login', 'Admin\IndexController@login');
Route::any('admin/logout', 'Admin\IndexController@logout');
Route::group(['namespace'=>'Admin', 'middleware'=>['admin']], function () {
    // 基本路由
    Route::any('admin/index', 'IndexController@index');
    Route::any('admin/profile', 'IndexController@profile');

    // 用户管理 管理员管理
    Route::any('admin/admin/index', 'AdminController@index');
    Route::any('admin/admin/create', 'AdminController@create');
    Route::any('admin/admin/show', 'AdminController@show');
    Route::any('admin/admin/update', 'AdminController@update');
    Route::any('admin/admin/delete', 'AdminController@delete');

    // 用户管理 角色管理
    Route::any('admin/role/index', 'RoleController@index');
    Route::any('admin/role/create', 'RoleController@create');
    Route::any('admin/role/show', 'RoleController@show');
    Route::any('admin/role/update', 'RoleController@update');
    Route::any('admin/role/delete', 'RoleController@delete');

    // 用户管理 权限管理
    Route::any('admin/permission/index', 'PermissionController@index');
    Route::any('admin/permission/create', 'PermissionController@create');
    Route::any('admin/permission/show', 'PermissionController@show');
    Route::any('admin/permission/update', 'PermissionController@update');
    Route::any('admin/permission/delete', 'PermissionController@delete');
    Route::any('admin/permission/order', 'PermissionController@order');

    // 系统管理 配置管理
    Route::any('admin/config/index', 'ConfigController@index');
    Route::any('admin/config/create', 'ConfigController@create');
    Route::any('admin/config/show', 'ConfigController@show');
    Route::any('admin/config/update', 'ConfigController@update');
    Route::any('admin/config/delete', 'ConfigController@delete');
    Route::any('admin/config/order', 'ConfigController@order');

    // 系统管理 配置设定
    Route::any('admin/config/setting', 'ConfigController@setting');
});
