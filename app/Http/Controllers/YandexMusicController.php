<?php

namespace App\Http\Controllers;

use App\Http\Requests\YandexMusicSaveRequest;
use App\Models\User;
use App\Services\ImageGeneration;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use StounhandJ\YandexMusicApi\Client;

class YandexMusicController extends Controller
{
    public function save(YandexMusicSaveRequest $request)
    {
        $user = User::query()->where("login", $request->getLogin())->firstOrNew();

        if (!$user->exists()) {
            User::query()->create([
                "login" => $request->getLogin(),
                "token" => $request->getAccessToken()
            ])->save();
        } else {
            $user->token = $request->getAccessToken();
            $user->save();
        }
    }

    public function view(Request $request)
    {
        if (!$request->exists("uid")) {
            return response("Bad Request", 400);
        }

        $user = User::query()->where("login", $request->query("uid"))->firstOrNew();

        if (!$user->exists) {
            return response("Not Found", 404);
        }
        $client = new Client($user->token);
        $queue = $client->queuesList()[0];
        $track = $queue->getTracks()[$queue->getCurrentIndex()];

        return response(Storage::get(ImageGeneration::generate($track)))->header('Content-Type', 'image/png');
    }
}
