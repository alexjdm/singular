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

                    <!--<div class="form-group">
                        <label class="col-sm-3 control-label" for="dondeDice">Donde dice *</label>
                        <div class="col-sm-9">
                            <input id="dondeDice" class="form-control" type="text" minlength="1" maxlength="200">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="debeDecir">Debe decir *</label>
                        <div class="col-sm-9">
                            <input id="debeDecir" class="form-control" type="text" minlength="1" maxlength="200">
                        </div>
                    </div>-->


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

    var certificados = $("#certificado").html();

    $('#poliza').change(function () {

        var idPoliza = $("#poliza :selected").val();
        $("#certificado").html(certificados);
        $('#certificado :not([data-idPoliza^="' + idPoliza + '"])').remove();

    });
    $('#poliza').trigger("change");

    $('#newCertificateModifyBtn').click(function(){
        var e = 'ajax.php?controller=CertificateModify&action=createNewCertificateModify'; //console.debug(e);

        var idPoliza = $("#poliza").val(); //console.debug(poliza);
        var idCertificado = $("#certificado").val(); //console.debug(idCertificado);
        var dondeDice = $("#dondeDice").val(); //console.debug(dondeDice);
        var debeDecir = $("#debeDecir").val(); //console.debug(debeDecir);

        if(idPoliza === '' || idCertificado === '' || dondeDice === '' || debeDecir === '')
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
                    if(data.status == "success"){
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