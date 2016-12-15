<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeletedTopic extends Model
{
    protected $table = 'temas_eliminados';
    protected $primaryKey = 'id_tema_eliminado';
    public $timestamps = false;

    protected $fillable = [
          'id_tema_eliminado'
        , 'id_usuario_que_elimina'
        , 'motivo_eliminacion_tema'
        , 'fecha_eliminacion'
    ];

    public function topic()
    {
        return $this->belongsTo('App\Topic', 'id_tema_eliminado', 'id_tema');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_usuario_que_elimina', 'id_usuario');
    }
}
