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
            <h4 class="modal-title">Agregar Certificado de reemplazo para el N° <?php echo $certificadoAnulacion['NUMERO'] ?></h4>
        </div>
        <div class="modal-body">

            <!-- form start -->
            <form id="newCertificateAnnulmentForm" class="form-horizontal">
                <div class="box-body">

                    <input type="hidden" id="idCertificadoAnulacion" value="<?php echo $certificadoAnulacion['ID_CERTIFICADO']; ?>" >

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="certificado">Certificado N°</label>
                        <div class="col-sm-9">
                            <select id="certificado" class="form-control">
                                <?php foreach ($certificados as $certificado): ?>
                                    <option value="<?php echo $certificado['ID_CERTIFICADO']; ?>"><?php echo utf8_encode($certificado['NUMERO']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div id="messageNewCertificateAnnulment" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="addNumberCertificateBtn" class="btn btn-primary" type="submit">Guardar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $('#addNumberCertificateBtn').click(function(){
        var e = 'ajax.php?controller=Certificate&action=addReplaceCertificateNumber2db'; //console.debug(e);

        var idCertificadoAnulacion = $("#idCertificadoAnulacion").val(); //console.debug(poliza);
        var idCertificado = $("#certificado").val(); //console.debug(idCertificado);

        if(idCertificado === '')
        {
            $('#messageNewCertificateAnnulment').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { idCertificadoAnulacion: idCertificadoAnulacion, idCertificado: idCertificado },
                dataType : "json",
                beforeSend: function () {
                    $('#addNumberCertificateBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewCertificateAnnulment').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#addNumberCertificateBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewCertificateAnnulment').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#addNumberCertificateBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewCertificateAnnulment').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#addNumberCertificateBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

</script>