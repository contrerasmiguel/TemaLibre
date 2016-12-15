<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeletedComment extends Model
{
    protected $table = 'comentarios_eliminados';
    protected $primaryKey = 'id_comentario_eliminado';
    public $timestamps = false;

    protected $fillable = [
          'id_comentario_eliminado'
        , 'id_usuario_que_elimina'
        , 'motivo_eliminacion_comentario'
        , 'fecha_eliminacion'
    ];

    public function comment()
    {
        return $this->belongsTo('App\Comment', 'id_comentario_eliminado', 'id_comentario');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_usuario_que_elimina', 'id_usuario');
    }
}
