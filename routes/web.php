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
Route::get('/rootApp', 'rootApp'); // invoked
Route::get('refresh-csrf', function(){
    return csrf_token();
});
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');

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
	
	/* start presence */
	Route::prefix('presence')->name('presence.')->namespace('Presence')->group(function(){		
		Route::get('/', 'PresenceController@index')->name('index');
		Route::get('/status', 'PresenceController@status')->name('status');
	});
	/* end presence */
});
/* end employee */

/* start admin */
Route::name('admin.')->middleware('admin')->prefix('admin')->group(function () {
	Route::get('/', function(){
		echo "admin";
	});
	
	/* start agenda */
	Route::prefix('agenda')->name('agenda.')->namespace('Agenda')->group(function(){		
		Route::get('/', 'AgendaController@index')->name('index');
		Route::get('/data', 'AgendaController@data')->name('data');
		Route::get('/create', 'AgendaController@create')->name('create');
		Route::post('/store', 'AgendaController@store')->name('store');
		Route::get('/edit/{id}', 'AgendaController@edit')->name('edit');
		Route::put('/update/{id}', 'AgendaController@update')->name('update');	
		Route::get('/category', 'DependeciesAgendaController@category')->name('category');
		Route::get('/province', 'DependeciesAgendaController@province')->name('province');
		Route::get('/city', 'DependeciesAgendaController@city')->name('city');
		Route::get('/employee', 'DependeciesAgendaController@employee')->name('employee');
		Route::get('/{id}', 'AgendaController@detail')->name('detail');
	});
	/* end agenda */
	
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

	/* start category */
	Route::prefix('departemen')->name('departemen.')->namespace('Master')->group(function(){		
		Route::get('/', 'DepartemenController@index')->name('index');
		Route::get('/data', 'DepartemenController@data')->name('data');
		Route::get('/create', 'DepartemenController@create')->name('create');
		Route::post('/store', 'DepartemenController@store')->name('store');
		Route::get('/edit/{id}', 'DepartemenController@edit')->name('edit');
		Route::put('/update/{id}', 'DepartemenController@update')->name('update');
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
	Route::prefix('perusahaan_cabang')->name('perusahaan_cabang.')->namespace('Master')->group(function(){		
		Route::get('/',  'PerusahaanCabangController@index')->name('index');
		Route::get('/data', 'PerusahaanCabangController@data')->name('data');
		Route::get('/create', 'PerusahaanCabangController@create')->name('create');
		Route::post('/store', 'PerusahaanCabangController@store')->name('store');
		Route::get('/edit/{id}', 'PerusahaanCabangController@edit')->name('edit');
		Route::put('/update/{id}', 'PerusahaanCabangController@update')->name('update');
	});
	// end perusahaan

	// start country
	Route::prefix('country')->name('country.')->namespace('Master')->group(function(){		
		Route::get('/',  'CountryController@index')->name('index');
		Route::get('/data', 'CountryController@data')->name('data');
		Route::get('/create', 'CountryController@create')->name('create');
		Route::post('/store', 'CountryController@store')->name('store');
		Route::get('/edit/{id}', 'CountryController@edit')->name('edit');
		Route::put('/update/{id}', 'CountryController@update')->name('update');
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

	// start province
	Route::prefix('city')->name('city.')->namespace('Master')->group(function(){			
		Route::get('/',  'CityController@index')->name('index');
		Route::get('/data', 'CityController@data')->name('data');
		Route::get('/create', 'CityController@create')->name('create');
		Route::post('/store', 'CityController@store')->name('store');
		Route::get('/edit/{id}', 'CityController@edit')->name('edit');
		Route::put('/update/{id}', 'CityController@update')->name('update');
	});
	// end province

	// start Tipeijin
	Route::prefix('TipeIjin')->name('TipeIjin.')->namespace('Master')->group(function(){			
		Route::get('/',  'TipeIJinController@index')->name('index');
		Route::get('/data', 'TipeIJinController@data')->name('data');
		Route::get('/create', 'TipeIJinController@create')->name('create');
		Route::post('/store', 'TipeIJinController@store')->name('store');
		Route::get('/edit/{id}', 'TipeIJinController@edit')->name('edit');
		Route::put('/update/{id}', 'TipeIJinController@update')->name('update');
	});
	// end Tipeijin

	/* start Pegawai */
	Route::prefix('pegawai')->name('pegawai.')->group(function(){		
		Route::get('/', 'PegawaiController@index')->name('index');
		Route::get('/data', 'PegawaiController@data')->name('data');
		Route::get('/create', 'PegawaiController@create')->name('create');
		Route::post('/store', 'PegawaiController@store')->name('store');
		Route::get('/edit/{id}', 'PegawaiController@edit')->name('edit');
		Route::put('/update/{id}', 'PegawaiController@update')->name('update');
		Route::get('/image/{id}', 'PegawaiController@getImage')->name('image');
		Route::put('/face', 'PegawaiController@face')->name('face');
	});
	/* end Pegawai */

	/* start presence */
	Route::prefix('presence')->name('presence.')->namespace('Master')->group(function(){	
		/* start type */
		Route::prefix('type')->name('type.')->group(function(){		
			Route::get('/', 'PresenceTypeController@index')->name('index');
			Route::get('/data', 'PresenceTypeController@data')->name('data');
			Route::get('/create', 'PresenceTypeController@create')->name('create');
			Route::post('/store', 'PresenceTypeController@store')->name('store');
			Route::get('/edit/{id}', 'PresenceTypeController@edit')->name('edit');
			Route::put('/update/{id}', 'PresenceTypeController@update')->name('update');
			Route::get('/{id}', 'PresenceTypeController@detail')->name('detail');
		});
		/* end type */
		/* start variant */
		Route::prefix('variant')->name('variant.')->group(function(){		
			Route::get('/', 'PresenceVariantController@index')->name('index');
			Route::get('/data', 'PresenceVariantController@data')->name('data');
			Route::get('/create', 'PresenceVariantController@create')->name('create');
			Route::post('/store', 'PresenceVariantController@store')->name('store');
			Route::get('/edit/{id}', 'PresenceVariantController@edit')->name('edit');
			Route::put('/update/{id}', 'PresenceVariantController@update')->name('update');
			Route::get('/{id}', 'PresenceVariantController@detail')->name('detail');
		});
		/* end variant */
	});
	/* end presence */
});
/* end admin */


Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});