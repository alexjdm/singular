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
            <h4 class="modal-title">Nuevo Embalaje</h4>
        </div>
        <div class="modal-body">
            <!-- form start -->
            <form id="newPackingForm" class="form-horizontal">
                <div class="box-body">

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="poliza">Poliza *</label>
                        <div class="col-sm-6">
                            <select id="poliza" class="form-control">
                                <?php foreach ($polizas as $poliza): ?>
                                    <option value="<?php echo $poliza['ID_POLIZA']; ?>"><?php echo utf8_encode($poliza['TIPO_POLIZA'] . " (" . $poliza['NUMERO'] . ")"); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="embalaje">Embalaje *</label>
                        <div class="col-sm-6">
                            <input class="form-control" id="embalaje" type="text" placeholder="Embalaje">
                        </div>
                    </div>

                    <div id="messageNewPacking" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataPackingBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newPackingBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $('#newPackingBtn').click(function(){
        var e = 'ajax.php?controller=Packing&action=createNewPacking'; console.debug(e);

        var idPoliza = $('#poliza').val();
        var embalaje = $("#embalaje").val(); console.debug(embalaje);

        if(embalaje === '' || idPoliza === '')
        {
            $('#messageNewPacking').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { embalaje: embalaje, idPoliza: idPoliza },
                dataType : "json",
                beforeSend: function () {
                    $('#newPackingBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status === "success"){
                        $('#messageNewPacking').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newPackingBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewPacking').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newPackingBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewPacking').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newPackingBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataPackingBtn").click(function() {
        console.debug("clean");
        $("#newPackingForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>