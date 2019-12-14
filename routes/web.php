<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

Auth::routes();

// GET      | login                    | App\Http\Controllers\Auth\LoginController@showLoginForm                | web,guest    |
// POST     | login                    | App\Http\Controllers\Auth\LoginController@login                        | web,guest    |
// POST     | logout                   | App\Http\Controllers\Auth\LoginController@logout                       | web          |
// POST     | password/email           | App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail  | web,guest    |
// POST     | password/reset           | App\Http\Controllers\Auth\ResetPasswordController@reset                | web,guest    |
// GET      | password/reset           | App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm | web,guest    |
// GET      | password/reset/{token}   | App\Http\Controllers\Auth\ResetPasswordController@showResetForm        | web,guest    |
// POST     | register                 | App\Http\Controllers\Auth\RegisterController@register                  | web,guest    |
// GET      | register                 | App\Http\Controllers\Auth\RegisterController@showRegistrationForm      | web,guest    |
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

Route::get('/nosotros', function() {
  return view('nosotros');
});

Route::get('/contact', function() {
  return view('contact');
});

Route::get('/ayuda', function() {
  return view('ayuda');
});

Route::get('/registro', function() {
  return view('registro');
});

Route::get('/login', function() {
  return view('login');
});

Route::get('/main', 'ProductController@directory');

Route::get('/remeras', 'ProductController@remeras');

Route::get('/camisas', 'ProductController@camisas');

Route::get('/jeans', 'ProductController@jeans');

Route::get('/buzos', 'ProductController@buzos');

Route::get('/camperas', 'ProductController@camperas');

Route::get('/accesorios', 'ProductController@accesorios');

Route::get('/ofertas', 'ProductController@ofertas');

Route::get('/addProduct', 'ProductController@new');

Route::post('/addProduct', 'ProductController@store');

Route::get('/editProduct/{id}', 'ProductController@edit');

Route::put('/product/{id}', 'ProductController@update');

Route::get('/product/{id}', 'ProductController@show');

Route::get('/cart', 'CartController@show')->middleware('auth');

Route::post('/addToCart', 'CartController@addProduct')->middleware('auth');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
