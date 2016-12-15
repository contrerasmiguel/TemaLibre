<?php

namespace App\Http\Controllers;

use App\DeletedTopic;
use App\TopicSubscription;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Comment;
use App\Topic;
use Auth;
use Validator;
use App\DeletedComment;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex()
    {
        $topicSubscriptions = Auth::user()->topicSubscriptions->where('activo', 1)
            ->reduce(function ($topicSubscriptions, $topicSubscription) {
                if (DeletedTopic::all()->where('id_tema_eliminado', $topicSubscription
                        ->topic->id_tema)->count() > 0) {
                    return $topicSubscriptions;
                }
                else {
                    return $topicSubscriptions->push(collect([
                        'number' => $topicSubscriptions->count() + 1
                        , 'topicSubscription' => $topicSubscription
                    ]));
                }
            }, collect([]));

        $comments = Auth::user()->topicSubscriptions->where('activo', 1)
            ->map(function ($topicSubscription) {
                return Topic::find($topicSubscription->topic->id_tema);
            })->reduce(function ($comments, $topic) {
                return $comments->push($topic->comments);
            }, collect([]))
            ->flatten()->sortByDesc('fecha_creacion')
            ->reduce(function ($comments, $comment) {
                $isTopicDeteled = DeletedTopic::all()
                    ->where('id_tema_eliminado', $comment->id_tema_comentado)
                    ->count() > 0;
                $isCommentDeleted = DeletedComment::all()
                    ->where('id_comentario_eliminado', $comment->id_comentario)
                    ->count() > 0;

                if ($isTopicDeteled || $isCommentDeleted) {
                    return $comments;
                }
                else {
                    return $comments->push($comment);
                }
            }, collect([]));

        return view('index', [
              'topicSubscriptions' => $topicSubscriptions
            , 'comments' => $comments
        ]);
    }
    
    public function getEdit()
    {
        return view('profile.edit');
    }

    public function postEdit(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
              'clave' => 'required|min:3|max:32|confirmed'
            , 'clave_confirmation' => 'same:clave'
            , 'correo_electronico' => 'required|max:255'
            , 'nombre' => 'required|min:2|max:32'
            , 'apellido' => 'required|min:2|max:32'
            , 'pregunta_secreta' => 'required|max:255'
            , 'respuesta_secreta' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect('profile/edit')->withErrors($validator)->withInput();
        }
        else {
            if (User::all()->reject(function ($user) {
                return $user == Auth::user();
            })->where('correo_electronico', $data['correo_electronico'])->count() > 0) {
                return redirect('profile/edit')
                    ->withErrors(['El correo electrónico ingresado ya está en uso.'])
                    ->withInput();
            }
            else {
                Auth::user()->update(array_replace($data, ['clave' => bcrypt($data['clave'])]));
                return redirect('/');
            }
        }
    }
    
    public function getList()
    {
        return view('profile.list', ['users' => User::all()]);
    }

    public function getView($userId)
    {
        if ($userId == Auth::user()->id_usuario) {
            return redirect('/');
        }
        else {
            $user = User::findOrFail($userId);

            $topicSubscriptions = $user->topicSubscriptions->where('activo', 1)
                ->reduce(function ($topicSubscriptions, $topicSubscription) {
                    if (DeletedTopic::all()->where('id_tema_eliminado', $topicSubscription
                            ->topic->id_tema)->count() > 0) {
                        return $topicSubscriptions;
                    }
                    else {
                        return $topicSubscriptions->push(collect([
                            'number' => $topicSubscriptions->count() + 1
                            , 'topicSubscription' => $topicSubscription
                        ]));
                    }
                }, collect([]));

            return view('profile.view', [
                'user' => $user
                , 'topicSubscriptions' => $topicSubscriptions]);
        }
    }
}
