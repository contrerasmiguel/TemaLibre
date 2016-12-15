<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    protected $table = 'solicitudes_usuario';
    protected $primaryKey = 'id_solicitud';
    public $timestamps = false;

    protected $fillable = [
          'id_usuario_solicitante'
        , 'contenido_solicitud'
        , 'fecha_solicitud'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_usuario_solicitante', 'id_usuario');
    }

    public function userRequestResolution()
    {
        return $this->hasOne('App\UserRequestResolution', 'id_solicitud_atentida', 'id_solicitud');
    }
}
