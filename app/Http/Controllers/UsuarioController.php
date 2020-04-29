<?php

namespace App\Http\Controllers;

use App\RubroUsuario;
use App\ComunaUsuario;
use App\ImagenPublicacion;
use App\Mail\RecuperarClave;
use App\Mail\UsuarioNuevo;
use App\Plan;
use App\PlanPublicacion;
use App\Publicacion;
use App\Rubro;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Freshwork\Transbank\CertificationBagFactory;
use Freshwork\Transbank\TransbankServiceFactory;
use Freshwork\Transbank\RedirectorHelper;
use Exception;

class UsuarioController extends Controller
{
    //
    public function index($tipo){
        switch ($tipo) {
            case 1:
                return ['usuarios' => User::withTrashed()->orderBy('nombre', 'asc')->get()];
                break;
            case 2:
                return ['usuarios' => User::orderBy('nombre', 'asc')->get()];
                break;
        }
    }


    public function index_comunas_usuario($id){
        return ['comunas' => ComunaUsuario::where('user_id', $id)->orderBy('nombre', 'asc')->get()];
    }

    public function index_rubros_usuario($id){
        return ['rubros' => RubroUsuario::where('user_id', $id)->orderBy('nombre', 'asc')->get()];
    }

    public function index_publicaciones_usuario($id){
        return ['publicaciones' => Publicacion::where('user_id', $id)->orderBy('titulo', 'asc')->with('imagenes_publicacion')->get()];
    }

    public function index_plan_publicaciones_usuario($id){
        return ['plan_publicaciones' => PlanPublicacion::where('publicacion_id', $id)->orderBy('created_at', 'desc')->get()];
    }

    public function crear_actualizar(Request $request){

        $usuario = User::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'nombre' => $request->nombre,
                'email' => $request->email,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'telefono' => $request->telefono
            ]
        );

        if($request->id == 0){
            Mail::to($request->email)->send(new UsuarioNuevo($usuario));
        }
    }

    public function cambiar_clave(Request $request){
        User::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'password' => bcrypt($request->clave)
            ]
        );
    }

    public function cambiar_sociales(Request $request){
        User::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'linkedin' => $request->link_linkedin,
                'facebook' => $request->link_facebook,
                'instagram' => $request->link_instagram,
                'telefono' => $request->telefono
            ]
        );
    }

    public function cambiar_foto(Request $request){
        if ($request->hasFile('imagen_perfil')) {
            $usuario = User::find($request->id);

            if($usuario->perfil_url != null) { Storage::disk('public')->delete($usuario->perfil_url); }

            $usuario->perfil_url = Storage::disk('public')->putFile('fotos_perfil', $request->file('imagen_perfil'));
            $usuario->save();
        }
    }

    public function agregar_comunas(Request $request){
        ComunaUsuario::create(
            [
                'nombre' => $request->nombre_comuna,
                'user_id' => $request->usuario_id,
                'comuna_id' => $request->comuna_id
            ]
        );
    }

    public function agregar_rubros(Request $request){

        $rubro = Rubro::updateOrCreate(
            [
                'id' => $request->rubro_id
            ],
            [
                'nombre' => $request->nombre_rubro
            ]
        );


        RubroUsuario::create(
            [
                'nombre' => $request->nombre_rubro,
                'user_id' => $request->usuario_id,
                'rubro_id' => $rubro->id
            ]
        );
    }

    public function agregar_publicaciones(Request $request){
        $ventas = PlanPublicacion::where('user_id', $request->user_id)->get()->count();
        $plan = Plan::find($request->plan_id);

        $publicacion = Publicacion::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'user_id' => $request->user_id
            ]
        );

        if($request->cantidad_imagenes > 0){
            for($i = 0; $i < $request->cantidad_imagenes; $i++){
                if ($request->hasFile('imagen_' . $i)) {
                    ImagenPublicacion::create([
                        'url' => 'storage/' . Storage::disk('public')->putFile('publicaciones', $request->file('imagen_' . $i)),
                        'perfil' => $i == $request->indice_perfil ? 1 : 0,
                        'publicacion_id' => $publicacion->id
                    ]);
                }

            }
        }

        if($plan){
            $bag = CertificationBagFactory::integrationWebpayNormal();
            $plus = TransbankServiceFactory::normal($bag);
            $plus->addTransactionDetail($plan->valor, ($ventas + 1));
    
            $response = $plus->initTransaction(url('/publicacion/procesar'), url('/publicacion/finalizar'));
    
            if($plan){
                PlanPublicacion::create([
                    'nombre_plan' => $plan->nombre,
                    'duracion' => $plan->duracion,
                    'valor' => $plan->valor,
                    'plan_id' => $plan->id,
                    'publicacion_id' => $publicacion->id,
                    'user_id' => $request->user_id,
                    'token' => $response->token
                ]);
        
            }
    
    
            return [
                'url' => $response->url,
                'token' => $response->token
            ];
        }

    }

    public function agregar_plan_publicacion(Request $request){
        $plan = Plan::find($request->plan_id);

        PlanPublicacion::create([
            'nombre_plan' => $plan->nombre,
            'duracion' => $plan->duracion,
            'valor' => $plan->valor,
            'plan_id' => $plan->id,
            'publicacion_id' => $request->publicacion_id,
            'user_id' => $request->user_id
        ]);
    }

    public function pagar_plan_publicacion(Request $request){
        $plan = Plan::find($request->plan_id);
        $ventas = PlanPublicacion::get()->count();

        $bag = CertificationBagFactory::integrationWebpayNormal();
        $plus = TransbankServiceFactory::normal($bag);
        $plus->addTransactionDetail($plan->valor, ($ventas + 1));

        $response = $plus->initTransaction(url('/publicacion/procesar'), url('/publicacion/finalizar'));

        PlanPublicacion::create([
            'nombre_plan' => $plan->nombre,
            'duracion' => $plan->duracion,
            'valor' => $plan->valor,
            'plan_id' => $plan->id,
            'publicacion_id' => $request->publicacion_id,
            'user_id' => $request->user_id,
            'token' => $response->token
        ]);

        return [
            'url' => $response->url,
            'token' => $response->token
        ];
    }




    public function borrar(Request $request){
        User::find($request->id)->delete();
    }

    public function eliminar_foto(Request $request){
        $usuario = User::find($request->id);
        Storage::disk('public')->delete($usuario->perfil_url);
        $usuario->perfil_url = 'https://image.flaticon.com/icons/svg/149/149076.svg';
        $usuario->save();
    }

    public function borrar_comuna_usuario(Request $request){
        ComunaUsuario::find($request->id)->delete();
    }

    public function borrar_rubro_usuario(Request $request){
        RubroUsuario::find($request->id)->delete();
    }

    public function borrar_publicaciones(Request $request){
        Publicacion::find($request->id)->delete();
    }

    public function borrar_plan_publicaciones(Request $request){
        PlanPublicacion::find($request->id)->delete();
    }

    public function logeado(){
        return ['usuario' => User::where('id', Auth::id())->first()];
    }

    public function validar_unico($texto){
        return json_encode(User::where('email', $texto)->get()->count() > 0 ? false : true);
    }

    public function recuperar_clave(Request $request){
        $usuario = User::where('email', $request->email)->first();
        $clave_nueva = Str::random(40);

        $usuario->password = bcrypt($clave_nueva);
        $usuario->save();

        Mail::to($request->email)->send(new RecuperarClave($usuario->nombre, $clave_nueva));
    }
}
