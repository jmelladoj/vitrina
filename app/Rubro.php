<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rubro extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['id' ];

    protected $dates = ['deleted_at'];

    protected $appends = ['usuarios_asociados'];

    public function getUsuariosAsociadosAttribute(){
        return $this->hasMany(RubroUsuario::class, 'rubro_id')->count();
    }
}
