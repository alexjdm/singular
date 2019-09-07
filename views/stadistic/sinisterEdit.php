<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 03-04-2016
 * Time: 23:50
 */

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editar Siniestro</h4>
        </div>
        <div class="modal-body">

            <!-- form start -->
            <form id="editSinisterForm" class="form-horizontal">

                <input type="hidden" id="idSiniestro" value="<?php echo $siniestro['ID_SINIESTRO'] ?>">

                <div class="box-body">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="siniestro">Siniestro</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="siniestro" type="text" placeholder="" value="<?php echo $siniestro['SINIESTRO']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="montoProvision">Monto Provisión</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="montoProvision" type="text" placeholder="" value="<?php echo $siniestro['MONTO_PROVISION']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="indemnizacion">Indemnización</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="indemnizacion" type="text" placeholder="" value="<?php echo $siniestro['INDEMNIZACION']; ?>">
                        </div>
                    </div>

                    <div id="messageEditSinister" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataSinisterBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="editSinisterBtn" class="btn btn-primary" type="submit">Guardar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $('#editSinisterBtn').click(function(){
        var e = 'ajax.php?controller=Stadistic&action=sinisterEdit2db'; console.debug(e);

        var idSiniestro = $('#idSiniestro').val();
        var siniestro = $("#siniestro").val();
        var montoProvision = $("#montoProvision").val();
        var indemnizacion = $("#indemnizacion").val();

        if(idSiniestro === '')
        {
            $('#messageEditSinister').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> El identificador del siniestro no ha sido cargado. </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { idSiniestro: idSiniestro, siniestro: siniestro, montoProvision: montoProvision, indemnizacion: indemnizacion },
                dataType : "json",
                beforeSend: function () {
                    $('#editSinisterBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status === "success"){
                        $('#messageEditSinister').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#editSinisterBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageEditSinister').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#editSinisterBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageEditSinister').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#editSinisterBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataSinisterBtn").click(function() {
        console.debug("clean");
        $("#editSinisterForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>