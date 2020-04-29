<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publicacion extends Model
{
    //
    use SoftDeletes;

    protected $table = 'publicaciones';
    protected $guarded = ['id'];
    protected $appends = ['nombreUsuario', 'foto_perfil', 'comunas', 'expira'];

    public function getNombreUsuarioAttribute(){
        return $this->usuario->nombre;
    }

    public function getFotoPerfilAttribute(){
        return $this->usuario->perfil_url;
    }

    public function getComunasAttribute(){
        return $this->usuario->comunas->implode('nombre', ' - ');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan(){
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function ventas(){
        return $this->hasMany(PlanPublicacion::class, 'publicacion_id');
    }

    public function total_meses_ventas(){
        return $this->hasMany(PlanPublicacion::class, 'publicacion_id')->where('estado', 1)->sum('duracion');
    }

    public function getExpiraAttribute(){
        return $this->created_at->addMonth($this->total_meses_ventas())->format('Y-m-d H:m:s');
    }

    public function imagenes_publicacion(){
        return $this->hasMany(ImagenPublicacion::class, 'publicacion_id');
    }
}
