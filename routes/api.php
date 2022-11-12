<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HashtagController;
use App\Http\Controllers\CommentController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('user', UserController::class);
    Route::get('event/line-notify', [EventController::class,"sendLineNotify"]);
    Route::get('event/of/{userId}', [EventController::class,"getEventByUserId"]);
    Route::resource('event', EventController::class);
    Route::resource('profile', ProfileController::class);
    Route::get('auth/verify', [UserController::class, 'verifyToken']);
});

Route::post('event/views', [EventController::class,"updateEventViews"]);
Route::get('event', [EventController::class,"index"]);
Route::post('user/login', [UserController::class,"login"]);
Route::get('user/most-active-user/{platformId}', [UserController::class,"mostActiveUser"]);
Route::patch('post/{postId}/like', [PostController::class,"likePost"]);
Route::patch('post/{postId}/retweet', [PostController::class,"retweetPost"]);
Route::patch('post/{postId}/favorite', [PostController::class,"favoritePost"]);
Route::post('post/sibling', [PostController::class,"createSiblingPost"]);
Route::get('post/latest', [PostController::class,"getlatestPostList"]);
Route::get('post/list', [PostController::class,"getPostList"]);
Route::resource('post', PostController::class);
Route::get('account/tagged', [AccountController::class,"getTaggedList"]);
Route::get('account/list', [AccountController::class,"getAccountList"]);
Route::patch('account/{id}/update-profile-image', [AccountController::class,"updateProfileImage"]);
Route::resource('account', AccountController::class);
Route::get('hashtag/tagged', [HashtagController::class,"getTaggedList"]);
Route::resource('hashtag', HashtagController::class);
Route::resource('comment', CommentController::class);


Route::get( 'auth/verify-fail', function () {
    $data = array(
        "is_valid"=> false
    );
    $response = array(
        "success" =>  false,
        "message" => "invalid token",
        "data" => $data
    );
    return response($response,404);
}
)->name('login');