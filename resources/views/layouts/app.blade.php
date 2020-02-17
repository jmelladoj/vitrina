<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate(true) !!}

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/pagina.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pagina.css') }}" rel="stylesheet">
</head>
<body id="page-top">
    <div id="app">

        <nav class="navbar navbar-expand-md navbar-light sticky-top nav-menu">
            <div class="row full-width">
                <div class="col-md-2 col-xs-12 p-left p-right">
                    <div  class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle">
                        <div class="menu-bar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="18" height="14" class="header-icon" viewBox="0 0 18 14">
                            <path d="M17.000,-0.000 C17.552,-0.000 18.000,0.448 18.000,1.000 C18.000,1.552 17.552,2.000 17.000,2.000 L1.000,2.000 C0.448,2.000 -0.000,1.552 -0.000,1.000 C-0.000,0.448 0.448,-0.000 1.000,-0.000 L17.000,-0.000 ZM17.000,6.000 C17.552,6.000 18.000,6.447 18.000,7.000 C18.000,7.552 17.552,8.000 17.000,8.000 L1.000,8.000 C0.448,8.000 -0.000,7.552 -0.000,7.000 C-0.000,6.447 0.448,6.000 1.000,6.000 L17.000,6.000 ZM17.000,12.000 C17.552,12.000 18.000,12.448 18.000,13.000 C18.000,13.552 17.552,14.000 17.000,14.000 L1.000,14.000 C0.448,14.000 -0.000,13.552 -0.000,13.000 C-0.000,12.448 0.448,12.000 1.000,12.000 L17.000,12.000 Z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="logo">
                        <a href="{{ url('/') }}">
                        <img src="{{ asset('pagina/images/header/logo.png') }}" alt="logo" >
                        </a>
                    </div>
                </div>
              <!-- Navbar -->
                <busqueda></busqueda>
                <div class="col-md-4 col-xs-12 p-left p-right">
                    <div class="home">
                        <ul>
                            <li class="active">
                                <a  href="{{ url('/') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="17" height="18" class="header-icon" viewBox="0 0 17 18">
                                      <path d="M11.895,16.310 L13.595,16.310 C14.534,16.310 15.296,15.551 15.296,14.615 L15.296,7.330 C15.296,6.790 15.037,6.282 14.600,5.963 L9.498,2.237 C8.900,1.800 8.087,1.800 7.489,2.237 L2.387,5.963 C1.950,6.282 1.692,6.790 1.692,7.330 L1.692,14.615 C1.692,15.551 2.453,16.310 3.392,16.310 L5.093,16.310 L5.093,9.528 C5.093,9.060 5.473,8.680 5.943,8.680 L11.044,8.680 C11.514,8.680 11.895,9.060 11.895,9.528 L11.895,16.310 ZM10.194,16.310 L10.194,10.376 L6.793,10.376 L6.793,16.310 L10.194,16.310 ZM1.383,4.595 L6.484,0.869 C7.680,-0.005 9.307,-0.005 10.503,0.869 L15.605,4.595 C16.479,5.233 16.996,6.250 16.996,7.330 L16.996,14.615 C16.996,16.487 15.473,18.006 13.595,18.006 L3.392,18.006 C1.514,18.006 -0.009,16.487 -0.009,14.615 L-0.009,7.330 C-0.009,6.250 0.508,5.233 1.383,4.595 Z"></path>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/vitrinalaboral/" target="_blank"><img src="https://image.flaticon.com/icons/svg/145/145802.svg" alt="" height="20"></a>
                            </li>
                            <li>
                                <a v-bind:href="'https://api.whatsapp.com/send?phone=56949763141&text=Cont%C3%A1cto%20desde%20la%20p%C3%A1gina%20de%20Vitrina%20Laboral'"><img src="https://image.flaticon.com/icons/svg/134/134937.svg" alt="" height="20"></a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/vitrina.laboral" target="_blank"><img src="https://image.flaticon.com/icons/svg/355/355975.svg" alt="" height="20"></a>
                            </li>
                        </ul>
                    </div>
                    <!--#Home-->
                    <div class="dropdown login">

                        <div class="account-dt dropdown-toggle-no-caret" aria-haspopup="true" aria-expanded="false" role="main">
                            <a href="{{ url('/login') }} "><i class="fas fa-user-circle"></i><span>Ingresar</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>



        <div class="full-width mb-5">
            <div id="wrapper">
                <ul class="sidebar navbar-nav">
                    <li class="nav-item active">
                        <a href="{{ url('/') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="16" height="16" class="left-icons" viewBox="0 0 16 16">
                              <path d="M11.450,14.478 L12.953,14.478 C13.783,14.478 14.456,13.803 14.456,12.970 L14.456,6.490 C14.456,6.009 14.227,5.557 13.841,5.273 L9.332,1.959 C8.804,1.570 8.085,1.570 7.556,1.959 L3.048,5.273 C2.661,5.557 2.433,6.009 2.433,6.490 L2.433,12.970 C2.433,13.803 3.106,14.478 3.936,14.478 L5.439,14.478 L5.439,8.445 C5.439,8.028 5.775,7.691 6.190,7.691 L10.699,7.691 C11.114,7.691 11.450,8.028 11.450,8.445 L11.450,14.478 ZM9.947,14.478 L9.947,9.199 L6.941,9.199 L6.941,14.478 L9.947,14.478 ZM2.160,4.056 L6.668,0.742 C7.726,-0.035 9.163,-0.035 10.220,0.742 L14.729,4.056 C15.502,4.625 15.959,5.528 15.959,6.490 L15.959,12.970 C15.959,14.636 14.613,15.986 12.953,15.986 L3.936,15.986 C2.276,15.986 0.930,14.636 0.930,12.970 L0.930,6.490 C0.930,5.528 1.387,4.625 2.160,4.056 Z"></path>
                            </svg>
                            <div class="fos" id="foo"> Home </div>
                        </a>
                    </li>

                    <!--<li class="nav-item">
                        <a href="find_profiles.html">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="15" height="17" class="left-icons" viewBox="0 0 15 17">
                              <path d="M1.422,1.195 C1.563,1.054 1.757,0.969 1.968,0.974 L5.796,1.061 C6.458,1.076 7.098,1.315 7.620,1.741 L9.427,3.218 C9.688,3.431 10.008,3.551 10.339,3.558 L13.401,3.628 C14.247,3.647 14.917,4.377 14.899,5.258 L14.731,13.231 C14.712,14.112 14.012,14.810 13.166,14.791 L10.104,14.721 C9.442,14.706 8.802,14.467 8.280,14.041 L6.473,12.564 C6.212,12.351 5.892,12.231 5.561,12.224 L2.499,12.154 L2.415,16.141 C2.406,16.581 2.056,16.930 1.633,16.921 C1.210,16.911 0.875,16.546 0.884,16.106 L1.186,1.754 C1.190,1.534 1.280,1.336 1.422,1.195 ZM2.700,2.586 L2.532,10.560 L5.595,10.629 C6.257,10.645 6.897,10.883 7.419,11.309 L9.226,12.786 C9.486,12.999 9.806,13.119 10.138,13.126 L13.200,13.196 L13.368,5.223 L10.305,5.153 C9.643,5.138 9.003,4.899 8.481,4.473 L6.674,2.996 C6.414,2.783 6.094,2.664 5.762,2.656 L2.700,2.586 Z"></path>
                            </svg>
                            <div class="fos" id="foo2"> Encontrar perfil </div>
                        </a>
                    </li>-->
                    <li class="nav-item">
                        <a href="{{ url('/nosotros') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="16" height="16" class="left-icons" viewBox="0 0 16 16">
                              <path d="M8.000,16.000 C3.582,16.000 -0.000,12.418 -0.000,8.000 C-0.000,3.582 3.582,-0.000 8.000,-0.000 C12.418,-0.000 16.000,3.582 16.000,8.000 C16.000,12.418 12.418,16.000 8.000,16.000 ZM8.000,14.545 C11.615,14.545 14.545,11.615 14.545,8.000 C14.545,4.385 11.615,1.454 8.000,1.454 C4.385,1.454 1.454,4.385 1.454,8.000 C1.454,11.615 4.385,14.545 8.000,14.545 ZM7.636,12.000 L7.636,8.000 L6.909,8.000 C6.507,8.000 6.182,7.674 6.182,7.273 C6.182,6.871 6.507,6.545 6.909,6.545 L8.364,6.545 C8.765,6.545 9.091,6.871 9.091,7.273 L9.091,12.000 C9.091,12.401 8.765,12.727 8.364,12.727 C7.962,12.727 7.636,12.401 7.636,12.000 ZM7.273,4.364 C7.273,3.962 7.598,3.636 8.000,3.636 C8.402,3.636 8.727,3.962 8.727,4.364 C8.727,4.765 8.402,5.091 8.000,5.091 C7.598,5.091 7.273,4.765 7.273,4.364 Z"></path>
                            </svg>
                            <div class="fos" id="foo8"> Nosotros</div>
                        </a>
                    </li>
                </ul>

                <div id="content-wrapper">
                    <div class="container-fluid">
                        @if(request()->is('/'))
                            @isset($rubros)
                                <rubros-home :rubros="{{ $rubros }}"></rubros-home>
                            @endisset
                        @endif

                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <div class="copy-right">
                        © Copyright 2019 Vitrina Laboral. Todos los derechos reservados. Desarrolldado por <a href="www.atupy.cl" target="_blank"> Atupy</a>
                    </div>
                </div>
            </div>
        </footer>

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="ti-arrow-up"></i>
        </a>
    </div>
</body>
</html>
