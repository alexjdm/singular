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

<style>
    #progress-bar {background-color: #12CC1A;height:20px;color: #FFFFFF;width:0%;-webkit-transition: width .3s;-moz-transition: width .3s;transition: width .3s;}
    #progress-div {border:#0FA015 1px solid;padding: 5px 0px;margin:30px 0px;border-radius:4px;text-align:center;}
    #targetLayer{width:100%;text-align:center;}
</style>

<div class="modal-dialog" style="width: 60%;">

    <!-- Modal content-->
    <div class="modal-content">

        <!-- form start -->
        <form id="newCertificateForm" class="form-horizontal" method="post" action="ajax.php?controller=Certificate&action=createNewCertificate">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Agregar Certificado</h4>
            </div>
            <div class="modal-body">

                <div id="sinData" style="display: none;">
                    <h4 class="text-center" id="infoSinData"></h4>
                </div>

                    <div class="box-body">

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="idCertificadoSolicitud">Solicitud de Certificado *</label>
                            <div class="col-sm-8">
                                <select id="idCertificadoSolicitud" class="form-control">
                                    <?php foreach ($certificadoSolicitudes as $certificadoSolicitud): ?>
                                        <option value="<?php echo $certificadoSolicitud['ID_CERTIFICADO_SOLICITUD']; ?>"><?php echo utf8_encode($certificadoSolicitud['ORIGEN'] . " a " . $certificadoSolicitud['DESTINO'])  . " el " . FormatearFechaSpa($certificadoSolicitud['FECHA_EMBARQUE']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="certificado">Certificado *</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="certificado" name="certificado" type="file" placeholder="Ingresa el certificado" required>
                            </div>
                        </div>

                        <div id="messageNewCertificate" style="margin: 20px;"></div>
                        <!--<div id="progress-div"><div id="progress-bar"></div></div>
                        <div id="targetLayer"></div>
                        <div id="loader-icon" style="display:none;"><img src="dist/img/LoaderIcon.gif" /></div>-->

                    </div>


            </div>
            <div class="modal-footer">
                <button id="cleanDataCertificateBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="newCertificateBtn" class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Cargando">Agregar</button>
            </div>
        </form>
    </div>

</div>

<!--<script type="text/javascript" src="dist/js/jquery.form.min.js"></script>-->
<script type="application/javascript">

    <?php if(count($certificadoSolicitudes) == 0) { ?>
    $('#newCertificateForm').hide();
    $('#newCertificateBtn').hide();
    $('#cleanDataCertificateBtn').hide();

    $('#sinData').append("No hay solicitudes de certificados.");

    $('#sinData').show();
    <?php } ?>


    $('#newCertificateForm').on('submit',(function(e) {
        e.preventDefault();

        var idCertificadoSolicitud = $("#idCertificadoSolicitud").val();
        var certificado = $('#certificado').val();

        if(idCertificadoSolicitud == '' && certificado)
        {
            $('#messageNewCertificate').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            var formData = new FormData();
            formData.append('idCertificadoSolicitud', $('#idCertificadoSolicitud').val());
            formData.append('certificado', $('#certificado')[0].files[0]);

            var url = 'ajax.php?controller=Certificate&action=createNewCertificate'; //console.debug(e);

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                dataType : "json",
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function () {
                    //$('#newCertificateBtn').html("Cargando...");
                },
                success: function (returnedData) {

                    //console.debug("success");
                    //console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(returnedData.status == "success"){
                        //console.debug("Success");
                        $('#messageNewCertificate').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + returnedData.message + '</div>');
                        //$('#saveImageEdit').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                        $('#modalPrincipal').hide();
                        window.location.href = "index.php?controller=Certificate&action=index";
                    }
                    else{
                        console.debug("Fail");
                        //$('#newCertificateBtn').html("Guardar");
                        $('#newCertificateBtn').button('reset');
                        $('#messageNewCertificate').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + returnedData.message + '</div>');
                    }
                },
                error: function(xhr, status, thrown) {
                    console.log(xhr);
                    console.log(status);
                    console.log(thrown);
                    console.log("error");
                    //console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    //$('#saveImageEdit').html("Guardar");
                    $('#newCertificateBtn').button('reset');
                    $('#messageNewCertificate').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + xhr.responseText + '</div>');
                }
            });

            /*if(certificado) {
                e.preventDefault();
                $('#loader-icon').show();
                $('#newCertificateForm').ajaxSubmit({
                    target:   '#targetLayer',
                    beforeSubmit: function() {
                        $("#progress-bar").width('0%');
                    },
                    uploadProgress: function (event, position, total, percentComplete){
                        $("#progress-bar").width(percentComplete + '%');
                        $("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
                    },
                    success:function (){
                        $('#loader-icon').hide();
                    },
                    resetForm: true
                });
            }*/
        }
        return false;
    }));

    $("#cleanDataCertificateBtn").click(function() {
        //console.debug("clean");
        $("#newCertificateForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>