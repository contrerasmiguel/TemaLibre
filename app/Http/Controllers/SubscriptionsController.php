<?php

namespace App\Http\Controllers;

use App\TopicSubscription;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Topic;
use App\User;

class SubscriptionsController extends Controller
{
     public function postCreate(Request $request)
    {
        try {
            Topic::findOrFail($request->topicId);
            User::findOrFail($request->userId);

            $subscriptionExists =
                TopicSubscription::where('id_tema_suscrito', $request->topicId)
                ->where('id_usuario_suscrito', $request->userId)
                ->where('activo', 1)->count() > 0;

            if (!$subscriptionExists) {
                TopicSubscription::create([
                    'id_tema_suscrito' => $request->topicId
                    , 'id_usuario_suscrito' => $request->userId
                    , 'activo' => 1
                    , 'fecha_suscripcion' => Carbon::now()
                ]);
            }
        }
        catch (ModelNotFoundException $ex) {  }

        return response(200);
    }

    public function postRemove(Request $request)
    {
        try {
            Topic::findOrFail($request->topicId);
            User::findOrFail($request->userId);

            TopicSubscription::where('id_tema_suscrito', $request->topicId)
                ->where('id_usuario_suscrito', $request->userId)
                ->where('activo', 1)->update(['activo' => 0]);
        }
        catch (ModelNotFoundException $ex) {  }

        return response(200);
    }
}
