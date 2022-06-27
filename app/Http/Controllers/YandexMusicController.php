<?php

namespace App\Http\Controllers;

use App\Http\Requests\YandexMusicSaveRequest;
use App\Models\User;
use App\Services\ImageGeneration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use StounhandJ\YandexMusicApi\Client;

class YandexMusicController extends Controller
{
    public function save(YandexMusicSaveRequest $request)
    {
        $client = new Client($request->getAccessToken());

        if ($client->accountStatus()->getAccount()->login !== $request->getLogin()) {
            return response()->json(["message" => "error", "response" => "login mismatch"], 400);
        }

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

        return response()->json(["message" => "success", "response" => route("view", ["uid" => $request->getLogin()])], 200);
    }

    public function delete(YandexMusicSaveRequest $request)
    {
        $client = new Client($request->getAccessToken());

        if ($client->accountStatus()->getAccount()->login !== $request->getLogin()) {
            return response()->json(["message" => "error", "response" => "login mismatch"], 400);
        }

        $result = 404;
        $user = User::query()->where("login", $request->getLogin())->firstOrNew();

        if ($user->exists()) {
            $user->delete();
            $result = 200;
        }

        return response()->json(["message" => $result == 200 ? "success" : "not found"], $result);
    }

    public function view(Request $request)
    {
        #Get user by login
        if (!$request->exists("uid")) {
            return response("Bad Request", 400);
        }
        $user = User::query()->where("login", $request->query("uid"))->firstOrNew();
        if (!$user->exists) {
            return response("Not Found", 404);
        }

        $trackImg = $user->last_track;
        #------

        $client = new Client($user->token);
        $queues = $client->queuesList();

        if (count($queues) != 0 && count($queues[0]->getTracks()) != 0) {
            $queue = $queues[0];

            $track = $queue->getTracks()[$queue->getCurrentIndex()];
            $trackImg = ImageGeneration::generate($track);

            if ($trackImg != $user->last_track) {
                $user->last_track = $trackImg;
                $user->save();
            }
        }

        return is_null($trackImg)?
            response("Not Found", 404) :
            response(Storage::get($trackImg))->header('Content-Type', 'image/png');
    }
}
