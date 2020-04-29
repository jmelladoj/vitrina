<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanPublicacion extends Model
{
    //
    protected $table = 'plan_publicaciones';

    protected $guarded = ['id' ];

    public function plan(){
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function publicacion(){
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }

}
