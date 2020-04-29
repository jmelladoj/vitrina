@extends('layouts.app')

@section('content')

    <div class="video-block section-padding">
        <div class="main-items">
            <div class="row justify-content-md-center">
                <div class="messages text-center col-md-12">
                    Nuestras políticas de privacidad y seguridad
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <p class="text-justify">
                        @isset($politicas)
                            {!! $politicas->politicas !!}
                        @endisset
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mt-5">
                    <center>
                        <img src="{{ asset('pagina/images/header/logo.png') }}" class="img-fluid" alt="logo" height="400px" >
                    </center>
                </div>
                
            </div>
        </div>
    </div>


@endsection
