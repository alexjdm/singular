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
            <h4 class="modal-title">Nuevo Asegurado</h4>
        </div>
        <div class="modal-body">
            <!-- form start -->
            <form id="newInsuredForm" class="form-horizontal">
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
                        <label class="col-sm-2 control-label" for="giro">Giro</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="giro" type="text" placeholder="Giro">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="region">Región</label>
                        <div class="col-sm-10">
                            <select id="region" class="form-control">
                                <?php foreach ($regiones as $region): ?>
                                    <option value="<?php echo $region['ID_REGION']; ?>"><?php echo utf8_encode($region['NOMBRE']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="comuna">Comuna</label>
                        <div class="col-sm-10">
                            <select id="comuna" class="form-control">
                                <?php foreach ($comunas as $comuna): ?>
                                    <option value="<?php echo $comuna['ID_COMUNA']; ?>"><?php echo utf8_encode($comuna['NOMBRE']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="direccion">Dirección</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="direccion" type="direccion" placeholder="Dirección">
                        </div>
                    </div>

                    <div id="messageNewInsured" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataInsuredBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newInsuredBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $('#newInsuredBtn').click(function(){
        var e = 'ajax.php?controller=Insured&action=createNewInsured'; console.debug(e);

        var rut = $("#rut").val(); console.debug(rut);
        var nombre = $("#nombre").val(); console.debug(nombre);
        var giro = $("#giro").val(); console.debug(giro);
        var idRegion = $("#region").val(); console.debug(idRegion);
        var idComuna = $("#comuna").val(); console.debug(idComuna);
        var direccion = $("#direccion").val(); console.debug(direccion);

        if(nombre == '' && rut == '')
        {
            $('#messageNewInsured').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { nombre: nombre, rut:rut, giro: giro, idRegion: idRegion, idComuna: idComuna, direccion: direccion},
                dataType : "json",
                beforeSend: function () {
                    $('#newInsuredBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewInsured').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newInsuredBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewInsured').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newInsuredBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewInsured').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newInsuredBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataInsuredBtn").click(function() {
        console.debug("clean");
        $("#newInsuredForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>