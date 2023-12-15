<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;


use App\Http\Controllers\Backend\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();


//================================================//
//             White Dashboad Routes              //
//================================================//
Route::group(['middleware' => 'auth'], function () {
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
		Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
		Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
		Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
		Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
		Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});


//================================================//
//                   Custom Routes                //
//================================================//
Route::get('/dashboard', 'App\Http\Controllers\HomeController@index')->name('dashboard')->middleware('auth');
Route::group(['middleware' => ['auth', 'permission']], function () {

	Route::get('/export-permissions', function () {
		$filename = 'permissions.csv';
		$filePath = createCSV($filename);
	
		return Response::download($filePath, $filename);
	})->name('export.permissions');

	Route::group(['as' => 'um.', 'prefix' => 'user-management'], function () {
		Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
			Route::get('index', [UserManagementController::class, 'index'])->name('user_list');
			Route::get('details/{id}', [UserManagementController::class, 'details'])->name('details.user_list');
			Route::get('create', [UserManagementController::class, 'create'])->name('user_create');
			Route::post('create', [UserManagementController::class, 'store'])->name('user_create');
			Route::get('edit/{id}', [UserManagementController::class, 'edit'])->name('user_edit');
			Route::put('edit/{id}', [UserManagementController::class, 'update'])->name('user_edit');
			Route::get('status/{id}', [UserManagementController::class, 'status'])->name('status.user_edit');
			Route::get('delete/{id}', [UserManagementController::class, 'delete'])->name('user_delete');
		});
		Route::group(['as' => 'permission.', 'prefix' => 'permission'], function () {
			Route::get('index', [UserManagementController::class, 'p_index'])->name('permission_list');
			Route::get('details/{id}', [UserManagementController::class, 'p_details'])->name('details.permission_list');
			Route::get('create', [UserManagementController::class, 'P_create'])->name('permission_create');
			Route::post('create', [UserManagementController::class, 'p_store'])->name('permission_create');
			Route::get('edit/{id}', [UserManagementController::class, 'p_edit'])->name('permission_edit');
			Route::put('edit/{id}', [UserManagementController::class, 'p_update'])->name('permission_edit');
		});
		Route::group(['as' => 'role.', 'prefix' => 'role'], function () {
			Route::get('index', [UserManagementController::class, 'r_index'])->name('role_list');
			Route::get('details/{id}', [UserManagementController::class, 'r_details'])->name('details.role_list');
			Route::get('create', [UserManagementController::class, 'r_create'])->name('role_create');
			Route::post('create', [UserManagementController::class, 'r_store'])->name('role_create');
			Route::get('edit/{id}', [UserManagementController::class, 'r_edit'])->name('role_edit');
			Route::put('edit/{id}', [UserManagementController::class, 'r_update'])->name('role_edit');
			Route::get('delete/{id}', [UserManagementController::class, 'r_delete'])->name('role_delete');
		});

	});

	
});