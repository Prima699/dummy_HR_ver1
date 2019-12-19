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

Auth::routes();
Route::get('/test', 'test'); // invoked
Route::get('/ShowLoggedInUser', 'ShowLoggedInUser'); // invoked
Route::get('refresh-csrf', function(){
    return csrf_token();
});

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('data', ['as' => 'user.departemen', 'uses' => 'DepartemenController@index']);

/* start auth */
Route::group([
	'prefix' => 'auth',
	'namespace' => 'Auth'
], function () {	
	Route::post('login', 'AuthController@LogIn')->name('auth.login');
	Route::get('logout', 'AuthController@LogOut')->name('auth.logout');
});
/* end auth */

/* start employee */
Route::name('employee.')->middleware('employee')->prefix('employee')->group(function () {
	Route::get('/', function(){
		echo "employee";
	});
	Route::prefix('presence')->name('presence.')->namespace('Presence')->group(function(){
		Route::get('/', 'PresenceController@index')->name('index');
	});
});
/* end employee */

/* start admin */
Route::name('admin.')->prefix('admin')->group(function () {
	Route::get('/', function(){
		echo "admin";
	});
	
	/* start golongan */
	Route::prefix('golongan')->name('golongan.')->group(function(){		
		Route::get('/', 'GolonganController@index')->name('index');
		Route::get('/created', 'GolonganController@created')->name('created');
		Route::get('/data', 'GolonganController@data')->name('data');
	});
	/* end golongan */

	/* start Pegawai */
	Route::prefix('pegawai')->name('pegawai.')->group(function(){		
		Route::get('/', 'PegawaiController@index')->name('index');
		Route::get('/data', 'PegawaiController@data')->name('data');
	});
	/* end Pegawai */
});
/* end admin */

Route::get('Departemen', ['as' => 'data.departemen', 'uses' => 'DepartemenController@index']);
Route::get('Perusahaan', ['as' => 'data.perusahaan', 'uses' => 'PerusahaanController@index']);
Route::get('PerusahaanCabang', ['as' => 'data.perusahaan_cabang', 'uses' => 'PerusahaanCabangController@index']);
Route::get('Jabatan', ['as' => 'data.jabatan', 'uses' => 'JabatanController@index']);

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});