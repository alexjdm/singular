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
            <h4 class="modal-title">Nuevo Siniestro</h4>
        </div>
        <div class="modal-body">

            <div id="sinData" style="display: none;">
                <h4 class="text-center">No hay polizas en el sistema</h4>
            </div>

            <!-- form start -->
            <form id="newSinisterForm" class="form-horizontal">
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
                    <!--<div class="form-group">
                        <label class="col-sm-2 control-label" for="certificado">Certificado *</label>
                        <div class="col-sm-10">
                            <select id="certificado" class="form-control">
                                <?php foreach ($certificados as $certificado): ?>
                                    <option data-idPoliza="<?php echo $certificado['ID_POLIZA']; ?>" value="<?php echo $certificado['ID_CERTIFICADO']; ?>"><p><?php echo "N° " . $certificado['NUMERO'] . " de " . $certificado['ORIGEN'] . " a " . $certificado['DESTINO'] . " el " . FormatearFechaSpa($certificado['FECHA_EMBARQUE']) ?></p></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>-->

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
                        <label class="col-sm-3 control-label" for="motivoSiniestro">Motivo *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="motivoSiniestro" type="text" placeholder="Explique el motivo de la solicitud">
                        </div>
                    </div>

                    <h5>Datos de contacto</h5>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="nombreContacto">Nombre *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="nombreContacto" type="text" placeholder="Escriba su nombre y apellido">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="telefonoContacto">Teléfono *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="telefonoContacto" type="text" placeholder="Escriba su teléfono donde contactarlo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="correoContacto">Email *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="correoContacto" type="text" placeholder="Escriba su correo electrónico">
                        </div>
                    </div>

                    <div id="messageNewSinister" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataSinisterBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newSinisterBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    <?php if(count($polizas) == 0): ?>
    $('#newSinisterForm').hide();
    $('#newSinisterBtn').hide();
    $('#cleanDataSinisterBtn').hide();
    $('#sinData').show();
    <?php endif; ?>

    var certificados = $("#certificado").html();

    $('#idPoliza').change(function () {

        //var idPoliza = $("#poliza :selected").val();
        //$("#certificado").html(certificados);
        //$('#certificado :not([data-idPoliza^="' + idPoliza + '"])').remove();

        $('#buscadorCertificado').html("");
        $('#resultadoCertificado').html("");
    });
    //$('#poliza').trigger("change");

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

                    if(data.status === "success"){
                        console.debug("success");
                        //debugger;
                        $('#resultadoCertificado').html("<p id='idCertificado' data-idcertificado='" + data.message[0].ID_CERTIFICADO + "'> N° " + data.message[0].NUMERO + " de " + data.message[0].ORIGEN + " a " + data.message[0].DESTINO + " el " + data.message[0].FECHA_EMBARQUE + "</p>");
                    }
                    else{
                        console.debug("fail");
                        $('#resultadoCertificado').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    }
                },
                error: function (data) {
                    console.debug("error");
                    console.debug(data);
                    //debugger;
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#resultadoCertificado').html('<p><strong>Error! </strong>' + data.message + '</p>');
                }
            });
        }

        return false;
    });


    $('#newSinisterBtn').click(function(){
        var e = 'ajax.php?controller=Sinister&action=createNewSinister'; console.debug(e);

        var idPoliza = $("#idPoliza").val(); //console.debug(idPoliza);
        var idCertificado = $("#idCertificado").data('idcertificado'); //console.debug(idCertificado);
        var motivoSiniestro = $("#motivoSiniestro").val();
        var nombreContacto = $("#nombreContacto").val();
        var telefonoContacto = $("#telefonoContacto").val();
        var correoContacto = $("#correoContacto").val();

        if(idPoliza === '' || idCertificado === '' || idCertificado === undefined || nombreContacto === '' || telefonoContacto === '' || correoContacto === '')
        {
            $('#messageNewSinister').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { idCertificado: idCertificado, motivo: motivoSiniestro, nombre: nombreContacto, telefono: telefonoContacto, correo: correoContacto },
                dataType : "json",
                beforeSend: function () {
                    $('#newSinisterBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewSinister').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newSinisterBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewSinister').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newSinisterBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewSinister').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newSinisterBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataSinisterBtn").click(function() {
        console.debug("clean");
        $("#newSinisterForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>