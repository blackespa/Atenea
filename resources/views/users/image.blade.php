{{-- modal --}}
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Subir Imagen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-12 d-flex justify-content-center">
                        <img id="imageSample" src="{{url('uploads/icon-user-default.png')}}" class="rounded-circle" style="width: 125px; height: 125px;">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <input type="file" id="imageFile" class="form-control" style="font-size: 9px;">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-danger mr-3" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-sm btn-info mr-3" id="btnPreview">Previsualizar</button>
                        <button type="button" class="btn btn-sm btn-success mr-3" id="btnLoadImage">Cargar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $("#imageFile").on("change", function(e) {
        if($("#imageFile").val() !== "") {
            $('#btnPreview').trigger('click');
        }
    });

</script>
