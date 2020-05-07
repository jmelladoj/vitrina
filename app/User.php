<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['tipo', 'usuario_pago', 'foto_perfil'];

    public function getUsuarioPagoAttribute(){
        $ventas = $this->ventas_usuario();

        foreach ($ventas as $v) {
            if($v->estado == 1 && $v->valor > 0 && Carbon::now() < $v->publicacion->expira){
                return 1;
            }
        }

        return 0; 
    }

    public function getTipoAttribute(){
        return $this->administrador == 1 ? 'Administrador' : 'Usuario';
    }

    public function comunas(){
        return $this->hasMany(ComunaUsuario::class, 'user_id')->select('nombre');
    }

    public function ventas_usuario(){
        return $this->hasMany(PlanPublicacion::class, 'user_id')->get();
    }

    public function getFotoPerfilAttribute(){
        if($this->perfil_url != 'https://image.flaticon.com/icons/svg/149/149076.svg'){
            return 'storage/' . $this->perfil_url;
        } else {
            return $this->perfil_url;
        }
    }


}
