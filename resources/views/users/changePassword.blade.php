<!-- Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" id="passwordForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong><i class="fas fa-key"></i> &nbsp;Cambio de Contraseña</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="form-group pass_show mb-0">
                        <input type="password" class="form-control font-weight-bold" name="password1" id="password1" placeholder="Nueva Contraseña" autocomplete="off">
                    </div>
                    <div class="row mt-0 mb-4 ml-1">
                        <div class="col-6 text-muted" style="font-size: 8pt;">
                            <i id="8char" class="fas fa-times" style="color:#FF0004;"></i> 8 caracteres de largo<br>
                            <i id="ucase" class="fas fa-times" style="color:#FF0004;"></i> 1 letra mayúscula
                        </div>
                        <div class="col-6 text-muted" style="font-size: 8pt;">
                            <span id="lcase" class="fas fa-times" style="color:#FF0004;"></span> 1 letra minúscula<br>
                            <span id="num" class="fas fa-times" style="color:#FF0004;"></span> 1 número
                        </div>
                    </div>

                    <div class="form-group pass_show mb-0">
                        <input type="password" class="form-control font-weight-bold" name="password2" id="password2" placeholder="Repita Contraseña" autocomplete="off">
                    </div>
                    <div class="row mt-0 ml-1">
                        <div class="col-12 text-muted" style="font-size: 8pt;">
                            <span id="pwmatch" class="fas fa-times" style="color:#FF0004;"></span> Contraseñas coinciden
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="float-left">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-sm btn-primary" id="btnChangePassword">Cambiar Contraseña</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">


    $("input[type=password]").keyup(function() {
        console.log('input[type=password]).keyup');

        var ucase = new RegExp("[A-Z]+");
        var lcase = new RegExp("[a-z]+");
        var num = new RegExp("[0-9]+");

        if ( $("#password1").val().length >= 8 ) {
            $("#8char").removeClass("fas fa-times");
            $("#8char").addClass("fas fa-check");
            $("#8char").css("color","#00A41E");
        } else {
            $("#8char").removeClass("fas fa-check");
            $("#8char").addClass("fas fa-times");
            $("#8char").css("color","#FF0004");
        }

        if( ucase.test( $("#password1").val() ) ) {
            $("#ucase").removeClass("fas fa-times");
            $("#ucase").addClass("fas fa-check");
            $("#ucase").css("color","#00A41E");
        } else {
            $("#ucase").removeClass("fas fa-check");
            $("#ucase").addClass("fas fa-times");
            $("#ucase").css("color","#FF0004");
        }

        if( lcase.test( $("#password1").val() ) ) {
            $("#lcase").removeClass("fas fa-times");
            $("#lcase").addClass("fas fa-check");
            $("#lcase").css("color","#00A41E");
        } else {
            $("#lcase").removeClass("fas fa-check");
            $("#lcase").addClass("fas fa-times");
            $("#lcase").css("color","#FF0004");
        }

        if( num.test( $("#password1").val() ) ) {
            $("#num").removeClass("fas fa-times");
            $("#num").addClass("fas fa-check");
            $("#num").css("color","#00A41E");
        } else {
            $("#num").removeClass("fas fa-check");
            $("#num").addClass("fas fa-times");
            $("#num").css("color","#FF0004");
        }

        if( $("#password1").val() == $("#password2").val() ) {
            $("#pwmatch").removeClass("fas fa-times");
            $("#pwmatch").addClass("fas fa-check");
            $("#pwmatch").css("color","#00A41E");
        } else {
            $("#pwmatch").removeClass("fas fa-check");
            $("#pwmatch").addClass("fas fa-times");
            $("#pwmatch").css("color","#FF0004");
        }

    });


    $('#btnChangePassword').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();

        var password = $('#password1').val();
        axios.post('/users/changePassword',{
            params: {
                password: password,
            }
        })
        .then( response => {
            //console.log(response);
            $("#changePasswordModal").modal('hide');
            toastr.success('Se ha actualizado la contraseña del usuario actual.');

        }).catch( error => {
            console.log(error);
            toastr.error('Ha ocurrido un error cuando se intentaba cambiar la contraseña del usuario actual.' + error);
        });
    });

</script>
