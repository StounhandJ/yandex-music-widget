<?php

use App\Http\Controllers\YandexMusicController;
use App\Services\ImageGeneration;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use StounhandJ\YandexMusicApi\Client;

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
    return view("welcome");
});

Route::post('/save', [YandexMusicController::class, "save"])->name("save");
Route::get('/view', [YandexMusicController::class, "view"])
    ->middleware("cache.page:10")
    ->name("view");
