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
            <h4 class="modal-title">Nuevo Medio</h4>
        </div>
        <div class="modal-body">
            <!-- form start -->
            <form id="newMedioForm" class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="nombre">Nombre *</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="nombre" type="text" placeholder="Nombre">
                        </div>
                    </div>

                    <div id="messageNewMedio" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataMedioBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newMedioBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $('#newMedioBtn').click(function(){
        var e = 'ajax.php?controller=Medio&action=createNewMedio'; console.debug(e);

        var nombre = $("#nombre").val(); console.debug(nombre);

        if(nombre == '')
        {
            $('#messageNewMedio').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { nombre: nombre },
                dataType : "json",
                beforeSend: function () {
                    $('#newMedioBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewMedio').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newMedioBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewMedio').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newMedioBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewMedio').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newMedioBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataMedioBtn").click(function() {
        console.debug("clean");
        $("#newMedioForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>