<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
          'nombre_usuario'
        , 'clave'
        , 'correo_electronico'
        , 'nombre'
        , 'apellido'
        , 'pregunta_secreta'
        , 'respuesta_secreta'
        , 'fecha_registro'
    ];

    protected $hidden = [
          'clave'
        , 'pregunta_secreta'
        , 'respuesta_secreta'
        , 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->clave;
    }

    public function administrator()
    {
        return $this->hasOne('App\Administrator', 'id_usuario', 'id_administrador');
    }

    public function topics()
    {
        return $this->hasMany('App\Topic', 'id_usuario_creador', 'id_usuario');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'id_usuario_creador', 'id_usuario');
    }

    public function blocksDone()
    {
        return $this->hasMany('App\Block', 'id_usuario_que_bloquea', 'id_usuario');
    }

    public function blocks()
    {
        return $this->hasMany('App\Block', 'id_usuario_bloqueado', 'id_usuario');
    }
    
    public function deletedComments()
    {
        return $this->hasMany('App\DeletedComment', 'id_usuario_que_elimina', 'id_usuario');
    }
    
    public function userRequests()
    {
        return $this->hasMany('App\UserRequest', 'id_usuario_solicitante', 'id_usuario');
    }
    
    public function bans()
    {
        return $this->hasMany('App\Ban', 'id_usuario_suspendido', 'id_usuario');
    }
    
    public function deletedTopics()
    {
        return $this->hasMany('App\DeletedTopic', 'id_usuario_que_elimina', 'id_usuario');
    }
    
    public function topicSubscriptions()
    {
        return $this->hasMany('App\TopicSubscription', 'id_usuario_suscrito', 'id_usuario');
    }
}
