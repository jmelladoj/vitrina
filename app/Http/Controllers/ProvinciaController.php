<?php

namespace App\Http\Controllers;

use App\Provincia;
use App\Comuna;
use Illuminate\Http\Request;

class ProvinciaController extends Controller
{
    //
    public function index($tipo){
        switch ($tipo) {
            case 1:
                return ['provincias' => Provincia::orderBy('nombre', 'asc')->get()];
                break;
        }
    }

    public function index_comuna($id){
        return ['comunas' => Comuna::where('provincia_id', $id)->orderBy('nombre', 'asc')->get()];
    }

    public function index_comunas($tipo){
        switch ($tipo) {
            case 1:
                return ['comunas' => Comuna::orderBy('nombre', 'asc')->get()];
                break;
        }
    }

    public function crear_actualizar(Request $request){
        Provincia::updateOrCreate(
            ['id' => $request->id],
            ['nombre' => $request->nombre]
        );
    }

    public function crear_actualizar_comuna(Request $request){
        Comuna::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'nombre' => $request->nombre,
                'provincia_id' => $request->provincia_id
            ]
        );
    }

    public function borrar(Request $request){
        $provincia = Provincia::find($request->id);
        $provincia->comunas()->delete();
        $provincia->delete();
    }

    public function borrar_comuna(Request $request){
        Comuna::find($request->id)->delete();
    }
}
