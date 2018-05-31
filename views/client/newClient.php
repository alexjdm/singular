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
            <h4 class="modal-title">Nuevo Cliente</h4>
        </div>
        <div class="modal-body">
            <!-- form start -->
            <form id="newClientForm" class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="rut">Rut *</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="rut" type="text" placeholder="Rut">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="nombre">Nombre *</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="nombre" type="text" placeholder="Nombre">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="direccion">Dirección</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="direccion" type="direccion" placeholder="Dirección">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="ciudad">Ciudad</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="ciudad" type="text" placeholder="Ciudad">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="telefono">Teléfono</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="telefono" type="text" placeholder="Teléfono">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="giro">Giro</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="giro" type="text" placeholder="Giro">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="razonSocial">Razón Social</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="razonSocial" type="text" placeholder="Razón Social">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="tasa">Tasa</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="tasa" type="text" placeholder="Tasa">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="primaMin">Prima Mínima</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="primaMin" type="text" placeholder="Prima Mínima">
                        </div>
                    </div>

                    <div id="messageNewClient" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataClientBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newClientBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $('#newClientBtn').click(function(){
        var e = 'ajax.php?controller=Client&action=createNewClient'; console.debug(e);

        var nombre = $("#nombre").val(); //console.debug(nombre);
        var rut = $("#rut").val(); //console.debug(rut);
        var direccion = $("#direccion").val(); //console.debug(direccion);
        var ciudad = $("#ciudad").val(); //console.debug(ciudad);
        var telefono = $("#telefono").val(); //console.debug(telefono);
        var giro = $("#giro").val();
        var razonSocial = $("#razonSocial").val();
        var tasa = $("#tasa").val();
        var primaMin = $("#primaMin").val();

        if(nombre == '' && rut == '')
        {
            $('#messageNewClient').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { nombre: nombre, rut:rut, direccion: direccion, ciudad: ciudad, telefono: telefono, giro: giro, razonSocial: razonSocial, tasa: tasa, primaMin: primaMin },
                dataType : "json",
                beforeSend: function () {
                    $('#newClientBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewClient').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newClientBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewClient').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newClientBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewClient').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newClientBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataClientBtn").click(function() {
        console.debug("clean");
        $("#newClientForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>