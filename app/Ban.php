<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    protected $table = 'suspensiones';
    protected $primaryKey = 'id_suspension';
    public $timestamps = false;

    protected $fillable = [
          'id_usuario_suspendido'
        , 'id_administrador_que_suspende'
        , 'motivo'
        , 'fecha_suspension'
    ];

    public function administrator()
    {
        return belongsTo('App\Administrator', 'id_administrador_que_suspende', 'id_administrador');
    }

    public function banExpirations()
    {
        return hasOne('App\BanExpiration', 'id_suspension', 'id_suspension');
    }

    public function user()
    {
        return belongsTo('App\User', 'id_usuario_suspendido', 'id_usuario');
    }
}
