<?php

namespace App\Http\Controllers;

use App\General;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function index_politicas() {
        return ['politicas' => General::find(1)];
    }

    public function actualizar_politicas(Request $request) {
        $general = General::find(1);
        $general->politicas = $request->politicas;
        $general->save();
    }
    

}
