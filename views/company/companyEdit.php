<style>
    .form-group{
        padding: 15px;
    }
</style>

<div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar Compañia</h4>
        </div>
        <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
            <input id="idCompania" value="<?php echo $compania['ID_COMPANIA'] ?>" type="hidden">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="nombre">Nombre</label>
                <div class="col-sm-9">
                    <input class="form-control" id="nombre" type="text" value="<?php echo $compania['NOMBRE'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="tasa">Tasa</label>
                <div class="col-sm-9">
                    <input class="form-control" id="tasa" type="text" value="<?php echo $compania['TASA'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="prima_minima">Prima Mínima</label>
                <div class="col-sm-9">
                    <input class="form-control" id="prima_minima" type="text" value="<?php echo $compania['PRIMA_MINIMA'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="limite_embarque">Límite Embarque</label>
                <div class="col-sm-9">
                    <input class="form-control" id="limite_embarque" type="limite_embarque" value="<?php echo $compania['LIMITE_EMBARQUE'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="tipo_cuenta">Tipo de Cuenta</label>
                <div class="col-sm-9">
                    <input class="form-control" id="tipo_cuenta" type="text" value="<?php echo $compania['TIPO_CUENTA'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="comision">Comisión</label>
                <div class="col-sm-9">
                    <input class="form-control" id="comision" type="text" value="<?php echo $compania['COMISION'] ?>">
                </div>
            </div>
            <br>
            <div id="messageEditCompany"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            <!--<?php if ($compania['HABILITADO'] == 1) { ?>
                <button type="button" class="btn btn-primary" id="toggleDesactivar">Desactivar</button>
            <?php } else if ($compania['HABILITADO'] == 0) { ?>
                <button type="button" class="btn btn-primary" id="toggleActivar">Activar</button>
            <?php } ?>-->

            <button id="saveCompanyEdit" type="button" class="btn btn-primary">Guardar</button>

        </div>
    </div>
</div>

<script type="application/javascript">

    $('#saveCompanyEdit').click(function(){
        var e = 'ajax.php?controller=Company&action=companyEdit2db';
        var idCompania = $("#idCompania").val();
        var nombre = $("#nombre").val();
        var tasa = $("#tasa").val();
        var prima_minima = $("#prima_minima").val();
        var limite_embarque = $("#limite_embarque").val();
        var tipo_cuenta = $("#tipo_cuenta").val();
        var comision = $("#comision").val();

        $.ajax({
            type: 'GET',
            url: e,
            data: { idCompania: idCompania, nombre: nombre, tasa:tasa, prima_minima:prima_minima, limite_embarque: limite_embarque, tipo_cuenta: tipo_cuenta, comision: comision },
            dataType : "json",
            beforeSend: function () {
                $('#saveCompanyEdit').html("Cargando...");
            },
            success: function (data) {
                console.debug("success");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                if(data.status == "success"){
                    console.debug("success");
                    $('#messageEditCompany').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                    $('#saveCompanyEdit').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                    $('#modalPrincipal').hide();
                    window.location.reload(true);
                }
                else{
                    console.debug("fail");
                    $('#saveCompanyEdit').html("Guardar");
                    $('#messageEditCompany').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                }
            },
            error: function (data) {
                console.debug("error");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                $('#saveCompanyEdit').html("Guardar");
                $('#messageEditCompany').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
            }
        });
    });

</script>