<?php

namespace App\Http\Controllers;

use App\Administrator;
use App\DeletedComment;
use App\DeletedTopic;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Topic;
use Auth;
use Carbon\Carbon;
use App\User;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCreate()
    {
        return view('topic.create');
    }

    public function postCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
              'title' => 'required|max:64'
            , 'description' => 'required|max:160'
        ]);

        if ($validator->fails()) {
            return redirect('topic/create')->withErrors($validator)->withInput();
        }
        else {
            $topicExists = Topic::where('id_usuario_creador', Auth::user()->id_usuario)
                ->where('titulo', $request['title'])->count();

            if ($topicExists) {
                return redirect('topic/create')->withErrors([
                    'titulo' => 'Ya existe un tema con el mismo '
                ])->withInput();
            }
            else {
                $topic = Topic::create([
                    'id_usuario_creador' => Auth::user()->id_usuario
                    , 'titulo' => $request['title']
                    , 'descripcion' => $request['description']
                    , 'fecha_creacion' => Carbon::now()->toDateTimeString()
                ]);
                return redirect("topic/view/{$topic->id_tema}");
            }
        }
    }

    public function getList()
    {
        $topics = Topic::all()->reduce(function ($topics, $topic) {
            if (DeletedTopic::all()->where('id_tema_eliminado'
                    , $topic->id_tema)->count() > 0) {
                return $topics;
            }
            else {
                return $topics->push(collect([
                    'number' => $topics->count() + 1
                    , 'topicId' => $topic->id_tema
                    , 'title' => $topic->titulo
                    , 'description' => (strlen($topic->descripcion) >= 45)
                        ? substr($topic->descripcion, 0, 42) . '...'
                        : $topic->descripcion
                    , 'username' => $topic->user->nombre_usuario
                    , 'comment_count' => $topic->comments->count()
                ]));
            }
        }, collect([]));

        return view('topic.list', ['topics' => $topics]);
    }

    public function getView($topicId)
    {
        if (DeletedTopic::all()->where('id_tema_eliminado', intval($topicId))->count() == 0) {
            $topic = Topic::findOrFail($topicId);

            $topicData = [
                'topicId' => $topicId
                , 'title' => $topic->titulo
                , 'username' => $topic->user->nombre_usuario
                , 'date' => $topic->fecha_creacion
                , 'content' => $topic->descripcion
                , 'comments' => $topic->comments->reduce(function ($comments, $comment) {
                    if (DeletedComment::all()->where('id_comentario_eliminado'
                        , $comment->id_comentario)->count() > 0) {
                        return $comments;
                    }
                    else {
                        return $comments->push(collect([
                            'commentId' => $comment->id_comentario
                            , 'username' => $comment->user->nombre_usuario
                            , 'date' => $comment->fecha_creacion
                            , 'content' => $comment->contenido_comentario
                            , 'isCommentAuthor' => $comment->user == Auth::user()
                        ]));
                    }
                }, collect([]))
                , 'subscribed' => $topic->topicSubscriptions
                        ->where('id_usuario_suscrito', Auth::user()->id_usuario)
                        ->where('activo', 1)->count() > 0
                , 'isAdministrator' => Administrator::all()
                        ->where('id_administrador', Auth::user()->id_usuario)
                        ->count() > 0
                , 'isTopicAuthor' => $topic->user == Auth::user()
            ];
            return view('topic.view', ['topicData' => $topicData]);
        }
        else {
            return redirect('/');
        }
    }

    public function postRemove(Request $request)
    {
        if (DeletedTopic::all()->where('id_tema_eliminado', intval($request->topicId))
                ->count() == 0) {
            DeletedTopic::create([
                  'id_tema_eliminado' => $request->topicId
                , 'id_usuario_que_elimina' => $request->userId
                , 'motivo_eliminacion_tema' => 'Eliminación por botón ubicado en el tema.'
                , 'fecha_eliminacion' => Carbon::now()
            ]);
        }
        return redirect('/');
    }
}
