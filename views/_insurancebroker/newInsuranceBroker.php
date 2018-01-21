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

<div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nueva Corredora</h4>
        </div>
        <div class="modal-body">
            <!-- form start -->
            <form id="newInsuranceBrokerForm" class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="rut">RUT</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="rut" type="text" placeholder="RUT">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="nombre">Nombre *</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="nombre" type="text" placeholder="Nombre">
                        </div>
                    </div>

                    <div id="messageNewInsuranceBroker" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataInsuranceBrokerBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newInsuranceBrokerBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $('#newInsuranceBrokerBtn').click(function(){
        var e = 'ajax.php?controller=InsuranceBroker&action=createNewInsuranceBroker'; console.debug(e);

        var rut = $("#rut").val(); console.debug(rut);
        var nombre = $("#nombre").val(); console.debug(nombre);

        if(rut == '' || nombre == '')
        {
            $('#messageNewInsuranceBroker').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { rut:rut, nombre: nombre },
                dataType : "json",
                beforeSend: function () {
                    $('#newInsuranceBrokerBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewInsuranceBroker').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newInsuranceBrokerBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewInsuranceBroker').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newInsuranceBrokerBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewInsuranceBroker').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newInsuranceBrokerBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataInsuranceBrokerBtn").click(function() {
        console.debug("clean");
        $("#newInsuranceBrokerForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>