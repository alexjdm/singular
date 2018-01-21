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

<div class="modal-dialog" style="width: 50%;">

    <!-- Modal content-->
    <div class="modal-content">

        <!-- form start -->
        <form id="newCertificateForm" class="form-horizontal" method="post" action="ajax.php?controller=Certificate&action=changeNewCertificate">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cambiar Certificado</h4>
            </div>
            <div class="modal-body">

                <div id="sinData" style="display: none;">
                    <h4 class="text-center" id="infoSinData"></h4>
                </div>

                <div class="box-body">

                    <input type="hidden" id="idCertificadoModificacion" value="<?php echo $certificadoModificacion['ID_CERTIFICADO_MODIFICACION']; ?>">
                    <input type="hidden" id="idCertificado" value="<?php echo $certificado['ID_CERTIFICADO']; ?>">
                    <input type="hidden" id="numeroCertificado" value="<?php echo $certificado['NUMERO']; ?>">

                    <p>El nuevo certificado que cargues reemplazará al certificado antiguo irreversiblemente.</p>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="numeroCertificado">Número de Certificado *</label>
                        <div class="col-sm-9">
                            <p><?php echo $certificado['NUMERO'] ?></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="certificado">Certificado *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="certificado" name="certificado" type="file" placeholder="Ingresa el nuevo certificado" required>
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

    $('#newCertificateForm').on('submit',(function(e) {

        e.preventDefault();

        var idCertificadoModificacion = $("#idCertificadoModificacion").val();
        var idCertificado = $("#idCertificado").val();
        var numeroCertificado = $("#numeroCertificado").val();
        var certificado = $('#certificado').val();

        if(idCertificadoModificacion === '' && idCertificado === '' && numeroCertificado === '' && certificado)
        {
            $('#messageNewCertificate').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            var formData = new FormData();
            formData.append('idCertificadoModificacion', $('#idCertificadoModificacion').val());
            formData.append('idCertificado', $('#idCertificado').val());
            formData.append('numeroCertificado', $('#numeroCertificado').val());
            formData.append('certificado', $('#certificado')[0].files[0]);

            var url = 'ajax.php?controller=Certificate&action=changeNewCertificate'; //console.debug(e);

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