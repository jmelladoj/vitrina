<?php

namespace App\Http\Controllers;

use App\PlanPublicacion;
use Illuminate\Http\Request;
use Freshwork\Transbank\CertificationBagFactory;
use Freshwork\Transbank\TransbankServiceFactory;
use Freshwork\Transbank\RedirectorHelper;

class PlanPublicacionController extends Controller
{
    //
    public function procesar(Request $request){
        $bag = CertificationBagFactory::integrationWebpayNormal();
        $plus = TransbankServiceFactory::normal($bag);
        $response = $plus->getTransactionResult();

        $venta = PlanPublicacion::where('token', $request->token_ws)->first();

        if($response->detailOutput->responseCode == 0){
            $venta->estado = 1;
            $venta->save();
        }
        $plus->acknowledgeTransaction();
        return RedirectorHelper::redirectBackNormal($response->urlRedirection);
    }

    public function finalizar(Request $request){
        $venta = PlanPublicacion::where('token', $request->token_ws)->where('estado', 1)->first();

        $titulo = "HEMOS TENIDO PROBLEMAS AL AGREGAR EL PLAN A TU PUBLICACIÓN";
        $texto = "!! LO SENTIMOS ¡¡ <br> HEMOS TENIDO ALGUNOS <br> INCONVENIENTES PARA RECIBIR <br> TU PAGO. INTÉNTELO NUEVAMENTE.";

        if($venta){
            $titulo = "!! MUCHAS GRACIAS ¡¡";
            $texto = "YA HEMOS AGREGADO EL PLAN CONTRATADO A TU PUBLICACIÓN, RECUERDA QUE PUEDES SEGUIR AGREGANDO MÁS PLANES A TU PUBLICACIÓN. <br> MUCHAS GRACIAS POR CONFIAR EN NOSOTROS.";
        }

        return view('resultado')->with(compact('titulo', 'texto'));
    }
}
