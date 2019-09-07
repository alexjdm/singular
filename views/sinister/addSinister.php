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
        <form id="newSinisterForm" class="form-horizontal" method="post" action="ajax.php?controller=Sinister&action=addSinisterDoc">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Agregar liquidación del siniestro</h4>
            </div>
            <div class="modal-body">

                <div id="sinData" style="display: none;">
                    <h4 class="text-center" id="infoSinData"></h4>
                </div>

                <div class="box-body">

                    <input type="hidden" id="idSiniestro" value="<?php echo $siniestro['ID_SINIESTRO']; ?>">

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Siniestro</label>
                        <div class="col-sm-9">
                            <p><?php echo utf8_encode($siniestro['POLIZA'] . " | " . $siniestro['NUMERO_CERTIFICADO'] . " | " . $siniestro['CLIENTE'] . " | " . $siniestro['ASEGURADO']); ?></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="liquidacionSiniestro">Liquidación Siniestro *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="liquidacionSiniestro" name="liquidacionSiniestro" type="file" placeholder="Ingresa la liquidación del siniestro" required>
                        </div>
                    </div>

                    <div id="messageNewSinister" style="margin: 20px;"></div>
                    <!--<div id="progress-div"><div id="progress-bar"></div></div>
                    <div id="targetLayer"></div>
                    <div id="loader-icon" style="display:none;"><img src="dist/img/LoaderIcon.gif" /></div>-->

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="newSinisterBtn" class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Cargando">Agregar</button>
            </div>
        </form>
    </div>

</div>

<!--<script type="text/javascript" src="dist/js/jquery.form.min.js"></script>-->
<script type="application/javascript">

    $('#newSinisterForm').on('submit',(function(e) {

        e.preventDefault();

        var idSiniestro = $("#idSiniestro").val();
        var liquidacionSiniestro = $('#liquidacionSiniestro').val();

        if(idSiniestro === '' && liquidacionSiniestro)
        {
            $('#messageNewSinister').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            var formData = new FormData();
            formData.append('idSiniestro', $('#idSiniestro').val());
            formData.append('liquidacionSiniestro', $('#liquidacionSiniestro')[0].files[0]);

            var url = 'ajax.php?controller=Sinister&action=addSinisterDoc'; //console.debug(e);

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                dataType : "json",
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function () {
                    //$('#newSinisterBtn').html("Cargando...");
                },
                success: function (returnedData) {

                    //console.debug("success");
                    //console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(returnedData.status == "success"){
                        //console.debug("Success");
                        $('#messageNewSinister').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + returnedData.message + '</div>');
                        //$('#saveImageEdit').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                        $('#modalPrincipal').hide();
                        window.location.href = "index.php?controller=Sinister&action=index";
                    }
                    else{
                        console.debug("Fail");
                        //$('#newSinisterBtn').html("Guardar");
                        $('#newSinisterBtn').button('reset');
                        $('#messageNewSinister').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + returnedData.message + '</div>');
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
                    $('#newSinisterBtn').button('reset');
                    $('#messageNewSinister').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + xhr.responseText + '</div>');
                }
            });

            /*if(certificado) {
                e.preventDefault();
                $('#loader-icon').show();
                $('#newSinisterForm').ajaxSubmit({
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

    $("#cleanDataSinisterBtn").click(function() {
        //console.debug("clean");
        $("#newSinisterForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>