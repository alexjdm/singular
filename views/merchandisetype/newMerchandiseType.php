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
            <h4 class="modal-title">Nuevo Tipo de Mercadería</h4>
        </div>
        <div class="modal-body">
            <!-- form start -->
            <form id="newMerchandiseTypeForm" class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="tipoMercaderia">Tipo de Mercadería *</label>
                        <div class="col-sm-6">
                            <input class="form-control" id="tipoMercaderia" type="text" placeholder="Tipo de Mercadería">
                        </div>
                    </div>

                    <div id="messageNewMerchandiseType" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataMerchandiseTypeBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newMerchandiseTypeBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $('#newMerchandiseTypeBtn').click(function(){
        var e = 'ajax.php?controller=MerchandiseType&action=createNewMerchandiseType'; console.debug(e);

        var tipoMercaderia = $("#tipoMercaderia").val(); console.debug(tipoMercaderia);

        if(tipoMercaderia == '')
        {
            $('#messageNewMerchandiseType').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { tipoMercaderia: tipoMercaderia },
                dataType : "json",
                beforeSend: function () {
                    $('#newMerchandiseTypeBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewMerchandiseType').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newMerchandiseTypeBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewMerchandiseType').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newMerchandiseTypeBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewMerchandiseType').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newMerchandiseTypeBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataMerchandiseTypeBtn").click(function() {
        console.debug("clean");
        $("#newMerchandiseTypeForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>