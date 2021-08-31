<div class="container">
    <div class="row mt-2">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><strong>Nuevo Menú/Opción Menú</strong></h5>
                </div>
                <div class="card-body">
                    <form id="formMenu">
                        <input type="hidden" class="form-control" name="menu_id" id="menu_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="menu_name">Nombre</label>
                                    <input type="text" class="form-control" name="menu_name" id="menu_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="menu_url">URL del Reporte</label>
                                    <input type="text" class="form-control" name="menu_url" id="menu_url">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="menu_parent_id">Menú Padre</label>
                                    <select name="menu_parent_id" id="menu_parent_id" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="menu_enabled">Activo</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="menu_enabled" checked>
                                        <label class="custom-control-label" for="menu_enabled" id="menu_enabledLbl">Si</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <div>
                        <button class="btn btn-sm btn-warning" id="btnClearMenu"><i class="fas fa-eraser"></i> Limpiar</button>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-danger" id="btnDeleteMenu"><i class="far fa-trash-alt"></i> Eliminar</button>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-success" id="btnSaveMenu"><i class="far fa-save"></i> Grabar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6" id="menubarTreeView">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5><strong>Barra de Menús Actual</strong></h5>
                </div>
                <div class="card-body" id="adminTreeView">
                    @include('menus.admin-treeView',compact($menus))
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <button class="btn btn-sm btn-info" id="btnRefreshTreeView"><i class="fas fa-sync-alt"></i> Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">


    function drawOption( p_current_parent_id , p_value , p_text , p_parent_id , p_level ) {
        var str = String.fromCharCode(8194);
        var spaces = str.repeat( 2 * p_level );

        if( p_current_parent_id === p_parent_id ) {
            $('#menu_parent_id').append($('<option>', {
                value: p_value,
                text: spaces + p_text,
            }));
        } else {
            drawOption( p_parent_id , p_value , p_text , p_parent_id , p_level + 1 );
        }
    }

    var btnRefreshTreeView = document.getElementById("btnRefreshTreeView");
    btnRefreshTreeView.addEventListener("click", function(e) {
        e.preventDefault();
        e.stopPropagation();

        var token = document.head.querySelector('meta[name="csrf-token"]');
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

        axios.post('/menus/getMenuTreeView')
        .then((response) => {
            //console.log(response);
            $("#adminTreeView").html(response.data);

        }).catch((error)=>{
            console.log('error:',error);
            toastr.error('ERROR: ' + error);
        });

    });


    var btnDeleteMenu = document.getElementById("btnDeleteMenu");
    btnDeleteMenu.addEventListener("click", function(e) {
        e.preventDefault();
        e.stopPropagation();

        swal({
            title: "¿Está seguro que desea eliminar este menú?",
            text: "Esto borrará los submenus y opciones hijas. Por favor, asegúrese y luego confirme!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Si, elimínelo!",
            cancelButtonText: "No, cancele!",
            reverseButtons: !0
        }).then(function (e) {

            if (e.value === true) {
                var token = document.head.querySelector('meta[name="csrf-token"]');
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

                var menu_id = $("#menu_id").val();

                axios.post('/menus/destroy',{
                    params: {
                        menu_id: menu_id,
                    }
                })
                .then((response) => {
                    //console.log(response);
                    $("#adminTreeView").html(response.data);
                    $('#btnClearMenu').trigger("click");
                    // Se obtienen todos los menus para actualizar el Select/option del form
                    axios.post('/menus/refreshAllMenus')
                    .then((response) => {
                        //console.log(response);
                        var allMenus = response.data;

                        $("#menu_parent_id").empty().append("<option disabled='disabled' value='' selected>Seleccione el menú padre</option>");
                        $.each(allMenus, function(i, menu) {
                            drawOption( menu.parent_id , menu.id , menu.name , menu.parent_id , (menu.parent_id == null ? 0 : menu.parent_id ) );
                        });

                    }).catch((error)=>{
                        console.log('error:',error);
                        toastr.error('ERROR: ' + error);
                    });

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


    var btnClearMenu = document.getElementById("btnClearMenu");
    btnClearMenu.addEventListener("click", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#formMenu').trigger("reset");
        $("#btnSaveMenu").html("<i class='far fa-save'></i> Agregar Nuevo");
    });


    var btnSaveMenu = document.getElementById("btnSaveMenu");
    btnSaveMenu.addEventListener("click", function(e) {
        e.preventDefault();
        e.stopPropagation();

        var token = document.head.querySelector('meta[name="csrf-token"]');
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

        var menu_id = $('#menu_id').val();
        var menu_name = $('#menu_name').val();
        var menu_url = $('#menu_url').val();
        var menu_parent_id = $('#menu_parent_id').val();
        var menu_enabled = $("#menu_enabled").is(':checked') ? 1 : 0;
        //***** Validaciones *****
        //console.log('============================');
        //console.log('menu_id',menu_id);
        //console.log('menu_name',menu_name);
        //console.log('menu_url',menu_url);
        //console.log('menu_parent_id',menu_parent_id);
        //console.log('menu_enabled',menu_enabled);

        if (menu_id === "") {
            axios.post('/menus/store',{
                params: {
                    name: menu_name,
                    url: menu_url,
                    parent_id: menu_parent_id,
                    enabled: menu_enabled,
                }
            })
            .then((response) => {
                //console.log(response);
                $('#btnClearMenu').trigger("click");
                $("#adminTreeView").html(response.data);

            }).catch((error)=>{
                console.log('error:',error);
                toastr.error('ERROR: ' + error);
            });

        } else {
            axios.post('/menus/update',{
                params: {
                    id: menu_id,
                    name: menu_name,
                    url: menu_url,
                    parent_id: menu_parent_id,
                    enabled: menu_enabled,
                }
            })
            .then((response) => {
                //console.log(response);
                $('#btnClearMenu').trigger("click");
                $("#adminTreeView").html(response.data);

            }).catch((error)=>{
                console.log('error:',error);
                toastr.error('ERROR: ' + error);
            });

        }

    });

    // Se obtienen todos los menus para actualizar el Select/option del form
    axios.post('/menus/refreshAllMenus')
    .then((response) => {
        //console.log(response);
        var allMenus = response.data;

        $("#menu_parent_id").empty().append("<option disabled='disabled' value='' selected>Seleccione el menú padre</option>");
        $.each(allMenus, function(i, menu) {
            drawOption( menu.parent_id , menu.id , menu.name , menu.parent_id , (menu.parent_id == null ? 0 : menu.parent_id ) );
        });

    }).catch((error)=>{
        console.log('error:',error);
        toastr.error('ERROR: ' + error);
    });


</script>

