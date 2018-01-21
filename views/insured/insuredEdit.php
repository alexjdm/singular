<style>
    .form-group{
        padding: 15px;
    }
</style>

<div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar Asegurado</h4>
        </div>
        <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
            <input id="idAsegurado" value="<?php echo $asegurado['ID_ASEGURADO'] ?>" type="hidden">

            <div class="form-group">
                <label class="col-sm-3 control-label" for="rut">Rut</label>
                <div class="col-sm-9">
                    <input class="form-control" id="rut" type="text" value="<?php echo $asegurado['IDENTIFICADOR'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="nombre">Nombre</label>
                <div class="col-sm-9">
                    <input class="form-control" id="nombre" type="text" value="<?php echo $asegurado['NOMBRE'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="giro">Giro</label>
                <div class="col-sm-9">
                    <input class="form-control" id="giro" type="giro" value="<?php echo $asegurado['GIRO'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="region">Región</label>
                <div class="col-sm-9">
                    <select id="region" class="form-control">
                        <?php foreach ($regiones as $region): ?>
                            <option value="<?php echo $region['ID_REGION']; ?>" <?php if($region['ID_REGION'] == $asegurado['ID_REGION']) { echo "selected"; } ?>><?php echo utf8_encode($region['NOMBRE']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="region">Comuna</label>
                <div class="col-sm-9">
                    <select id="comuna" class="form-control">
                        <?php foreach ($comunas as $comuna): ?>
                            <option value="<?php echo $comuna['ID_COMUNA']; ?>" <?php if($comuna['ID_COMUNA'] == $asegurado['ID_COMUNA']) { echo "selected"; } ?>><?php echo utf8_encode($comuna['NOMBRE']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="direccion">Dirección</label>
                <div class="col-sm-9">
                    <input class="form-control" id="direccion" type="text" value="<?php echo $asegurado['DIRECCION'] ?>">
                </div>
            </div>

            <br>
            <div id="messageEditClient"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            <!--<?php if ($asegurado['HABILITADO'] == 1) { ?>
                <button type="button" class="btn btn-primary" id="toggleDesactivar">Desactivar</button>
            <?php } else if ($asegurado['HABILITADO'] == 0) { ?>
                <button type="button" class="btn btn-primary" id="toggleActivar">Activar</button>
            <?php } ?>-->

            <button id="saveClientEdit" type="button" class="btn btn-primary">Guardar</button>

        </div>
    </div>
</div>

<script type="application/javascript">

    $('#saveClientEdit').click(function(){
        var e = 'ajax.php?controller=Insured&action=insuredEdit2db';
        var idAsegurado = $("#idAsegurado").val();
        var rut = $("#rut").val();
        var nombre = $("#nombre").val();
        var giro = $("#giro").val();
        var idRegion = $("#region").val();
        var idComuna = $("#comuna").val();
        var direccion = $("#direccion").val();

        $.ajax({
            type: 'GET',
            url: e,
            data: { idAsegurado: idAsegurado, rut:rut, nombre: nombre, giro: giro, idRegion: idRegion, idComuna: idComuna, direccion:direccion },
            dataType : "json",
            beforeSend: function () {
                $('#saveClientEdit').html("Cargando...");
            },
            success: function (data) {
                console.debug("success");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                if(data.status == "success"){
                    console.debug("success");
                    $('#messageEditClient').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                    $('#saveClientEdit').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                    $('#modalPrincipal').hide();
                    window.location.reload(true);
                }
                else{
                    console.debug("fail");
                    $('#saveClientEdit').html("Guardar");
                    $('#messageEditClient').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                }
            },
            error: function (data) {
                console.debug("error");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                $('#saveClientEdit').html("Guardar");
                $('#messageEditClient').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
            }
        });
    });

</script>