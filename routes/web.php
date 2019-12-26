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
Route::get('/isSessionEnd', 'isSessionEnd'); // invoked
Route::get('/getSessionError', 'getSessionError'); // invoked
Route::get('refresh-csrf', function(){
    return csrf_token();
});

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');
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
});
/* end employee */

/* start admin */
Route::name('admin.')->prefix('admin')->group(function () {
	Route::get('/', function(){
		echo "admin";
	});
	
	/* start category */
	Route::prefix('category')->name('category.')->namespace('Master')->group(function(){		
		Route::get('/', 'GolonganController@index')->name('index');
		Route::get('/data', 'GolonganController@data')->name('data');
		Route::get('/create', 'GolonganController@create')->name('create');
		Route::post('/store', 'GolonganController@store')->name('store');
		Route::get('/edit/{id}', 'GolonganController@edit')->name('edit');
		Route::put('/update/{id}', 'GolonganController@update')->name('update');
	});
	/* end category */

	// start jabatan
	Route::prefix('jabatan')->name('jabatan.')->namespace('Master')->group(function(){		
		Route::get('/',  'JabatanController@index')->name('index');
		Route::get('/data', 'JabatanController@data')->name('data');
		Route::get('/create', 'JabatanController@create')->name('create');
		Route::post('/store', 'JabatanController@store')->name('store');
		Route::get('/edit/{id}', 'JabatanController@edit')->name('edit');
		Route::put('/update/{id}', 'JabatanController@update')->name('update');
	});
	// end jabatan

	// start perusahaan
	Route::prefix('perusahaan')->name('perusahaan.')->namespace('Master')->group(function(){		
		Route::get('/',  'PerusahaanController@index')->name('index');
		Route::get('/data', 'PerusahaanController@data')->name('data');
		Route::get('/created', 'PerusahaanController@created')->name('created');
		Route::post('/store', 'PerusahaanController@store')->name('store');
		Route::get('/edit/{id}', 'PerusahaanController@edit')->name('edit');
		Route::put('/update/{id}', 'PerusahaanController@update')->name('update');
	});
	// end perusahaan

	// start perusahaan_cabang
	Route::prefix('PerusahaanCabang')->name('perusahaan_cabang.')->group(function(){		
		Route::get('/',  'PerusahaanCabangController@index')->name('index');
		Route::get('/data', 'PerusahaanCabangController@data')->name('data');
		Route::get('/created', 'PerusahaanCabangController@created')->name('created');
	});
	// end perusahaan

	// start country
	Route::prefix('Country')->name('country.')->group(function(){		
		Route::get('/',  'CountryController@index')->name('index');
		Route::get('/data', 'CountryController@data')->name('data');
		Route::get('/created', 'CountryController@created')->name('created');
	});
	// end country

	// start province
	Route::prefix('province')->name('province.')->namespace('Master')->group(function(){			
		Route::get('/',  'ProvinceController@index')->name('index');
		Route::get('/data', 'ProvinceController@data')->name('data');
		Route::get('/create', 'ProvinceController@create')->name('create');
		Route::post('/store', 'ProvinceController@store')->name('store');
		Route::get('/edit/{id}', 'ProvinceController@edit')->name('edit');
		Route::put('/update/{id}', 'ProvinceController@update')->name('update');
	});
	// end province

	/* start Pegawai */
	Route::prefix('pegawai')->name('pegawai.')->group(function(){		
		Route::get('/', 'PegawaiController@index')->name('index');
		Route::get('/data', 'PegawaiController@data')->name('data');
		Route::get('/image', 'PegawaiController@getImage')->name('image');
		Route::post('/detect', 'PegawaiController@faceDetect')->name('detect');
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