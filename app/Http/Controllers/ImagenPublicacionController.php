<?php

namespace App\Http\Controllers;

use App\ImagenPublicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagenPublicacionController extends Controller
{
    //
    public function index($id){
        return ['imagenes' => ImagenPublicacion::where('publicacion_id', $id)->get()];
    }

    public function borrar(Request $request){
        $imagen = ImagenPublicacion::find($request->id);

        Storage::disk('public')->delete($imagen->url);

        $imagen->delete();
    }
}
