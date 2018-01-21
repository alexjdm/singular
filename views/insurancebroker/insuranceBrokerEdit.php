<style>
    .form-group{
        padding: 15px;
    }
</style>

<div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar</h4>
        </div>
        <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
            <input id="idCorredora" value="<?php echo $corredora['ID_CORREDORA'] ?>" type="hidden">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="nombre">Nombre</label>
                <div class="col-sm-9">
                    <input class="form-control" id="nombre" type="text" value="<?php echo $corredora['NOMBRE'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="rut">Rut</label>
                <div class="col-sm-9">
                    <input class="form-control" id="rut" type="text" value="<?php echo $corredora['RUT'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="direccion">Dirección</label>
                <div class="col-sm-9">
                    <input class="form-control" id="direccion" type="text" value="<?php echo $corredora['DIRECCION'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="ciudad">Ciudad</label>
                <div class="col-sm-9">
                    <input class="form-control" id="ciudad" type="ciudad" value="<?php echo $corredora['CIUDAD'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="telefono">Teléfono</label>
                <div class="col-sm-9">
                    <input class="form-control" id="telefono" type="text" value="<?php echo $corredora['TELEFONO'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="giro">Giro</label>
                <div class="col-sm-9">
                    <input class="form-control" id="giro" type="text" value="<?php echo $corredora['GIRO'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="razonSocial">Razón Social</label>
                <div class="col-sm-9">
                    <input class="form-control" id="razonSocial" type="text" value="<?php echo $corredora['RAZON_SOCIAL'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="tasa">Tasa</label>
                <div class="col-sm-9">
                    <input class="form-control" id="tasa" type="text" value="<?php echo $corredora['TASA'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="primaMin">Prima Mínima</label>
                <div class="col-sm-9">
                    <input class="form-control" id="primaMin" type="text" value="<?php echo $corredora['PRIMA_MIN'] ?>">
                </div>
            </div>
            <br>
            <div id="messageEditInsuranceBroker"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            <!--<?php if ($corredora['HABILITADO'] == 1) { ?>
                <button type="button" class="btn btn-primary" id="toggleDesactivar">Desactivar</button>
            <?php } else if ($corredora['HABILITADO'] == 0) { ?>
                <button type="button" class="btn btn-primary" id="toggleActivar">Activar</button>
            <?php } ?>-->

            <button id="saveInsuranceBrokerEdit" type="button" class="btn btn-primary">Guardar</button>

        </div>
    </div>
</div>

<script type="application/javascript">

    $('#saveInsuranceBrokerEdit').click(function(){
        var e = 'ajax.php?controller=InsuranceBroker&action=insuranceBrokerEdit2db';
        var idCorredora = $("#idCorredora").val();
        var nombre = $("#nombre").val();
        var rut = $("#rut").val();
        var direccion = $("#direccion").val();
        var ciudad = $("#ciudad").val();
        var telefono = $("#telefono").val();
        var giro = $("#giro").val();
        var razonSocial = $("#razonSocial").val();
        var tasa = $("#tasa").val();
        var primaMin = $("#primaMin").val();

        $.ajax({
            type: 'GET',
            url: e,
            data: { idCorredora: idCorredora, nombre: nombre, rut:rut, direccion:direccion, ciudad: ciudad, telefono: telefono, giro: giro, razonSocial: razonSocial, tasa: tasa, primaMin: primaMin },
            dataType : "json",
            beforeSend: function () {
                $('#saveInsuranceBrokerEdit').html("Cargando...");
            },
            success: function (data) {
                console.debug("success");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                if(data.status == "success"){
                    console.debug("success");
                    $('#messageEditInsuranceBroker').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                    $('#saveInsuranceBrokerEdit').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                    $('#modalPrincipal').hide();
                    window.location.reload(true);
                }
                else{
                    console.debug("fail");
                    $('#saveInsuranceBrokerEdit').html("Guardar");
                    $('#messageEditInsuranceBroker').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                }
            },
            error: function (data) {
                console.debug("error");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                $('#saveInsuranceBrokerEdit').html("Guardar");
                $('#messageEditInsuranceBroker').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
            }
        });
    });

</script>