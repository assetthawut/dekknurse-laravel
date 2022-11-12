<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileViewController;
use App\Http\Controllers\CalendarViewController;
use App\Http\Controllers\AuthViewController;
use App\Http\Controllers\EventViewController;
use App\Http\Controllers\PostTagViewController;

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
    // return redirect('/paras');
});

Route::get('login', [AuthViewController::class,"login"]);
Route::resource('profile', ProfileViewController::class);
Route::resource('calendar', CalendarViewController::class);
Route::get('paras', [EventViewController::class,"parasCalendar"]);
Route::get('crypto', [EventViewController::class,"cryptoCalendar"]);
Route::get('my-event', [EventViewController::class,"myEvent"]);
Route::resource('event', EventViewController::class);
Route::resource('post-tag', PostTagViewController::class);

