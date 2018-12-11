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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');

Route::any('/ipn', 'PaymentController@ipn');
Route::any('/cancel', 'PaymentController@cancel');
Route::any('/return', 'PaymentController@return');

Route::get('/privacy', 'PageController@privacy');

Route::group(['middleware' => ['auth:web', 'admin'], 'prefix' => '/admin'], function() {

    $this->get('/', 'Admin\DashboardController@index');
    $this->get('users', 'Admin\UserController@index');
    $this->resource('categories', 'Admin\CategoryController');
    $this->resource('packs', 'Admin\PackController');

    $this->get('categories/{category}/questions', 'Admin\QuestionController@index');
    $this->get('categories/{category}/questions/create', 'Admin\QuestionController@create');
    $this->post('categories/{category}/questions', 'Admin\QuestionController@store');
});

