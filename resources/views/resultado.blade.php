@extends('layouts.app')

@section('content')
    <div class="video-block section-padding">
        <div class="main-items">
            <div class="row justify-content-md-center">
                <div class="messages text-center col-md-12">
                    {{ $titulo }}
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h4 class="text-center">
                        {!! $texto !!}
                    </h4>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center mt-5">
                    <img src="{{ asset('pagina/images/header/logo.png') }}" class="img-fluid" alt="logo" width="500">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-5">
                    <div class="prcy-btn text-center">
                        <a class="btn save-btn1" href="{{ url('/perfil') }} ">! Volver a mi perfil ¡</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
