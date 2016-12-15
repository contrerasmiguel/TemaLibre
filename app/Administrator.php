<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    protected $table = 'administradores';
    protected $primaryKey = 'id_administrador';
    public $timestamps = false;

    protected $fillable = [
          'id_administrador'
        , 'fecha_promocion'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_administrador', 'id_usuario');
    }
    
    public function ban()
    {
        return $this->hasMany('App\Ban', 'id_administrador_que_suspende', 'id_administrador');
    }

    public function userRequestResolution()
    {
        return $this->hasMany('App\UserRequestResolution', 'id_administrador_asistente', 'id_administrador');
    }
}
