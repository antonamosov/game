<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function() {

    $this->get('profile', 'ProfileController@show');

    $this->group(['prefix' => 'notifications'], function() {
        $this->get('/', 'NotificationController@index');
       $this->delete('/', 'NotificationController@destroyAll');
       $this->put('{notification}/accept', 'NotificationController@accept');
        $this->put('{notification}/reject', 'NotificationController@reject');
    });

    $this->apiResources([
        'packs' => 'PackController',
        'products' => 'ProductController',
        'users' => 'UserController',
        'friends' => 'FriendController',
        'games' => 'GameController',
        'trainings' => 'TrainingController',
        'categories' => 'CategoryController'
    ]);

    $this->get('games/{game}/question/get', 'QuestionController@get');
    $this->post('games/{game}/answer/check', 'AnswerController@check');

    $this->post('cart', 'CartController@store');

    $this->post('packs/{pack}/buy', 'PackController@buyByCoins');
});

