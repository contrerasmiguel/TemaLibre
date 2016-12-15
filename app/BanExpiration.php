<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BanExpiration extends Model
{
    protected $table = 'expiracion_suspensiones';
    protected $primaryKey = 'id_suspension';
    public $timestamps = false;

    protected $fillable = [
          'id_suspension'
        , 'fecha_expiracion'
        , 'fecha_creacion_expiracion'
    ];

    public function ban()
    {
        return $this->belongsTo('App\Ban', 'id_suspension', 'id_suspension');
    }
}
