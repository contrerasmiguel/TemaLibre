<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRequestResolution extends Model
{
    protected $table = 'solicitudes_usuario_atendidas';
    protected $primaryKey = 'id_solicitud_atendida';
    public $timestamps = false;

    protected $fillable = [
          'id_solicitud_atendida'
        , 'id_administrador_asistente'
        , 'resolucion'
        , 'fecha_atencion'
    ];
    
    public function administrator()
    {
        return $this->belongsTo('App\Administrator', 'id_administrador_asistente', 'id_administrador');
    }
    
    public function userRequest()
    {
        return $this->belongsTo('App\UserRequest', 'id_solicitud_atendida', 'id_solicitud');
    }
}
