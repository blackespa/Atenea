<div class="container pt-2">
    <div class="row d-flex justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header">
                    <div class="float-left">
                        <h5 class="card-title crescer-text"><strong><i class="fas fa-users"></i> Administración de Usuarios</strong></h5>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-sm btn-primary" id="btnNewUser"><i class="fas fa-user-plus"></i> Agregar</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-striped table-inverse">
                            <thead class="thead-inverse">
                                <tr>
                                    <th class="text-left">Nombre</th>
                                    <th class="text-left">Email</th>
                                    <th class="text-center">Activo</th>
                                    <th class="text-center">Rol</th>
                                    <th class="text-center">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td scope="row">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        @if($user->enabled == 1)
                                            <td class="text-center">Activo</td>
                                        @else
                                            <td class="text-center">Inactivo</td>
                                        @endif
                                        <td class="text-center">
                                            @if(!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $roleName)
                                                    <label class="badge badge-success">{{ $roleName }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-warning mr-2 resetPasswordClass" id="btnResetPassword" data-id="{{ $user->id }}" data-name="{{ $user->name }}"><i class="fas fa-key"></i> Reiniciar Clave</button>
                                            <button type="button" class="btn btn-sm btn-danger mr-2 deleteUserClass" id="btnDeleteUser" data-id="{{ $user->id }}" data-name="{{ $user->name }}"><i class="fas fa-user-minus"></i> Borrar</button>
                                            <button type="button" class="btn btn-sm btn-success editUserClass" id="btnEditUser" data-id="{{ $user->id }}"><i class="fas fa-user-edit"></i> Editar</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('users.form')


<script type="text/javascript">

    //console.log('instalando componentes del listado de usuarios');

    $( document ).ready(function() {

        $('body').on('click', '#btnNewUser', function (e) {
            e.preventDefault();
            e.stopPropagation();

            $("#titleUserModal").html('<strong><i class="fas fa-user-plus"></i> Nuevo Usuario</strong>');
            $('#userForm').trigger("reset");
            $('#userModal').modal('show');
        });

        var btnResetPassword = document.getElementsByClassName("resetPasswordClass");
        var i;
        for (i = 0; i < btnResetPassword.length; i++) {
            btnResetPassword[i].addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();

                var id = $(this).data('id');
                var name = $(this).data('name');

                swal({
                    title: "¿Seguro que desea reiniciar la contraseña del usuario '" + name + "'?",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Si, reiníciela!",
                    cancelButtonText: "No, cancele!",
                    reverseButtons: !0
                }).then(function (e) {
                    if (e.value === true) {
                        var token = document.head.querySelector('meta[name="csrf-token"]');
                        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                        axios.post('/users/changePassword',{
                            params: {
                                password: "",
                            }
                        })
                        .then( response => {
                            //console.log(response);
                            $("#changePasswordModal").modal('hide');
                            toastr.success('Se ha actualizado la contraseña del usuario actual.');

                        }).catch( error =>{
                            console.log(error);
                            toastr.error('Ha ocurrido un error cuando se intentaba cambiar la contraseña del usuario actual.' + error);
                        });

                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                });

            });
        }


        var btnEditUser = document.getElementsByClassName("editUserClass");
        var i;
        for (i = 0; i < btnEditUser.length; i++) {
            btnEditUser[i].addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();

                var id = $(this).data('id');
                var token = document.head.querySelector('meta[name="csrf-token"]');
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

                axios.post('/users/edit',{
                    params: {
                        id: id,
                    }
                })
                .then((response)=>{
                    //console.log(response);
                    $('#userForm').trigger("reset");

                    $('#userId').val(response.data.id);
                    $('#userName').val(response.data.name);
                    $('#userEmail').val(response.data.email);

                    if(response.data.roles.length != 0) {
                        //console.log('role',response.data.roles[0].name);
                        $('#role').val(response.data.roles[0].name);
                    }

                    if(response.data.enabled == 1){
                        $('#userEnabledLbl').text("Si");
                        $('#userEnabled').prop('checked', true);
                    } else{
                        $('#userEnabledLbl').text("No");
                        $('#userEnabled').prop('checked', false);
                    }

                    $('#userMenus').empty();
                    var menus = response.data.menus;
                    menus.forEach(menu => {
                        $('#userMenus').append(new Option( menu.name , menu.id ));
                    });

                    $("#titleUserModal").html('<strong><i class="fas fa-user-edit"></i> Editar Usuario</strong>');
                    $('#userModal').modal('show');


                }).catch((error)=>{
                    console.log(error)
                    toastr.error('Ha ocurrido un error cuando se intentaba editar el usuario.<br><br>' + error);
                });

            });
        }

        var btnDeleteUser = document.getElementsByClassName("deleteUserClass");
        var i;
        for (i = 0; i < btnDeleteUser.length; i++) {

            btnDeleteUser[i].addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();

                var id = $(this).data('id');
                var name = $(this).data('name');

                swal({
                    title: "¿Seguro que desea borrar el usuario '" + name + "'?",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Si, elimínelo!",
                    cancelButtonText: "No, cancele!",
                    reverseButtons: !0
                }).then(function (e) {
                    if (e.value === true) {
                        var token = document.head.querySelector('meta[name="csrf-token"]');
                        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                        axios.post('/users/destroy',{
                            params: {
                                id: id,
                            }
                        })
                        .then((response) => {
                            //console.log(response);
                            var userView = response.data;
                            $('#content').html(userView);

                        }).catch((error)=>{
                            console.log('error:',error);
                            toastr.error('ERROR: ' + error);
                        });

                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                });
            });
        }


        $('#userEnabled').on('change.bootstrapSwitch', function (e, state) {
            if (e.target.checked == true) {
                $('#userEnabledLbl').text("Si");
            } else {
                $('#userEnabledLbl').text("No");
            }
        });


        $('#btnAddMenu').on('click', function(e) {
            e.preventDefault();

            var menuText = $("#allMenus option:selected").text();
            var menuValue = $("#allMenus option:selected").val();
            var selectUser = document.getElementById('userMenus');
            var found = false;
            for( var i=0 ; i < selectUser.length ; i++ ) {
                if( selectUser.options[i].value == menuValue ) {
                    selectUser.selectedIndex = i;
                    found = true;
                    break;
                }
            }
            if( !found ) {
                $('#userMenus').append( $("<option>", {
                    value: menuValue,
                    text: menuText
                }));
            }

        });

        $('#btnDeleteMenu').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $("#userMenus option:selected").remove();
        });

        function saveUser( url ){
            var id = $('#userId').val();
            var name = $('#userName').val();
            var email = $('#userEmail').val();
            var enabled = $("#userEnabled").is(':checked') ? 1 : 0;
            var role = $('#role').val();
            //console.log('role',role);
            if( (role === "") || (role == undefined) ) {
                swal({
                    title: "Debe asociar un rol al usuario!",
                    type: "error",
                    showCancelButton: false,
                    confirmButtonText: "Ok",
                });
                return false;
            }

            var options = document.getElementById('userMenus').options;
            var values = Array.from(options).map(({ value }) => value);
            var menuList = values.join('|');
            //console.log(url,id,name,email,enabled,menuList);
            axios.post( url , {
                params: {
                    id: id,
                    name: name,
                    email: email,
                    enabled: enabled,
                    menuList: menuList,
                    role: role,
                }
            })
            .then((response)=>{
                //console.log(response);
                $('#userModal').modal('hide');
                toastr.success('Información del usuario grabada exitósamente.');

                axios.post('/users')
                .then((response) => {
                    //console.log(response);
                    var userView = response.data;
                    $('#content').html(userView);

                }).catch((error)=>{
                    console.log('error:',error);
                    toastr.error('ERROR: ' + error);
                });

            }).catch((error)=>{
                console.log(error)
                toastr.error('Ocurrió un error al intentar grabar el usuario.<br>[' + error + ']');
            });

        }

        $('#btnSaveUserForm').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var id = $('#userId').val();
            saveUser( (id != "") ? '/users/update' : '/users/store' );
        });

    });

</script>
