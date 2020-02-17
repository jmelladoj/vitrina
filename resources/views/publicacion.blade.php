@extends('layouts.app')

@section('content')

    @isset($publicacion)
        <div class="video-block section-padding">
            <div class="main-item">
                <div class="row">
                    <div class="col-md-12 px-0">
                        <div class="profile-area mt-3">
                            <div class="bnnr-img-dpt">
                                <!--<div class="featured-section profile-cover profile-cover-image"  style="background-image: url(images/restaurant/event-bg.jpg)"></div>-->
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
                                        <img src="{{ asset($publicacion->foto_perfil) }}" alt="">
                                        <div class="box-heading4">
                                            <a href="javascript:void(0)"> Publicado por : <b>{{ $publicacion->usuario->nombre}}</b> | {{ $publicacion->usuario->telefono }}</a>
                                        </div>
                                    </div>
                                    <!--<button class="message-btn" type="button" data-toggle="modal" data-target="#message">Direct Message</button>-->
                                </div>
                            </div>
                            <!--<div class="col-xl-6 col-sm-12">
                                <div class="author-dt">
                                    <ul>
                                        <li>
                                            <div class="more-options">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="18" height="17" class="option-links" viewBox="0 0 18 17">
                                                    <path d="M8.992,2.914 C10.202,1.614 11.406,0.936 13.081,0.936 C15.973,0.936 17.989,3.105 17.989,5.956 C17.989,9.428 15.263,12.948 9.922,16.580 C9.362,16.961 8.622,16.961 8.062,16.580 C2.721,12.948 -0.005,9.428 -0.005,5.956 C-0.005,3.105 2.011,0.936 4.903,0.936 C6.578,0.936 7.782,1.614 8.992,2.914 ZM8.352,4.657 C7.193,3.225 6.237,2.546 4.903,2.546 C2.949,2.546 1.631,3.964 1.631,5.956 C1.631,8.772 4.048,11.894 8.992,15.256 C13.936,11.894 16.353,8.772 16.353,5.956 C16.353,3.964 15.035,2.546 13.081,2.546 C11.747,2.546 10.791,3.225 9.632,4.657 C9.304,5.062 8.680,5.062 8.352,4.657 Z"></path>
                                                </svg>
                                                <span>Bookmark</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="more-options">
                                                <a href="#">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="16" height="18" class="option-links" viewBox="0 0 16 18">
                                                        <path d="M8.871,8.101 C8.546,7.776 8.546,7.247 8.871,6.922 C9.197,6.596 9.725,6.596 10.051,6.922 C11.680,8.551 11.680,11.192 10.051,12.821 L7.102,15.771 C5.472,17.400 2.831,17.400 1.202,15.771 C-0.427,14.142 -0.427,11.500 1.202,9.871 L1.792,9.281 C2.118,8.956 2.646,8.956 2.972,9.281 C3.298,9.607 3.298,10.135 2.972,10.461 L2.382,11.051 C1.404,12.029 1.404,13.614 2.382,14.591 C3.359,15.568 4.944,15.568 5.922,14.591 L8.871,11.641 C9.849,10.664 9.849,9.079 8.871,8.101 ZM7.102,9.871 C7.427,10.197 7.427,10.725 7.102,11.051 C6.776,11.377 6.247,11.377 5.922,11.051 C4.293,9.422 4.293,6.781 5.922,5.152 L8.871,2.202 C10.501,0.573 13.142,0.573 14.771,2.202 C16.400,3.831 16.400,6.472 14.771,8.101 L14.181,8.691 C13.855,9.017 13.327,9.017 13.001,8.691 C12.675,8.366 12.675,7.837 13.001,7.511 L13.591,6.922 C14.569,5.944 14.569,4.359 13.591,3.382 C12.614,2.404 11.029,2.404 10.051,3.382 L7.102,6.332 C6.124,7.309 6.124,8.894 7.102,9.871 Z"></path>
                                                    </svg>
                                                    <span>Website</span>
                                                </a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="more-options">
                                            <a href="#add-review">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="16" height="18" class="option-links" viewBox="0 0 16 18">
                                                    <path d="M11.059,16.367 C10.097,16.765 9.061,16.973 7.997,16.973 C3.578,16.973 -0.004,13.397 -0.004,8.985 C-0.004,4.573 3.578,0.996 7.997,0.996 C12.415,0.996 15.997,4.573 15.997,8.985 C15.997,10.047 15.789,11.081 15.390,12.043 C15.240,12.403 15.064,12.752 14.864,13.086 L15.948,15.943 C16.181,16.556 15.579,17.156 14.965,16.924 L12.104,15.841 C11.770,16.042 11.421,16.217 11.059,16.367 ZM13.304,13.270 C13.216,13.040 13.246,12.782 13.383,12.577 C13.619,12.225 13.820,11.851 13.982,11.460 C14.305,10.683 14.473,9.846 14.473,8.985 C14.473,5.413 11.574,2.518 7.997,2.518 C4.420,2.518 1.520,5.413 1.520,8.985 C1.520,12.556 4.420,15.452 7.997,15.452 C8.859,15.452 9.697,15.284 10.476,14.961 C10.868,14.799 11.242,14.599 11.595,14.363 C11.800,14.226 12.058,14.197 12.289,14.284 L13.923,14.902 L13.304,13.270 ZM4.187,8.985 C4.187,8.565 4.528,8.224 4.949,8.224 C5.370,8.224 5.711,8.565 5.711,8.985 C5.711,9.405 5.370,9.746 4.949,9.746 C4.528,9.746 4.187,9.405 4.187,8.985 ZM7.235,8.985 C7.235,8.565 7.576,8.224 7.997,8.224 C8.418,8.224 8.759,8.565 8.759,8.985 C8.759,9.405 8.418,9.746 7.997,9.746 C7.576,9.746 7.235,9.405 7.235,8.985 ZM10.283,8.985 C10.283,8.565 10.624,8.224 11.045,8.224 C11.466,8.224 11.807,8.565 11.807,8.985 C11.807,9.405 11.466,9.746 11.045,9.746 C10.624,9.746 10.283,9.405 10.283,8.985 Z"></path>
                                                </svg>
                                                <span>Add Review</span>
                                            </a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="more-options" data-toggle="modal" data-target="#sharelisitng">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="16" height="18" class="option-links" viewBox="0 0 16 18">
                                                    <path d="M6.512,10.160 C6.653,9.799 6.730,9.408 6.730,8.999 C6.730,8.680 6.683,8.371 6.595,8.079 L10.346,5.679 C10.947,6.216 11.749,6.544 12.630,6.544 C14.492,6.544 16.001,5.079 16.001,3.271 C16.001,1.463 14.492,-0.003 12.630,-0.003 C10.768,-0.003 9.258,1.463 9.258,3.271 C9.258,3.632 9.319,3.980 9.430,4.305 L5.730,6.673 C5.121,6.087 4.283,5.726 3.358,5.726 C1.496,5.726 -0.013,7.191 -0.013,8.999 C-0.013,10.807 1.496,12.273 3.358,12.273 C4.188,12.273 4.948,11.982 5.536,11.498 L9.394,13.805 C9.306,14.098 9.258,14.407 9.258,14.728 C9.258,16.536 10.768,18.001 12.630,18.001 C14.492,18.001 16.001,16.536 16.001,14.728 C16.001,12.920 14.492,11.454 12.630,11.454 C11.706,11.454 10.868,11.816 10.259,12.400 L6.512,10.160 ZM12.630,4.908 C11.699,4.908 10.944,4.175 10.944,3.271 C10.944,2.367 11.699,1.634 12.630,1.634 C13.561,1.634 14.316,2.367 14.316,3.271 C14.316,4.175 13.561,4.908 12.630,4.908 ZM3.358,10.636 C2.427,10.636 1.672,9.903 1.672,8.999 C1.672,8.095 2.427,7.363 3.358,7.363 C4.289,7.363 5.044,8.095 5.044,8.999 C5.044,9.903 4.289,10.636 3.358,10.636 ZM12.630,16.365 C11.699,16.365 10.944,15.632 10.944,14.728 C10.944,13.824 11.699,13.091 12.630,13.091 C13.561,13.091 14.316,13.824 14.316,14.728 C14.316,15.632 13.561,16.365 12.630,16.365 Z" class="cls-1"></path>
                                                </svg>
                                                <span>Share</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="more-options" data-toggle="modal" data-target="#report" data-whatever="@mdo">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="16" height="18" class="option-links" viewBox="0 0 16 18">
                                                    <path d="M8.000,17.000 C3.582,17.000 -0.000,13.418 -0.000,9.000 C-0.000,4.582 3.582,1.000 8.000,1.000 C12.418,1.000 16.000,4.582 16.000,9.000 C16.000,13.418 12.418,17.000 8.000,17.000 ZM8.000,15.545 C11.615,15.545 14.545,12.615 14.545,9.000 C14.545,5.385 11.615,2.455 8.000,2.455 C4.385,2.455 1.455,5.385 1.455,9.000 C1.455,12.615 4.385,15.545 8.000,15.545 ZM7.273,13.000 C7.273,12.598 7.598,12.273 8.000,12.273 C8.402,12.273 8.727,12.598 8.727,13.000 C8.727,13.402 8.402,13.727 8.000,13.727 C7.598,13.727 7.273,13.402 7.273,13.000 ZM7.273,5.182 C7.273,4.780 7.598,4.455 8.000,4.455 C8.402,4.455 8.727,4.780 8.727,5.182 L8.727,10.273 C8.727,10.674 8.402,11.000 8.000,11.000 C7.598,11.000 7.273,10.674 7.273,10.273 L7.273,5.182 Z"></path>
                                                </svg>
                                                <span>Report</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>-->
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
                                <li role="presentation">
                                    <a href="#gallery-1" aria-controls="gallery-1" role="tab" data-toggle="tab"> Galería </a>
                                </li>
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
                                                        @if($publicacion->usuario->linkedin)  <a href="{{ $publicacion->usuario->linkedin }}" target="_blank" class="ml-2 mr-2"><img src="https://image.flaticon.com/icons/svg/179/179330.svg" height="50" alt=""></a> @endif
                                                        @if($publicacion->usuario->facebook)  <a href="{{ $publicacion->usuario->facebook }}" target="_blank" class="ml-2 mr-2"><img src="https://image.flaticon.com/icons/svg/187/187189.svg" height="50" alt=""></a> @endif
                                                        @if($publicacion->usuario->telefono)  <a href="{{ url('https://api.whatsapp.com/send?phone=56' . $publicacion->usuario->telefono . '&text=Cont%C3%A1cto%20desde%20la%20p%C3%A1gina%20de%20Vitrina%20Laboral') }}" target="_blank"  class="ml-2 mr-2"><img src="https://image.flaticon.com/icons/svg/134/134937.svg" height="50" alt=""></a> @endif
                                                        @if($publicacion->usuario->instagram) <a href="{{ $publicacion->usuario->instagram }}" target="_blank"  class="ml-2 mr-2"><img src="https://image.flaticon.com/icons/svg/355/355975.svg" height="50" alt=""></a> @endif
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
                                                    <a class="col-lg-3 col-sm-6" href="javascript:void(0)" data-size="1600x1600" data-med="event-images/restaurant/eig-pop_1.jpg" data-med-size="1024x1024">
                                                        <img src="images/restaurant/eig-1.jpg" alt="">
                                                    </a>
                                                    <a class="col-lg-3 col-sm-6" href="javascript:void(0)" data-size="1600x1600" data-med="event-images/restaurant/eig-pop_2.jpg" data-med-size="1024x1024">
                                                        <img src="images/restaurant/eig-2.jpg" alt="">
                                                    </a>
                                                    <a class="col-lg-3 col-sm-6" href="javascript:void(0)" data-size="1600x1600" data-med="event-images/restaurant/eig-pop_3.jpg" data-med-size="1024x1024">
                                                        <img src="images/restaurant/eig-3.jpg" alt="">
                                                    </a>
                                                    <a class="col-lg-3 col-sm-6" href="javascript:void(0)" data-size="1600x1600" data-med="event-images/restaurant/eig-pop_4.jpg" data-med-size="1024x1024">
                                                        <img src="images/restaurant/eig-4.jpg" alt="">
                                                    </a>

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
