<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    //
    public function index($tipo){
        switch ($tipo) {
            case 1:
                return ['planes' => Plan::orderBy('nombre', 'asc')->get()];
                break;
        }
    }

    public function crear_actualizar(Request $request){
        Plan::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'nombre' => $request->nombre,
                'duracion' => $request->duracion,
                'valor' => $request->valor
            ]
        );
    }

    public function borrar(Request $request){
        Plan::find($request->id)->delete();
    }
}
