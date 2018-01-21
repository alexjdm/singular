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
            <h4 class="modal-title">Nuevo Siniestro</h4>
        </div>
        <div class="modal-body">
            <!-- form start -->
            <form id="newSinisterForm" class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="poliza">Poliza *</label>
                        <div class="col-sm-10">
                            <select id="poliza" class="form-control">
                                <?php foreach ($seguros as $seguro): ?>
                                    <option value="<?php echo $seguro['ID_SEGURO']; ?>"><?php echo utf8_encode($seguro['POLIZA']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="certificado">Certificado</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="certificado" type="text" placeholder="Certificado" readonly>
                        </div>
                    </div>

                    <div id="messageNewSinister" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataSinisterBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newSinisterBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $('#newSinisterBtn').click(function(){
        var e = 'ajax.php?controller=Sinister&action=createNewSinister'; console.debug(e);

        var nombre = $("#nombre").val(); console.debug(nombre);

        if(nombre == '')
        {
            $('#messageNewSinister').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { nombre: nombre },
                dataType : "json",
                beforeSend: function () {
                    $('#newSinisterBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewSinister').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newSinisterBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewSinister').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newSinisterBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewSinister').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newSinisterBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataSinisterBtn").click(function() {
        console.debug("clean");
        $("#newSinisterForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>