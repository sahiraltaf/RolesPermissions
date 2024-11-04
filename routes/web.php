<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\HomeController;
// use App\Http\Controllers\RoleController;
// use App\Http\Controllers\UserController;
// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\PermissionController;



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

   
// Route::get('/home', 'HomeController@index')->name('home')->middleware('2fa');


Route::group(['middleware' => ['auth']], function() {   
    Route::get('2fa', [App\Http\Controllers\TwoFAController::class, 'index'])->name('2fa.index');
    Route::post('2fa', [App\Http\Controllers\TwoFAController::class, 'store'])->name('2fa.post');
    Route::get('2fa/reset', [App\Http\Controllers\TwoFAController::class, 'resend'])->name('2fa.resend');
   
    Route::group(['middleware' => ['auth', '2factor']], function() {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::resource('roles','RoleController');
        Route::resource('users','UserController');
        Route::resource('products','ProductController');
        Route::resource('permissions','PermissionController');    


});

});


Auth::routes();
