<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopicSubscription extends Model
{
    protected $table = 'suscripciones_temas';
    protected $primaryKey = 'id_suscripcion';
    public $timestamps = false;

    protected $fillable = [
          'id_tema_suscrito'
        , 'id_usuario_suscrito'
        , 'activo'
        , 'fecha_suscripcion'
    ];

    public function topic()
    {
        return $this->belongsTo('App\Topic', 'id_tema_suscrito', 'id_tema');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_usuario_suscrito', 'id_usuario');
    }
}
