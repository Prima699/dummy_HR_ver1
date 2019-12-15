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
Route::group([
	'middleware' => ['employee'],
	'prefix' => 'employee',
	'name' => 'employee'
], function () {
	Route::get('/', function(){
		echo "employee";
	});
});
/* end employee */

/* start admin */
Route::name('admin.')->middleware('admin')->prefix('admin')->group(function () {
	Route::get('/', function(){
		echo "admin";
	});
	
	/* start golongan */
	Route::prefix('golongan')->name('golongan.')->group(function(){		
		Route::get('/', 'GolonganController@index')->name('index');
		Route::get('/data', 'GolonganController@data')->name('data');
	});
	/* end golongan */

	// start jabatan
	Route::prefix('jabatan')->name('jabatan.')->group(function(){		
		Route::get('/',  'JabatanController@index')->name('index');
		Route::get('/data', 'JabatanController@data')->name('data');
	});
	// end jabatan

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


Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});