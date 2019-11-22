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

// 前台路由
Route::group(['namespace'=>'Index'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('archives', 'IndexController@archives');
    Route::get('archives/{id}.html', 'IndexController@archivesDetail');
    Route::get('{id}.html', 'IndexController@pageDetail');
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

    // 内容管理 标签管理
    Route::any('admin/tag/index', 'TagController@index');
    Route::any('admin/tag/create', 'TagController@create');
    Route::any('admin/tag/show', 'TagController@show');
    Route::any('admin/tag/update', 'TagController@update');
    Route::any('admin/tag/delete', 'TagController@delete');
    Route::any('admin/tag/order', 'TagController@order');

    // 内容管理 文章管理
    Route::any('admin/article/index', 'ArticleController@index');
    Route::any('admin/article/create', 'ArticleController@create');
    Route::any('admin/article/show', 'ArticleController@show');
    Route::any('admin/article/update', 'ArticleController@update');
    Route::any('admin/article/delete', 'ArticleController@delete');

    // 内容管理 页面管理
    Route::any('admin/page/index', 'PageController@index');
    Route::any('admin/page/create', 'PageController@create');
    Route::any('admin/page/show', 'PageController@show');
    Route::any('admin/page/update', 'PageController@update');
    Route::any('admin/page/delete', 'PageController@delete');
    Route::any('admin/page/order', 'PageController@order');
});
