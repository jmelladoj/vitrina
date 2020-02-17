<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    //
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

    public function getExpiraAttribute(){
        return $this->created_at->addMonth($this->plan->duracion)->format('Y-m-d H:m:s');
    }
}
