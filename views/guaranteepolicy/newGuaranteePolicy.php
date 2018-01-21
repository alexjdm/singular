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
            <h4 class="modal-title">Nueva Solicitud de Garantía</h4>
        </div>
        <div class="modal-body">
            <!-- form start -->
            <form id="newGuaranteePolicyForm" class="form-horizontal">
                <div class="box-body">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="asegurado">Asegurado *</label>
                        <div class="col-sm-9">
                            <select id="asegurado" class="form-control">
                                <?php foreach ($asegurados as $asegurado): ?>
                                    <option value="<?php echo $asegurado['ID_ASEGURADO']; ?>"><?php echo utf8_encode($asegurado['NOMBRE']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="tipoMercaderia">Tipo de Mercadería *</label>
                        <div class="col-sm-9">
                            <select id="tipoMercaderia" class="form-control">
                                <?php foreach ($tipoMercaderias as $tipoMercaderia): ?>
                                    <option value="<?php echo $tipoMercaderia['ID_TIPO_MERCADERIA']; ?>"><?php echo utf8_encode($tipoMercaderia['TIPO_MERCADERIA']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="corredora">Corredora *</label>
                        <div class="col-sm-9">
                            <select id="corredora" class="form-control">
                                <?php foreach ($corredoras as $corredora): ?>
                                    <option value="<?php echo $corredora['ID_CORREDORA']; ?>"><?php echo utf8_encode($corredora['NOMBRE']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="embalaje">Embalaje *</label>
                        <div class="col-sm-9">
                            <select id="embalaje" class="form-control">
                                <?php foreach ($embalajes as $embalaje): ?>
                                    <option value="<?php echo $embalaje['ID_EMBALAJE']; ?>"><?php echo utf8_encode($embalaje['EMBALAJE']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="direccion">Dirección *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="direccion" type="text" placeholder="Dirección">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="fechaInicio">Fecha Inicio *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="fechaInicio" type="text" placeholder="Fecha Inicio">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="plazo">Plazo *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="plazo" type="text" placeholder="Plazo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="montoCIF">Monto CIF *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="montoCIF" type="text" placeholder="Monto CIF">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="derechos">Derechos *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="derechos" type="text" placeholder="Derechos">
                        </div>
                    </div>
                    
                    <div id="messageNewGuaranteePolicy" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataGuaranteePolicyBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newGuaranteePolicyBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $("#fechaInicio").val(moment().format('DD-MM-YYYY'));

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

    $('#newGuaranteePolicyBtn').click(function(){
        var e = 'ajax.php?controller=GuaranteePolicy&action=createNewGuaranteePolicy'; console.debug(e);

        var idAsegurado = $("#asegurado").val(); //console.debug(idAsegurado);
        var idTipoMercaderia = $("#tipoMercaderia").val(); //console.debug(idTipoMercaderia);
        var idCorredora = $("#corredora").val();
        var embalaje = $("#embalaje").val();
        var direccion = $("#direccion").val();
        var fechaInicio = $("#fechaInicio").val();
        var plazo = $("#plazo").val();
        var montoCIF = $("#montoCIF").val();
        var derechos = $("#derechos").val();

        if(idAsegurado == '' || idTipoMercaderia == '' || idCorredora == '' || embalaje == '' || direccion == ''
        || fechaInicio == '' || plazo == '' || montoCIF == '' || derechos == '')
        {
            $('#messageNewGuaranteePolicy').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { idAsegurado: idAsegurado, idTipoMercaderia: idTipoMercaderia, idCorredora: idCorredora, embalaje: embalaje, direccion: direccion, fechaInicio: fechaInicio, plazo: plazo, montoCIF: montoCIF, derechos: derechos },
                dataType : "json",
                beforeSend: function () {
                    $('#newGuaranteePolicyBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewGuaranteePolicy').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newGuaranteePolicyBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewGuaranteePolicy').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newGuaranteePolicyBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewGuaranteePolicy').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newGuaranteePolicyBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataGuaranteePolicyBtn").click(function() {
        //console.debug("clean");
        $("#newGuaranteePolicyForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>