@if( $url != "" )
    <iframe name="iframeContent" id="iframeContent" src="{{ $url }}" frameborder="0" width="100%" height="100%" align="left" allowfullscreen="true"><FONT FACE=ARIAL SIZE=3 COLOR="RED">Your Browser doesn't Support Required Component.</FONT></iframe>
@else
    <div class="row d-flex align-items-center justify-content-center mt-4">
        <div class="col-md-6 alert alert-success" role="alert">
            <div class="row">
                <div class="col-4">
                    <img width="200px;" src="{{ asset('img/M-Face-8.png') }}" alt="">
                </div>
                <div class="col-8">
                    <h4 class="alert-heading">Oops!!! Lo sentimos!</h4>
                    <p>Aun no se encuentra definido un informe en esta opción de menú.</p>
                    <hr>
                    <p class="mb-0">Consulte al Administrador de Atenas para más información.</p>
                </div>
            </div>
        </div>
    </div>
@endif
