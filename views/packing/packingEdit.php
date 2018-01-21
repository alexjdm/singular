<style>
    .form-group{
        padding: 15px;
    }
</style>

<div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar Embalaje</h4>
        </div>
        <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
            <input id="idEmbalaje" value="<?php echo $embalaje['ID_EMBALAJE'] ?>" type="hidden">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="embalaje">Embalaje</label>
                <div class="col-sm-9">
                    <input class="form-control" id="embalaje" type="text" value="<?php echo $embalaje['EMBALAJE'] ?>">
                </div>
            </div>
            <br>
            <div id="messageEditPacking"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            <!--<?php if ($embalaje['HABILITADO'] == 1) { ?>
                <button type="button" class="btn btn-primary" id="toggleDesactivar">Desactivar</button>
            <?php } else if ($embalaje['HABILITADO'] == 0) { ?>
                <button type="button" class="btn btn-primary" id="toggleActivar">Activar</button>
            <?php } ?>-->

            <button id="savePackingEdit" type="button" class="btn btn-primary">Guardar</button>

        </div>
    </div>
</div>

<script type="application/javascript">

    $('#savePackingEdit').click(function(){
        var e = 'ajax.php?controller=Packing&action=packingEdit2db';
        var idEmbalaje = $("#idEmbalaje").val();
        var embalaje = $("#embalaje").val();

        $.ajax({
            type: 'GET',
            url: e,
            data: { idEmbalaje: idEmbalaje, embalaje: embalaje },
            dataType : "json",
            beforeSend: function () {
                $('#savePackingEdit').html("Cargando...");
            },
            success: function (data) {
                console.debug("success");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                if(data.status == "success"){
                    console.debug("success");
                    $('#messageEditPacking').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                    $('#savePackingEdit').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                    $('#modalPrincipal').hide();
                    window.location.reload(true);
                }
                else{
                    console.debug("fail");
                    $('#savePackingEdit').html("Guardar");
                    $('#messageEditPacking').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                }
            },
            error: function (data) {
                console.debug("error");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                $('#savePackingEdit').html("Guardar");
                $('#messageEditPacking').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
            }
        });
    });

</script>