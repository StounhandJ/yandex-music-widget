<?php

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
    $client = new Client("AQAAAAAFSs5rMAG1XnKLIFYVMFV4ibf1kw3FqA0");
    $queue = $client->queuesList()[0];
    $track = $queue->getTracks()[$queue->getCurrentIndex()];
    return Storage::response(ImageGeneration::generate($track));
});
