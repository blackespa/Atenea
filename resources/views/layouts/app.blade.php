<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title-section')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/atenea.css') }}" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">

    @yield('css-section')

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-light shadow">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Atenea') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <ul class="navbar-nav mr-auto">

                        @foreach ( $menus as $key => $item )
                            @if ( $item['parent_id'] != 0 )
                                @break
                            @endif
                            @include('menus.menu-item', ['item' => $item, 'level' => 0] )
                        @endforeach
                    </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else

                            @hasrole('Admin')
                            <li class="nav-item dropdown">
                                <a id="navbarAdmin" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  data-type="admin" v-pre>
                                    Administración
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarAdmin">
                                    <a class="dropdown-item" href="#" data-id="1" data-type="admin"><i class="fas fa-file-signature"></i> &nbsp;Menus & Reportes</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-id="2" data-type="admin"><i class="fas fa-users"></i> &nbsp;Usuarios de Atenas</a>

                                </div>
                            </li>
                            @endhasrole

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img id="AuthUserImage" src="{{ asset('storage')."/profiles/".Auth::user()->image }}" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 25px;">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#" data-id="10" data-type="admin"><i class="far fa-id-card"></i> &nbsp;Perfil Usuario</a>
                                    <a class="dropdown-item" href="#" data-id="11" data-type="admin"><i class="fas fa-key"></i> &nbsp;Cambiar contraseña</a>
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> &nbsp;{{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-1">
            <div class="container-fluid" id="content"></div>
        </main>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>


    @include('users.changePassword')



    <script type="text/javascript">

        var toastr;

        document.addEventListener('DOMContentLoaded', function () {

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            $( '.dropdown-menu a.dropdown-toggle' ).on( 'click', function ( e ) {
                var $el = $( this );
                $el.toggleClass('active-dropdown');
                var $parent = $( this ).offsetParent( ".dropdown-menu" );
                if ( !$( this ).next().hasClass( 'show' ) ) {
                    $( this ).parents( '.dropdown-menu' ).first().find( '.show' ).removeClass( "show" );
                }
                var $subMenu = $( this ).next( ".dropdown-menu" );
                $subMenu.toggleClass( 'show' );

                $( this ).parent( "li" ).toggleClass( 'show' );

                $( this ).parents( 'li.nav-item.dropdown.show' ).on( 'hidden.bs.dropdown', function ( e ) {
                    $( '.dropdown-menu .show' ).removeClass( "show" );
                    $el.removeClass('active-dropdown');
                } );

                if ( !$parent.parent().hasClass( 'navbar-nav' ) ) {
                    $el.next().css( { "top": $el[0].offsetTop, "left": $parent.outerWidth() - 4 } );
                }

                return false;
            } );


            $('body').on('click', '.nav-link', function (e) {
                //console.log('.nav-link');
                //return false;
            });


            $('body').on('click', '.navbar .dropdown-menu .dropdown-item', function (e) {
                e.preventDefault();
                e.stopPropagation();

                var menu_id = $(this).data('id');
                var type = $(this).data('type');

                //console.log('.navbar .dropdown-menu .dropdown-item',menu_id,type);

                if (type === "user") {
                    toastr.success('Obteniendo el informe...');

                    axios.post('/menus/displayReport' ,{
                        params: {
                            menu_id: menu_id
                        }
                    })
                    .then((response) => {
                        //console.log(response);
                        var iframeReport = response.data;
                        $('#content').html(iframeReport);

                    }).catch((error)=>{
                        console.log('error:',error);
                        toastr.error('ERROR: Aun no se ha especificado un reporte para esta opción de menú');
                    });

                } else if(type === 'admin') {
                    switch (menu_id) {
                        case 1:
                            axios.post('/menus/configuration')
                            .then((response) => {
                                //console.log(response);
                                $('#content').html(response.data);

                            }).catch((error)=>{
                                console.log('error:',error);
                                toastr.error('ERROR: Ocurrió un error al intentar obtener la vista de configuración.');
                            });
                            break;

                        case 2:
                            axios.post('/users')
                            .then((response) => {
                                //console.log(response);
                                $('#content').html(response.data);

                            }).catch((error)=>{
                                console.log('error:',error);
                                toastr.error('ERROR: Ocurrió un error al intentar obtener la vista de usuarios.');
                            });
                            break;

                        case 10:
                            axios.post('/users/profile')
                            .then((response) => {
                                //sconsole.log(response);
                                $('#content').html(response.data);

                            }).catch((error)=>{
                                console.log('error:',error);
                                toastr.error('ERROR: Ocurrió un error al intentar obtener la vista de perfil de usuario.');
                            });
                            break;


                        case 11:
                            $('#changePasswordModal').modal('show');
                            break;

                        default:
                            break;
                    }
                }

            });


            $('.pass_show').append('<span class="ptxt">Mostrar</span>');

            $(document).on('click','.pass_show .ptxt', function(){
                $(this).text($(this).text() == "Mostrar" ? "Ocultar" : "Mostrar");
                $(this).prev().attr('type', function(index, attr) { return attr == 'password' ? 'text' : 'password'; } );
            });


        });

    </script>

    @yield('js-section')




</body>
</html>
