<?php

namespace App\Http\Controllers;

use App\Publicacion;
use App\Rubro;
use App\RubroUsuario;
use Illuminate\Http\Request;

class RubroController extends Controller
{
    //
    public function index($tipo){
        switch ($tipo) {
            case 1:
                return ['rubros' => Rubro::orderBy('nombre', 'asc')->get()];
                break;
        }
    }

    public function index_home(){
        return ['rubros' => Rubro::get()->sortByDesc('usuariosAsociados')->take(8)];
    }

    public function index_publicaciones($id){
        $usuarios = RubroUsuario::where('rubro_id', $id)->orderBy('created_at', 'desc')->pluck('user_id');
        return ['publicaciones' => Publicacion::whereIn('user_id', $usuarios)->orderBy('created_at', 'desc')->get()];
    }

    public function crear_actualizar(Request $request){
        Rubro::updateOrCreate(
            ['id' => $request->id],
            ['nombre' => $request->nombre]
        );
    }

    public function borrar(Request $request){
        Rubro::find($request->id)->delete();
    }

}
