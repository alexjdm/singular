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
            <h4 class="modal-title">Nueva Compañia</h4>
        </div>
        <div class="modal-body">
            <!-- form start -->
            <form id="newCompanyForm" class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="nombre">Nombre *</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="nombre" type="text" placeholder="Nombre">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="tasa">Tasa</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="tasa" type="text" placeholder="Tasa">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="prima_minima">Prima Mínima</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="prima_minima" type="prima_minima" placeholder="Prima Mínima">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="limite_embarque">Límite Embarque</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="limite_embarque" type="text" placeholder="Límite Embarque">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="tipo_cuenta">Tipo de Cuenta</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="tipo_cuenta" type="text" placeholder="Tipo de Cuenta">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="comision">Comisión</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="comision" type="text" placeholder="Comisión">
                        </div>
                    </div>

                    <div id="messageNewCompany" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataCompanyBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newCompanyBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $('#newCompanyBtn').click(function(){
        var e = 'ajax.php?controller=Company&action=createNewCompany'; console.debug(e);

        var nombre = $("#nombre").val(); console.debug(nombre);
        var tasa = $("#tasa").val(); console.debug(tasa);
        var prima_minima = $("#prima_minima").val(); console.debug(prima_minima);
        var limite_embarque = $("#limite_embarque").val(); console.debug(limite_embarque);
        var tipo_cuenta = $("#tipo_cuenta").val(); console.debug(tipo_cuenta);
        var comision = $("#comision").val(); console.debug(comision);

        if(nombre == '')
        {
            $('#messageNewCompany').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { nombre: nombre, tasa:tasa, prima_minima: prima_minima, limite_embarque: limite_embarque, tipo_cuenta: tipo_cuenta, comision: comision},
                dataType : "json",
                beforeSend: function () {
                    $('#newCompanyBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewCompany').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newCompanyBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewCompany').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newCompanyBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewCompany').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newCompanyBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataCompanyBtn").click(function() {
        console.debug("clean");
        $("#newCompanyForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>