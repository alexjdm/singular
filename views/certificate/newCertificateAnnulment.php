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
                    <!--<div class="form-group">
                        <label class="col-sm-3 control-label" for="poliza">Poliza *</label>
                        <div class="col-sm-9">
                            <select id="poliza" class="form-control">
                                <?php foreach ($polizas as $poliza): ?>
                                    <option value="<?php echo $poliza['ID_POLIZA']; ?>"><?php echo utf8_encode($poliza['TIPO_POLIZA']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="certificado">Certificado *</label>
                        <div class="col-sm-9">
                            <select id="certificado" class="form-control">
                                <?php foreach ($certificados as $certificado): ?>
                                    <option data-idPoliza="<?php echo $certificado['ID_POLIZA']; ?>" value="<?php echo $certificado['ID_CERTIFICADO']; ?>"><p><?php echo "N° " . $certificado['NUMERO'] . " de " . $certificado['ORIGEN'] . " a " . $certificado['DESTINO'] . " el " . FormatearFechaSpa($certificado['FECHA_EMBARQUE']) ?></p></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>-->

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="idCertificado">Certificado *</label>
                        <div class="col-sm-7">
                            <input type="text" id="buscadorCertificado" class="form-control" placeholder="Ingresa el número del certificado">
                        </div>
                        <div class="col-sm-2">
                            <button id="btnBuscar" class="btn btn-default">Buscar</button>
                        </div>
                        <div class="col-sm-9 col-sm-offset-3" id="resultadoCertificado"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="motivo">Motivo *</label>
                        <div class="col-sm-9">
                            <input id="motivo" class="form-control" type="text" minlength="3" maxlength="200">
                        </div>
                    </div>

                    <table id="tablaCertificados" style="display: none;">
                        <tbody class="buscar">
                        <?php foreach ($certificados as $certificado): ?>
                            <tr>
                                <td class="numeroCertificado"
                                    data-numerocertificado="<?php echo $certificado['NUMERO']; ?>"
                                    data-idcertificado="<?php echo $certificado['ID_CERTIFICADO']; ?>">
                                    <?php echo utf8_encode($certificado['NUMERO']); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

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

    var idCertificadoSeleccionado = 0;

    $('#btnBuscar').click(function () {

        var numeroCertificado = "";
        var textoAbuscar = $('#buscadorCertificado').val();
        if(textoAbuscar === "") return false;

        var rex = new RegExp(textoAbuscar, 'i'); //console.log(rex);
        var i = 0;

        $(".numeroCertificado").each(function() {
            //console.log($(this).data("numerocertificado"));
            if($(this).data("numerocertificado") == textoAbuscar)
            {
                numeroCertificado = $(this).data("numerocertificado");
                idCertificadoSeleccionado = $(this).data("idcertificado");

                $('#resultadoCertificado').html("Certificado " + numeroCertificado + " existente.");

                return false;
            }
            else
            {
                $('#resultadoCertificado').html("No hay resultados para tu búsqueda.");
            }

        });

        return false;

    });

    var certificados = $("#certificado").html();

    /*$('#poliza').change(function () {

        var idPoliza = $("#poliza :selected").val();
        $("#certificado").html(certificados);
        $('#certificado :not([data-idPoliza^="' + idPoliza + '"])').remove();

    });
    $('#poliza').trigger("change");*/

    $('#newCertificateAnnulmentBtn').click(function(){
        var e = 'ajax.php?controller=Certificate&action=createNewCertificateAnnulment'; //console.debug(e);

        //var idPoliza = $("#poliza").val(); //console.debug(poliza);
        //var idCertificado = $("#certificado").val(); //console.debug(idCertificado);

        var idCertificado = idCertificadoSeleccionado;
        var motivo = $("#motivo").val(); //console.debug(motivo);

        //if(idPoliza === '' || idCertificado === '' || motivo === '')
        if(idCertificado === '' || idCertificado === 0 || motivo === '')
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
                    if(data.status == "success"){
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