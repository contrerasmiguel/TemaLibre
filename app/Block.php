<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table = 'bloqueos';
    protected $primaryKey = 'id_bloqueo';
    public $timestamps = false;

    protected $fillable = [
          'id_usuario_bloqueado'
        , 'id_usuario_que_bloquea'
        , 'activo'
        , 'fecha_bloqueo'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_usuario_que_bloquea', 'id_usuario');
    }

    public function blockedUser()
    {
        return $this->belongsTo('App\User', 'id_usuario_bloqueado', 'id_usuario');
    }
}
