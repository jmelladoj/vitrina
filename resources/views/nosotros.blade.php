@extends('layouts.app')

@section('content')

    <div class="video-block section-padding">
        <div class="main-items">
            <div class="row justify-content-md-center">
                <div class="messages text-center col-md-12">
                    Sobre Vitrina Laboral
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <p class="text-justify">
                        Vitrina Laboral tiene por objetivo combatir el desempleo y ayudar a impulsar microempresas, ofreciendo difusión a través de su Portal web www.vitrinalaboral.cl y distintas redes sociales.
                    </p>
                    <p class="text-justify">Se registrarán personas generando una base de datos en la que se dividirán por categorías según el rubro que desarrollen proporcionando a empleadores y cualquier persona una forma rápida y fácil de encontrar un trabajador para un determinado puesto de trabajo como también cualquier tipo de servicio.</p>
                    <img src="{{ asset('pagina/images/header/logo.png') }}" class="img-fluid" alt="logo" >
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
                    <img src="https://cdn.pixabay.com/photo/2015/01/09/11/08/startup-594090_960_720.jpg" alt="logo" class="img-fluid" width="500" >
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-5">
                    <div class="prcy-btn text-center">
                        <a class="btn save-btn1" href="{{ url('/login') }} ">! Súmate ¡</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
