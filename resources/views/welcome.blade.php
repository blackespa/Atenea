<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Atenea ::: Bienvenida</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
                width: calc(100vw - 20px);
                height: calc(100vh - 40px);
                background-color: #41285c;
                color: #FFFFFF;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .title {
                display: flex;
                justify-content: center;
                font-family: 'Nunito', sans-serif;
                font-size: 50px;
                font-weight: 600;
            }
            .image-container {
                display: flex;
                justify-content: center;
            }
            /* The animation code */
            @keyframes logoAnimation {
                from {background-color: #41285c;}
                to {background-color: #7e4eb1;}
            }
            #logoDiv {
                animation-name: logoAnimation;
                animation-duration: 2s;
                animation-iteration-count: infinite;
                animation-direction: alternate;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="title">
                Bienvenido a Atenea
            </div>
            <hr>
            <div id="logoDiv" class="image-container">
                @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="">
                            <img src="{{ asset('img/logo-crescer-sin-fondo.png') }}" alt="Atenea">
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="">
                            <img src="{{ asset('img/logo-crescer-sin-fondo.png') }}" alt="Atenea">
                        </a>
                    @endauth
                </div>
                @endif
            </div>
        </div>
    </body>
</html>
