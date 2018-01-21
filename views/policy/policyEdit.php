<style>
    .form-group{
        padding: 15px;
    }
</style>

<div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar Poliza</h4>
        </div>
        <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
            <input id="idPoliza" value="<?php echo $poliza['ID_POLIZA'] ?>" type="hidden">

            <div class="form-group">
                <label class="col-sm-3 control-label" for="compania">Compania</label>
                <div class="col-sm-9">
                    <select id="compania" class="form-control">
                        <?php foreach ($companias as $compania): ?>
                            <option value="<?php echo $compania['ID_COMPANIA']; ?>" <?php if($poliza['ID_COMPANIA'] == $compania['ID_COMPANIA']) { echo "selected"; } ?>><?php echo utf8_encode($compania['NOMBRE']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="tipoPoliza">Tipo Poliza</label>
                <div class="col-sm-9">
                    <input class="form-control" id="tipoPoliza" type="text" value="<?php echo $poliza['TIPO_POLIZA'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="numeroPoliza">Número Poliza</label>
                <div class="col-sm-9">
                    <input class="form-control" id="numeroPoliza" type="text" value="<?php echo $poliza['NUMERO'] ?>">
                </div>
            </div>

            <br>
            <div id="messageEditPolicy"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            <!--<?php if ($poliza['HABILITADO'] == 1) { ?>
                <button type="button" class="btn btn-primary" id="toggleDesactivar">Desactivar</button>
            <?php } else if ($poliza['HABILITADO'] == 0) { ?>
                <button type="button" class="btn btn-primary" id="toggleActivar">Activar</button>
            <?php } ?>-->

            <button id="savePolicyEdit" type="button" class="btn btn-primary">Guardar</button>

        </div>
    </div>
</div>

<script type="application/javascript">

    $('#savePolicyEdit').click(function(){
        var e = 'ajax.php?controller=Policy&action=policyEdit2db';
        var idPoliza = $("#idPoliza").val();
        var idCompania = $("#compania").val();
        var tipoPoliza = $("#tipoPoliza").val();
        var numeroPoliza = $("#numeroPoliza").val();

        $.ajax({
            type: 'GET',
            url: e,
            data: { idPoliza: idPoliza, idCompania: idCompania, tipoPoliza: tipoPoliza, numeroPoliza: numeroPoliza },
            dataType : "json",
            beforeSend: function () {
                $('#savePolicyEdit').html("Cargando...");
            },
            success: function (data) {
                console.debug("success");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                if(data.status == "success"){
                    console.debug("success");
                    $('#messageEditPolicy').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                    $('#savePolicyEdit').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                    $('#modalPrincipal').hide();
                    window.location.reload(true);
                }
                else{
                    console.debug("fail");
                    $('#savePolicyEdit').html("Guardar");
                    $('#messageEditPolicy').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                }
            },
            error: function (data) {
                console.debug("error");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                $('#savePolicyEdit').html("Guardar");
                $('#messageEditPolicy').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
            }
        });
    });

</script>