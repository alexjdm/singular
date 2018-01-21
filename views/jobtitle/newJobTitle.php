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
            <h4 class="modal-title">Nuevo Cargo</h4>
        </div>
        <div class="modal-body">
            <!-- form start -->
            <form id="newJobTitleForm" class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="nombre">Nombre *</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="nombre" type="text" placeholder="Nombre">
                        </div>
                    </div>

                    <div id="messageNewJobTitle" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataJobTitleBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newJobTitleBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $('#newJobTitleBtn').click(function(){
        var e = 'ajax.php?controller=JobTitle&action=createNewJobTitle'; console.debug(e);

        var nombre = $("#nombre").val(); console.debug(nombre);

        if(nombre == '')
        {
            $('#messageNewJobTitle').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { nombre: nombre },
                dataType : "json",
                beforeSend: function () {
                    $('#newJobTitleBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewJobTitle').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newJobTitleBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewJobTitle').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newJobTitleBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewJobTitle').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newJobTitleBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataJobTitleBtn").click(function() {
        console.debug("clean");
        $("#newJobTitleForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>