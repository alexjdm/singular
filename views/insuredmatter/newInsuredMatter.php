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
            <h4 class="modal-title">Nueva Materia Asegurada</h4>
        </div>
        <div class="modal-body">
            <!-- form start -->
            <form id="newInsuredMatterForm" class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="materiaAsegurada">Materia Asegurada *</label>
                        <div class="col-sm-6">
                            <input class="form-control" id="materiaAsegurada" type="text" placeholder="Materia Asegurada">
                        </div>
                    </div>

                    <div id="messageNewInsuredMatter" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataInsuredMatterBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newInsuredMatterBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $('#newInsuredMatterBtn').click(function(){
        var e = 'ajax.php?controller=InsuredMatter&action=createNewInsuredMatter'; //console.debug(e);

        var materiaAsegurada = $("#materiaAsegurada").val(); //console.debug(materiaAsegurada);

        if(materiaAsegurada == '')
        {
            $('#messageNewInsuredMatter').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { materiaAsegurada: materiaAsegurada },
                dataType : "json",
                beforeSend: function () {
                    $('#newInsuredMatterBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewInsuredMatter').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newInsuredMatterBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewInsuredMatter').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newInsuredMatterBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewInsuredMatter').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newInsuredMatterBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataInsuredMatterBtn").click(function() {
        console.debug("clean");
        $("#newInsuredMatterForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>