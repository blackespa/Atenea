<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Atenea ::: Login</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

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

            .title-login {
                display: flex;
                justify-content: center;
                font-family: 'Nunito', sans-serif;
                font-size: 30px;
                font-weight: 600;
            }

            .image-container {
                display: flex;
                justify-content: center;
            }

            .btn-primary {
                background-color: #41285C;
                border-color: #41285C;
                color: #FFFFFF;
            }

            .card {
                padding: 0;
            }

            .card-header {
                font-family: 'Nunito', sans-serif;
                font-size: 30px;
                font-weight: 600;
                text-align: center;
                background-color: #BEA6D8;
                color: #41285C;
            }

            .card-body {
                background-color: #BEA6D8;
                color: #41285C;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="image-container">
                        <img src="{{ asset('img/logo-crescer-sin-fondo.png') }}" alt="Atenea">
                    </div>
                </div>

                <div class="col-6" style="display: flex; justify-content: center; align-items: center;">
                    <div class="container-fluid row">
                        <div class="card col-12">
                            <div class="card-header">Control de Acceso Atenea</div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right font-weight-bold">Correo Electrónico</label>
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right font-weight-bold">Contraseña</label>
                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label font-weight-bold" for="remember">
                                                    {{ __('Recuérdame') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>
