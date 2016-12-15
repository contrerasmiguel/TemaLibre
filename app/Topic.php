<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'temas';
    protected $primaryKey = 'id_tema';
    public $timestamps = false;

    protected $fillable = [
          'id_usuario_creador'
        , 'titulo'
        , 'descripcion'
        , 'fecha_creacion'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_usuario_creador', 'id_usuario');
    }
    
    public function comments()
    {
        return $this->hasMany('App\Comment', 'id_tema_comentado', 'id_tema');
    }
    
    public function topicSubscriptions()
    {
        return $this->hasMany('App\TopicSubscription', 'id_tema_suscrito', 'id_tema');
    }

    public function deletedTopic()
    {
        return $this->hasOne('App\DeletedTopic', 'id_tema_eliminado', 'id_tema');
    }
}
