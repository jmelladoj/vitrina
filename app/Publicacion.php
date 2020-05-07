<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publicacion extends Model
{
    //
    use SoftDeletes;

    protected $table = 'publicaciones';
    protected $guarded = ['id'];
    protected $appends = ['nombreUsuario', 'foto_perfil', 'comunas', 'expira', 'estado_publicacion'];

    public function getNombreUsuarioAttribute(){
        return $this->usuario->nombre;
    }

    public function getFotoPerfilAttribute(){

        if($this->usuario->usuario_pago == 1){
            $imagen = $this->imagen_perfil_publicacion();

            if($imagen){
                return 'storage/' . $imagen->url;
            } else {
                return 'https://image.flaticon.com/icons/svg/2892/2892879.svg';
            }
        } else {
            return 'https://image.flaticon.com/icons/svg/2892/2892879.svg';
        }
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

    public function getEstadoPublicacionAttribute(){
        $expira = Carbon::createFromDate($this->expira);

        if(Carbon::now() < $expira){
            return 1;
        } else {
            return 0;
        }
    }

    public function imagenes_publicacion(){
        return $this->hasMany(ImagenPublicacion::class, 'publicacion_id');
    }

    public function imagen_perfil_publicacion(){
        return $this->hasMany(ImagenPublicacion::class, 'publicacion_id')->where('perfil', 1)->first();
    }
}
