<?php

namespace App\Http\Controllers;

use App\Comuna;
use App\ComunaUsuario;
use App\Publicacion;
use App\Rubro;
use App\RubroUsuario;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{
    //
    public function index($comuna_id, $rubro){
        $rubros = Rubro::where('nombre', 'like', '%' . $rubro . '%')->get()->pluck('id');
        $comuna = Comuna::find($comuna_id);
        $rubro = $rubro;

        return view('resultados')->with(compact(['comuna', 'rubro', 'rubros']));
    }

    public function index_buscador(Request $request){
        $usuarios_comuna = ComunaUsuario::where('comuna_id', $request->comuna_id)->get()->pluck('user_id');
        $usuarios_rubro = RubroUsuario::whereIn('rubro_id', $request->rubros)->whereIn('user_id', $usuarios_comuna)->get()->pluck('user_id');
        $publicaciones = Publicacion::whereIn('user_id', $usuarios_rubro)->where('plan_id', '!=', null)->with('usuario')->orderBy('created_at', 'asc')->get();

        return ['publicaciones' =>  $publicaciones];
    }

    public function ver($id){
        $publicacion = Publicacion::find($id);

        return view('publicacion')->with(compact(['publicacion']));
    }
}
