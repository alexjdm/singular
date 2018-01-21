<style>
    .form-group{
        padding: 15px;
    }
</style>

<div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar Materia Asegurada</h4>
        </div>
        <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
            <input id="idMateriaAsegurada" value="<?php echo $materiaAsegurada['ID_MATERIA_ASEGURADA'] ?>" type="hidden">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="materiaAsegurada">Materia Asegurada</label>
                <div class="col-sm-9">
                    <input class="form-control" id="materiaAsegurada" type="text" value="<?php echo $materiaAsegurada['MATERIA_ASEGURADA'] ?>">
                </div>
            </div>
            <br>
            <div id="messageEditInsuredMatter"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            <!--<?php if ($materiaAsegurada['HABILITADO'] == 1) { ?>
                <button type="button" class="btn btn-primary" id="toggleDesactivar">Desactivar</button>
            <?php } else if ($materiaAsegurada['HABILITADO'] == 0) { ?>
                <button type="button" class="btn btn-primary" id="toggleActivar">Activar</button>
            <?php } ?>-->

            <button id="saveInsuredMatterEdit" type="button" class="btn btn-primary">Guardar</button>

        </div>
    </div>
</div>

<script type="application/javascript">

    $('#saveInsuredMatterEdit').click(function(){
        var e = 'ajax.php?controller=InsuredMatter&action=insuredMatterEdit2db';
        var idMateriaAsegurada = $("#idMateriaAsegurada").val();
        var materiaAsegurada = $("#materiaAsegurada").val();

        $.ajax({
            type: 'GET',
            url: e,
            data: { idMateriaAsegurada: idMateriaAsegurada, materiaAsegurada: materiaAsegurada },
            dataType : "json",
            beforeSend: function () {
                $('#saveInsuredMatterEdit').html("Cargando...");
            },
            success: function (data) {
                console.debug("success");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                if(data.status == "success"){
                    console.debug("success");
                    $('#messageEditInsuredMatter').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                    $('#saveInsuredMatterEdit').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                    $('#modalPrincipal').hide();
                    window.location.reload(true);
                }
                else{
                    console.debug("fail");
                    $('#saveInsuredMatterEdit').html("Guardar");
                    $('#messageEditInsuredMatter').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                }
            },
            error: function (data) {
                console.debug("error");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                $('#saveInsuredMatterEdit').html("Guardar");
                $('#messageEditInsuredMatter').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
            }
        });
    });

</script>