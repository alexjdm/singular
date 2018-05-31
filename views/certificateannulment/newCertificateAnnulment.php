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
                <h4 class="text-center">No hay certificados que modificar</h4>
            </div>

            <!-- form start -->
            <form id="newCertificateAnnulmentForm" class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="poliza">Poliza *</label>
                        <div class="col-sm-10">
                            <select id="poliza" class="form-control">
                                <?php foreach ($seguros as $seguro): ?>
                                    <option value="<?php echo $seguro['POLIZA']; ?>"><?php echo utf8_encode($seguro['POLIZA']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="certificado">Certificado</label>
                        <div class="col-sm-10">
                            <span id="certificado"></span>
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

    <?php if(count($seguros) == 0): ?>
        $('#newCertificateAnnulmentForm').hide();
        $('#newCertificateAnnulmentBtn').hide();
        $('#cleanDataCertificateAnnulmentBtn').hide();
        $('#sinData').show();
    <?php endif; ?>

    $('#newCertificateAnnulmentBtn').click(function(){
        var e = 'ajax.php?controller=CertificateAnnulment&action=createNewCertificateAnnulment'; console.debug(e);

        var poliza = $("#poliza").val(); console.debug(poliza);

        if(poliza == '')
        {
            $('#messageNewCertificateAnnulment').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { poliza: poliza },
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