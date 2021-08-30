<div class="container mt-3">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><strong><i class="far fa-id-card"></i> Perfil del Usuario</strong></h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-4 text-center">
                            @if( Storage::disk('public')->exists( '/profiles/'.$user->image ) )
                                <img id="btnImageUser" src="{{ asset('storage').'/profiles/'.$user->image }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 125px;">
                            @else
                                <img id="btnImageUser" src="{{ asset('storage').'/profiles/icon-user-default.png' }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 125px;">
                            @endif
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label for="userName">Nombre</label>
                                <input type="text" id="userName" class="form-control" placeholder="Nombre del Usuario" value="{{ $user->name }}">
                              </div>
                              <div class="form-group">
                                  <label for="userEmail">Correo</label>
                                  <input type="text" id="userEmail" class="form-control" placeholder="Correo del Usuario" value="{{ $user->email }}">
                              </div>
                              <div class="form-group">
                                  <label for="created_at">Fecha Creación</label>
                                  <input type="text" id="created_at" class="form-control" value="{{ $user->created_at }}" readonly>
                              </div>
                              <div class="form-group">
                                  <label for="updated_at">Fecha Ultima Modificación</label>
                                  <input type="text" id="updated_at" class="form-control" value="{{ $user->updated_at }}" readonly>
                              </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="float-right">
                        <input id="btnSaveProfile" class="btn btn-sm btn-primary" type="button" value="Guardar">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('users.image')


<script type="text/javascript">

    $( document ).ready(function() {

        $('#btnImageUser').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var src = $('#btnImageUser').prop('src');
            var userName = $('#userName').val();

            $("#imageSample").attr("src",src);
            $("#imageSample").attr("alt",userName);

            $('#imageModal').modal('show');
        });


        $('#btnLoadImage').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var data = new FormData();
            data.append('file', document.getElementById('imageFile').files[0]);
            var settings = { headers: { 'content-type': 'multipart/form-data' } };

            axios.post('/users/upload-image', data , settings )
            .then( response => {
                //console.log(response);
                var pathfilename = response.data.pathfilename;
                //console.log('pathfilename',pathfilename);
                $("#btnImageUser").attr("src",pathfilename);
                $("#AuthUserImage").attr("src",pathfilename);
                $('#imageModal').modal('hide');
                toastr.success('Se ha actualizado la imagen del perfil usuario en forma exitosa.');

            }).catch( error => {
                console.log(error);
                toastr.error('Ha ocurrido un error cuando se intentaba editar el usuario.<br><br>' + error);

            });

        });



        $('#btnPreview').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var data = new FormData();
            data.append('file', document.getElementById('imageFile').files[0]);
            var settings = { headers: { 'content-type': 'multipart/form-data' } };

            //console.log('btnPreview...');

            axios.post('/users/preview-image', data , settings )
            .then( response => {
                //console.log(response);
                var pathfilename = response.data.pathfilename;
                //console.log('pathfilename',pathfilename);
                $("#imageSample").attr("src",pathfilename);

            }).catch( error => {
                console.log(error);
                toastr.error('Ha ocurrido un error cuando se intentaba visualizar la imagen.<br><br>' + error);

            });

        });

    });

</script>
