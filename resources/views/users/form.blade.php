<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleUserModal"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
                <form id="userForm">
                    <input type="hidden" id="userId" class="form-control" placeholder="Id del usuario">

                    <div class="row my-0">
                        <div class="col-8 form-group">
                            <label for="userName">Nombre</label>
                            <input type="text" id="userName" class="form-control" placeholder="Nombre del usuario">
                        </div>
                        <div class="col-4 form-group">
                            <label for="roleId">Rol</label>
                            <select class="form-control" id="role">
                                <option disabled="disabled" value="" selected>Seleccione...</option>
                                @foreach ($roles as $key => $role)
                                    <option value="{{ $key }}">{{ $role }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row my-0">
                        <div class="col-8 form-group">
                            <label for="userEmail">Correo Electrónico</label>
                            <input type="email" class="form-control" id="userEmail" placeholder="Correo del usuario">
                        </div>
                        <div class="col-4 form-group">
                            <div class="form-check">
                                <label class="col-sm-3 col-form-label">Habilitado</label>
                                <div class="custom-control custom-switch d-flex justify-content-center">
                                    <input type="checkbox" class="custom-control-input" id="userEnabled" checked>
                                    <label class="custom-control-label" for="userEnabled" id="userEnabledLbl">Si</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-0 mb-3 py-0">
                    <div class="form-inline mb-2">
                        <div class="col-5 d-flex justify-content-left">
                            <div class="form-group">
                                <label for="allMenus">Menús:&nbsp;&nbsp;</label>
                                <br>
                                <select class="form-control" id="allMenus">
                                    @foreach ($allMenus as $key => $menu)
                                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn btn-sm btn-success rounded-circle mb-2" id="btnAddMenu"><i class="fas fa-plus-circle"></i></button>
                            <button type="button" class="btn btn-sm btn-danger rounded-circle" id="btnDeleteMenu"><i class="fas fa-minus-circle"></i></button>

                        </div>
                        <div class="col-6 d-flex justify-content-center">
                            <select multiple class="form-control custom-select" size="3" id="userMenus" style="width: 100%;">
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="float-left">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-sm btn-primary" id="btnSaveUserForm">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
