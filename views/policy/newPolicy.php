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
            <h4 class="modal-title">Nueva Poliza</h4>
        </div>
        <div class="modal-body">
            <!-- form start -->
            <form id="newPolicyForm" class="form-horizontal">
                <div class="box-body">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="compania">Compania *</label>
                        <div class="col-sm-9">
                            <select id="compania" class="form-control">
                                <?php foreach ($companias as $compania): ?>
                                    <option value="<?php echo $compania['ID_COMPANIA']; ?>"><?php echo utf8_encode($compania['NOMBRE']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="tipoPoliza">Tipo Poliza *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="tipoPoliza" type="text" placeholder="Tipo Poliza">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="numeroPoliza">Número Poliza *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="numeroPoliza" type="text" placeholder="Número Poliza">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="fechaInicio">Fecha Inicio *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="fechaInicio" type="text" placeholder="Fecha Inicio">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="fechaFin">Fecha Fin *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="fechaFin" type="text" placeholder="Fecha Fin">
                        </div>
                    </div>

                    <div id="messageNewPolicy" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataPolicyBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newPolicyBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $("#fechaInicio").val(moment().format('DD-MM-YYYY'));
    $("#fechaFin").val(moment().add('years', 1).format('DD-MM-YYYY'));

    $("#fechaInicio").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'DD-MM-YYYY',
        locale: {
            //format: 'DD-MM-YYYY',
            applyLabel: 'Aceptar',
            fromLabel: 'Desde',
            toLabel: 'Hasta',
            customRangeLabel: 'Rango Personalizado',
            daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi','Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            firstDay: 1
        }
    });

    $("#fechaFin").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'DD-MM-YYYY',
        locale: {
            //format: 'DD-MM-YYYY',
            applyLabel: 'Aceptar',
            fromLabel: 'Desde',
            toLabel: 'Hasta',
            customRangeLabel: 'Rango Personalizado',
            daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi','Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            firstDay: 1
        }
    });

    $('#newPolicyBtn').click(function(){
        var e = 'ajax.php?controller=Policy&action=createNewPolicy'; //console.debug(e);

        var tipoPoliza = $("#tipoPoliza").val(); //console.debug(tipoPoliza);
        var numeroPoliza = $("#numeroPoliza").val(); //console.debug(numeroPoliza);
        var idCompania = $("#compania").val(); //console.debug(idCompania);
        var fechaInicio = $("#fechaInicio").val(); //console.debug(idCompania);
        var fechaFin = $("#fechaFin").val(); //console.debug(idCompania);

        if(tipoPoliza === '' || numeroPoliza === '' || idCompania === '' || fechaInicio === '' || fechaFin === '')
        {
            $('#messageNewPolicy').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { tipoPoliza: tipoPoliza, numeroPoliza: numeroPoliza, idCompania: idCompania, fechaInicio: fechaInicio, fechaFin: fechaFin },
                dataType : "json",
                beforeSend: function () {
                    $('#newPolicyBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewPolicy').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newPolicyBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewPolicy').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newPolicyBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewPolicy').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newPolicyBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataPolicyBtn").click(function() {
        //console.debug("clean");
        $("#newPolicyForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>