@extends('layouts.app')

@section('content')

    @isset($publicacion)
        <div class="video-block section-padding">
            <div class="main-item">
                <div class="row">
                    <div class="col-md-12 px-0">
                        <div class="profile-area mt-3">
                            <div class="bnnr-img-dpt">
                                <div class=" dash-profile">
                                    <img src="{{ asset($publicacion->foto_perfil) }}" alt="">
                                </div>
                            </div>
                            <div class="item-dt">
                                <div class="item-title">
                                    <h4> {{ $publicacion->titulo }}</h4>
                                    <!--<div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>-->
                                </div>
                                <div class="left-btns">
                                    <a href="{{ 'tel:+56' . $publicacion->usuario->telefono }}" class="btn call-btn">Llamar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="author-details">
                        <div class="row">
                            <div class="col-xl-12 col-sm-12">
                                <div class="author-dt">
                                    <div class="author-picy-dt">
                                        <img src="{{ asset($publicacion->usuario->foto_perfil) }}" alt="">
                                        <div class="box-heading4">
                                            <a href="javascript:void(0)"> Publicado por : <b>{{ $publicacion->usuario->nombre}}</b> | {{ $publicacion->usuario->telefono }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Profile Detail Area End-->
                    <!--Nav Tabs Start -->
                    <div class="row item-detail-tabs">
                        <div class="col-xl-12 com-md-12 col-sm-12 px-0">
                            <ul class="nav  nav-tabs" role="tablist" id="myTab">
                                <li role="presentation">
                                    <a class="active" href="#profile" aria-controls="profile" role="tab" data-toggle="tab"> Detalles </a>
                                </li>
                                @if($publicacion->usuario->usuario_pago == 1)
                                    <li role="presentation" >
                                        <a href="#gallery-1" aria-controls="gallery-1" role="tab" data-toggle="tab"> Galería </a>
                                    </li>
                                @endif
                            </ul><!--Nav Tabs End -->

                            <!--Tabs Panes Start -->
                            <div class="tab-content">
                                <div class="tab-pane active" role="tabpanel" id="profile">
                                    <div class="row lr-row">
                                        <div class="col-md-6">
                                            <div class=" locatins">
                                                <div class="heading">
                                                    <img src="{{ asset('/pagina/images/svg/menu1.svg')}}" alt=""><h3>Descripción</h3>
                                                </div>
                                                <div class="sub-heading">
                                                    {!! $publicacion->descripcion !!}
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="box-left">
                                                <div class="rightboxs">
                                                    <div class="heading">
                                                        <img src="{{ asset('/pagina/images/svg/follow.svg') }}" alt=""><h3> Contacto</h3>
                                                    </div>
                                                    <p class="text-center">
                                                        @if($publicacion->usuario->linkedin && $publicacion->usuario->usuario_pago == 1)  <a href="{{ $publicacion->usuario->linkedin }}" target="_blank" class="ml-2 mr-2"><img src="https://image.flaticon.com/icons/svg/179/179330.svg" height="50" alt=""></a> @endif
                                                        @if($publicacion->usuario->facebook && $publicacion->usuario->usuario_pago == 1)  <a href="{{ $publicacion->usuario->facebook }}" target="_blank" class="ml-2 mr-2"><img src="https://image.flaticon.com/icons/svg/187/187189.svg" height="50" alt=""></a> @endif
                                                        @if($publicacion->usuario->telefono)  <a href="{{ url('https://api.whatsapp.com/send?phone=56' . $publicacion->usuario->telefono . '&text=Cont%C3%A1cto%20desde%20la%20p%C3%A1gina%20de%20Vitrina%20Laboral') }}" target="_blank"  class="ml-2 mr-2"><img src="https://image.flaticon.com/icons/svg/134/134937.svg" height="50" alt=""></a> @endif
                                                        @if($publicacion->usuario->instagram && $publicacion->usuario->usuario_pago == 1) <a href="{{ $publicacion->usuario->instagram }}" target="_blank"  class="ml-2 mr-2"><img src="https://image.flaticon.com/icons/svg/355/355975.svg" height="50" alt=""></a> @endif
                                                        <a href="{{ 'tel:+56' . $publicacion->usuario->telefono }}"><img src="https://image.flaticon.com/icons/svg/126/126435.svg" height="50" alt="" class="ml-2 mr-2"></a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="box-left">
                                                <div class="rightboxs">
                                                    <div class="heading">
                                                        <img src="{{ asset('/pagina/images/svg/follow.svg') }}" alt=""><h3> Comunas</h3>
                                                    </div>
                                                    <p>{{ $publicacion->comunas}}</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="gallery-1">
                                    <div class="video-block section-padding">
                                        <div class="row lr-row mdb-lightbox">
                                            <div id="demo-test-gallery-1" class="demo-gallery" data-pswp-uid="1">
                                                <div class="gallery-sets">
                                                    @forelse  ($publicacion->imagenes_publicacion as $item)
                                                        <a class="col-lg-3 col-sm-6" href="javascript:void(0)" data-size="1600x1600" data-med="event-images/restaurant/eig-pop_1.jpg" data-med-size="1024x1024">
                                                            <img src="{{ asset($item->url) }}" alt="">
                                                        </a>
                                                    @empty
                                                        <h3 class="mt-5"><center>Sin imágenes en la publicación.</center></h3>
                                                    @endforelse 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Tabs Panes End -->
                        </div>
                    </div>
                    <!--Tab Links End-->
                </div>
            </div>
        </div>

    @endisset
@endsection
