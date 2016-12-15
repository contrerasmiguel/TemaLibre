<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comentarios';
    protected $primaryKey = 'id_comentario';
    public $timestamps = false;

    protected $fillable = [
          'id_tema_comentado'
        , 'id_usuario_creador'
        , 'contenido_comentario'
        , 'fecha_creacion'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_usuario_creador', 'id_usuario');
    }

    public function topic()
    {
        return $this->belongsTo('App\Topic', 'id_tema_comentado', 'id_tema');
    }

    public function deletedComment()
    {
        return $this->hasOne('App\DeletedComment', 'id_comentario_eliminado', 'id_comentario');
    }
}
