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
            <h4 class="modal-title">Nueva Solicitud de Modificación de Certificado</h4>
        </div>
        <div class="modal-body">

            <div id="sinData" style="display: none;">
                <h4 class="text-center">No hay polizas en el sistema</h4>
            </div>

            <!-- form start -->
            <form id="newCertificateModifyForm" class="form-horizontal">
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
                        <div class="col-sm-9 col-sm-offset-3" id="resultadoCertificado" style="margin-top: 10px;"></div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6">
                            <label class="control-label" for="dondeDice">Donde dice *</label>
                            <textarea id="dondeDice" class="form-control" minlength="1" maxlength="200" style="resize: vertical; height: 200px;"></textarea>
                        </div>

                        <div class="col-sm-6">
                            <label class="control-label" for="debeDecir">Debe decir *</label>
                            <textarea id="debeDecir" class="form-control" minlength="1" maxlength="200" style="resize: vertical; height: 200px;"></textarea>
                        </div>
                    </div>

                    <div id="messageNewCertificateModify" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataCertificateModifyBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newCertificateModifyBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    <?php if(count($polizas) == 0): ?>
        $('#newCertificateModifyForm').hide();
        $('#newCertificateModifyBtn').hide();
        $('#cleanDataCertificateModifyBtn').hide();
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

    $('#newCertificateModifyBtn').click(function(){
        var e = 'ajax.php?controller=CertificateModify&action=createNewCertificateModify'; //console.debug(e);

        var idPoliza = $("#idPoliza :selected").val();
        var idCertificado = $("#idCertificado").data('idcertificado'); console.log(idCertificado);
        var dondeDice = $("#dondeDice").val(); //console.debug(dondeDice);
        var debeDecir = $("#debeDecir").val(); //console.debug(debeDecir);

        if(idPoliza === '' || idCertificado === undefined || idCertificado === '' || dondeDice === '' || debeDecir === '')
        {
            $('#messageNewCertificateModify').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { idCertificado: idCertificado, dondeDice: dondeDice, debeDecir: debeDecir },
                dataType : "json",
                beforeSend: function () {
                    $('#newCertificateModifyBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status === "success"){
                        $('#messageNewCertificateModify').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newCertificateModifyBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewCertificateModify').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newCertificateModifyBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewCertificateModify').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newCertificateModifyBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataCertificateModifyBtn").click(function() {
        $("#newCertificateModifyForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>