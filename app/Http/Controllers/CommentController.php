<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Comment;
use Auth;
use Carbon\Carbon;
use App\DeletedComment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function postCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment_content' => 'required|max:160'
        ]);

        if ($validator->fails()) {
            return redirect('/topic/view/'.$request->topicId)->withErrors($validator)->withInput();
        }
        else {
            $comment = Comment::create([
                  'id_tema_comentado' => $request->topicId
                , 'id_usuario_creador' => Auth::user()->id_usuario
                , 'contenido_comentario' => $request['comment_content']
                , 'fecha_creacion' => Carbon::now()->toDateTimeString()
            ]);
            return redirect("/comment/view/{$comment->id_comentario}");
        }
    }

    public function getView($commentId)
    {
        // TODO: Hacer que la página se mueva automáticamente hacia el nuevo comentario.
        $comment = Comment::findOrFail($commentId);
        return redirect("/topic/view/{$comment->topic->id_tema}");
    }

    public function postRemove(Request $request)
    {
        $comment = Comment::findOrFail($request->commentId);

        if (DeletedComment::all()->where('id_comentario_eliminado', intval($request->commentId))
                ->count() == 0) {
            DeletedComment::create([
                'id_comentario_eliminado' => $request->commentId
                , 'id_usuario_que_elimina' => $request->userId
                , 'motivo_eliminacion_comentario' => 'Eliminación por botón ubicado en el comentario.'
                , 'fecha_eliminacion' => Carbon::now()
            ]);
        }
        return redirect('topic/view/'.$comment->topic->id_tema);
    }
}
