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
            <h4 class="modal-title">Editar Solicitud de Anulación de Certificado</h4>
        </div>
        <div class="modal-body">

            <div id="sinData" style="display: none;">
                <h4 class="text-center">No hay polizas en el sistema</h4>
            </div>

            <!-- form start -->
            <form id="newCertificateAnnulmentForm" class="form-horizontal">
                <div class="box-body">

                    <input type="hidden" id="idCertificadoAnulacion" value="<?php echo $certificadoAnulacion['ID_CERTIFICADO_ANULACION']; ?>" >

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="poliza">Poliza *</label>
                        <div class="col-sm-9">
                            <select id="poliza" class="form-control">
                                <?php foreach ($polizas as $poliza): ?>
                                    <option value="<?php echo $poliza['ID_POLIZA']; ?>" <?php if($poliza['ID_POLIZA'] == $certificadoAnular['ID_POLIZA']) { echo "selected"; } ?>><?php echo utf8_encode($poliza['TIPO_POLIZA']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="certificado">Certificado *</label>
                        <div class="col-sm-9">
                            <select id="certificado" class="form-control">
                                <?php foreach ($certificados as $certificado): ?>
                                    <option data-idPoliza="<?php echo $certificado['ID_POLIZA']; ?>" value="<?php echo $certificado['ID_CERTIFICADO']; ?>" <?php if($certificado['ID_CERTIFICADO'] == $certificadoAnular['ID_CERTIFICADO']) { echo "selected"; } ?> ><p><?php echo "N° " . $certificado['NUMERO'] . " de " . $certificado['ORIGEN'] . " a " . $certificado['DESTINO'] . " el " . FormatearFechaSpa($certificado['FECHA_EMBARQUE']) ?></p></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="motivo">Motivo *</label>
                        <div class="col-sm-9">
                            <input id="motivo" class="form-control" type="text" minlength="3" maxlength="200" value="<?php echo $certificadoAnulacion['MOTIVO']; ?>">
                        </div>
                    </div>


                    <div id="messageNewCertificateAnnulment" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataCertificateAnnulmentBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="editCertificateAnnulmentBtn" class="btn btn-primary" type="submit">Guardar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    <?php if(count($polizas) == 0): ?>
    $('#newCertificateAnnulmentForm').hide();
    $('#editCertificateAnnulmentBtn').hide();
    $('#cleanDataCertificateAnnulmentBtn').hide();
    $('#sinData').show();
    <?php endif; ?>

    var certificados = $("#certificado").html();

    $('#poliza').change(function () {

        var idPoliza = $("#poliza :selected").val();
        $("#certificado").html(certificados);
        $('#certificado :not([data-idPoliza^="' + idPoliza + '"])').remove();

    });
    $('#poliza').trigger("change");

    $('#editCertificateAnnulmentBtn').click(function(){
        var e = 'ajax.php?controller=CertificateAnnulment&action=certificateAnnulmentEdit2db'; //console.debug(e);

        var idCertificadoAnulacion = $("#idCertificadoAnulacion").val(); //console.debug(poliza);
        var idPoliza = $("#poliza").val(); //console.debug(poliza);
        var idCertificado = $("#certificado").val(); //console.debug(idCertificado);
        var motivo = $("#motivo").val(); //console.debug(motivo);

        if(idPoliza === '' || idCertificado === '' || motivo === '')
        {
            $('#messageNewCertificateAnnulment').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { idCertificadoAnulacion: idCertificadoAnulacion, idCertificado: idCertificado, motivo: motivo },
                dataType : "json",
                beforeSend: function () {
                    $('#editCertificateAnnulmentBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewCertificateAnnulment').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#editCertificateAnnulmentBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewCertificateAnnulment').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#editCertificateAnnulmentBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewCertificateAnnulment').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#editCertificateAnnulmentBtn').html("Agregar");
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