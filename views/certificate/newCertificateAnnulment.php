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
            <h4 class="modal-title">Nueva Solicitud de Anulación de Certificado</h4>
        </div>
        <div class="modal-body">

            <div id="sinData" style="display: none;">
                <h4 class="text-center">No hay polizas en el sistema</h4>
            </div>

            <!-- form start -->
            <form id="newCertificateAnnulmentForm" class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="idPoliza">Poliza *</label>
                        <div class="col-sm-9">
                            <select id="idPoliza" class="form-control">
                                <?php foreach ($polizas as $poliza): ?>
                                    <option value="<?php echo $poliza['ID_POLIZA']; ?>"><?php echo utf8_encode($poliza['TIPO_POLIZA'] . " (" . $poliza['NUMERO'] . ")"); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="buscadorCertificado">Certificado *</label>
                        <div class="col-sm-7">
                            <input type="text" id="buscadorCertificado" class="form-control" placeholder="Ingresa el número del certificado">
                        </div>
                        <div class="col-sm-2">
                            <button id="btnBuscar" class="btn btn-default">Buscar</button>
                        </div>
                        <div class="col-sm-9 col-sm-offset-3" id="resultadoCertificado" style="margin-top: 10px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="motivo">Motivo *</label>
                        <div class="col-sm-9">
                            <input id="motivo" class="form-control" type="text" minlength="3" maxlength="200">
                        </div>
                    </div>

                    <div id="messageNewCertificateAnnulment" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataCertificateAnnulmentBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newCertificateAnnulmentBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    <?php if(count($polizas) == 0): ?>
        $('#newCertificateAnnulmentForm').hide();
        $('#newCertificateAnnulmentBtn').hide();
        $('#cleanDataCertificateAnnulmentBtn').hide();
        $('#sinData').show();
    <?php endif; ?>

    $("#btnBuscar").click(function () {
        var url = 'ajax.php?controller=Certificate&action=searchCertificate'; console.debug(url);
        var idPoliza = $("#idPoliza :selected").val();
        var numero = $("#buscadorCertificado").val();

        if(idPoliza === '' || numero === '')
        {
            $('#resultadoCertificado').html('<p><strong>Error! </strong> Debes ingresar el número del certificado</p>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: url,
                data: { idPoliza: idPoliza, numero: numero },
                dataType : "json",
                beforeSend: function () {
                    $('#resultadoCertificado').html("Buscando...");
                },
                success: function (data) {
                    console.debug("success");
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    //debugger;
                    if(data.status === "success"){
                        console.debug("success");
                        //debugger;
                        $('#resultadoCertificado').html("<p id='idCertificado' data-idcertificado='" + data.message[0].ID_CERTIFICADO + "'> N° " + data.message[0].NUMERO + " de " + data.message[0].ORIGEN + " a " + data.message[0].DESTINO + " el " + data.message[0].FECHA_EMBARQUE + "</p>");
                    }
                    else{
                        console.debug("fail");
                        $('#resultadoCertificado').html('<p><strong>Error! </strong>' + data.message + '</p>');
                    }
                },
                error: function (data) {
                    console.log("error");
                    console.debug(data);
                    //debugger;
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#resultadoCertificado').html('<p><strong>Error! </strong>' + data.message + '</p>');
                }
            });
        }

        return false;
    });

    $('#idPoliza').change(function () {
        $('#buscadorCertificado').html("");
        $('#resultadoCertificado').html("");
    });

    //$('#idPoliza').trigger("change");

    $('#newCertificateAnnulmentBtn').click(function(){
        var e = 'ajax.php?controller=Certificate&action=createNewCertificateAnnulment'; //console.debug(e);

        var idPoliza = $("#idPoliza :selected").val();
        var idCertificado = $("#idCertificado").data('idcertificado'); console.log(idCertificado);
        var motivo = $("#motivo").val(); //console.debug(motivo);

        if(idPoliza === '' || idCertificado === undefined || idCertificado === '' || idCertificado === 0 || motivo === '')
        {
            $('#messageNewCertificateAnnulment').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { idCertificado: idCertificado, motivo: motivo },
                dataType : "json",
                beforeSend: function () {
                    $('#newCertificateAnnulmentBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status === "success"){
                        $('#messageNewCertificateAnnulment').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newCertificateAnnulmentBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewCertificateAnnulment').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newCertificateAnnulmentBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewCertificateAnnulment').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newCertificateAnnulmentBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataCertificateAnnulmentBtn").click(function() {
        console.debug("clean");
        $("#newCertificateAnnulmentForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>