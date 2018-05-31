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

<div class="modal-dialog" style="width:75%">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nueva Solicitud de Certificado</h4>
        </div>
        <div class="modal-body">

            <div id="sinData" style="display: none;">
                <h4 class="text-center" id="infoSinData"></h4>
            </div>

            <!-- form start -->
            <form id="newCertificateRequestForm" class="form-horizontal">
                <div class="box-body">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="idAsegurado">Asegurado *</label>
                                <div class="col-sm-8">
                                    <select id="idAsegurado" class="form-control">
                                        <?php foreach ($asegurados as $asegurado): ?>
                                            <option value="<?php echo $asegurado['ID_ASEGURADO']; ?>"><?php echo utf8_encode($asegurado['NOMBRE']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="aFavorDe">A favor de *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="aFavorDe" type="text" placeholder="A favor de">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="idAsegurado">Transporte *</label>
                                <div class="col-sm-8">
                                    <select id="idPoliza" class="form-control">
                                        <?php foreach ($polizas as $poliza): ?>
                                            <option value="<?php echo $poliza['ID_POLIZA']; ?>"><?php echo utf8_encode($poliza['TIPO_POLIZA']) . " (" . $poliza['NUMERO'] . ")"; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="idAsegurado">Tipo *</label>
                                <div class="col-sm-8">
                                    <select id="tipo" class="form-control">
                                        <option value="Importacion">Importacion</option>
                                        <option value="Exportacion">Exportacion</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="origen">Origen *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="origen" type="text" placeholder="Origen">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="destino">Destino *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="destino" type="text" placeholder="Destino">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="via">Via *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="via" type="text" placeholder="Via">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="fechaEmbarque">Fecha de Embarque *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="fechaEmbarque" type="text" placeholder="Fecha de Embarque">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="transportista">Transportista *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="transportista" type="text" placeholder="Transportista">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="naveVueloCamion">Nave / Vuelo / Camión *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="naveVueloCamion" type="text" placeholder="Nave / Vuelo / Camión">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="blAwbCrt">B/L / AWB / CRT *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="blAwbCrt" type="text" placeholder="B/L / AWB / CRT">
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="referenciaDespacho">Referencia / Despacho *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="referenciaDespacho" type="text" placeholder="Referencia / Despacho">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="idMateriaAsegurada">Materia Asegurada *</label>
                                <div class="col-sm-8">
                                    <select id="idMateriaAsegurada" class="form-control">
                                        <?php foreach ($materiasAseguradas as $materiaAsegurada): ?>
                                            <option value="<?php echo $materiaAsegurada['ID_MATERIA_ASEGURADA']; ?>"><?php echo utf8_encode($materiaAsegurada['MATERIA_ASEGURADA']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="idTipoMercaderia">Tipo de Mercadería *</label>
                                <div class="col-sm-8">
                                    <select id="idTipoMercaderia" class="form-control">
                                        <?php foreach ($tipoMercaderias as $tipoMercaderia): ?>
                                            <option value="<?php echo $tipoMercaderia['ID_TIPO_MERCADERIA']; ?>"><?php echo utf8_encode($tipoMercaderia['TIPO_MERCADERIA']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="detalleMercaderia">Detalle Mercaderia *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="detalleMercaderia" type="text" placeholder="Detalle Mercaderia">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="idEmbalaje">Embalaje *</label>
                                <div class="col-sm-8">
                                    <select id="idEmbalaje" class="form-control">
                                        <?php foreach ($embalajes as $embalaje): ?>
                                            <option value="<?php echo $embalaje['ID_EMBALAJE']; ?>"><?php echo utf8_encode($embalaje['EMBALAJE']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="montoAseguradoCIF">Monto Asegurado *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="montoAseguradoCIF" type="text" placeholder="Monto Asegurado">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="tasa">Tasa *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="tasa" type="text" placeholder="Tasa" value="<?php echo $corredora['TASA'] ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="primaMin">Prima Mín. *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="primaMin" type="text" placeholder="Prima Mínima" value="<?php echo $corredora['PRIMA_MIN'] ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="primaSeguro">Prima de Seguro *</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="primaSeguro" type="text" placeholder="Prima de Seguro" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="observaciones">Observaciones</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="observaciones" type="text" placeholder="Observaciones"></textarea>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div id="messageNewCertificateRequest" style="margin: 20px;"></div>
                    </div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataCertificateRequestBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newCertificateRequestBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">
    
    function calcularPrimaDeSeguro() {
        var tasa = parseFloat($('#tasa').val().replace(',','.').replace(' ',''));
        var primaMin = parseFloat($('#primaMin').val());
        var montoCIF = parseFloat($('#montoAseguradoCIF').val());
        if(tasa > 0 && primaMin > 0 && montoCIF > 0)
        {
            var primaSeguro = montoCIF * tasa < primaMin ? primaMin : montoCIF * tasa / 100;

            $('#primaSeguro').val(primaSeguro);
        }
        else {
            $('#primaSeguro').val("0");
        }
    }

    $('#montoAseguradoCIF').keyup(function () {
        calcularPrimaDeSeguro();
    });

    $('#tasa').keyup(function () {
        calcularPrimaDeSeguro();
    });

    $('#primaMin').keyup(function () {
        calcularPrimaDeSeguro();
    });

    <?php if(count($tipoMercaderias) == 0 || count($polizas) == 0 || count($materiasAseguradas) == 0 || count($embalajes) == 0) { ?>
    $('#newCertificateRequestForm').hide();
    $('#newCertificateRequestBtn').hide();
    $('#cleanDataCertificateRequestBtn').hide();

    <?php if(count($tipoMercaderias) == 0): ?>
    $('#sinData').append("Debes agregar tipos de mercarias. ");
    <?php endif; ?>
    <?php if (count($polizas) == 0): ?>
    $('#sinData').append("Debes agregar idPolizas. ");
    <?php endif; ?>
    <?php if (count($materiasAseguradas) == 0): ?>
    $('#sinData').html("Debes agregar materias a asegurar. ");
    <?php endif; ?>
    <?php if (count($embalajes) == 0): ?>
    $('#sinData').html("Debes agregar embalajes. ");
    <?php endif; ?>

    $('#sinData').show();
    <?php } ?>

    $("#fechaEmbarque").val(moment().format('DD-MM-YYYY'));

    $("#fechaEmbarque").daterangepicker({
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

    $('#newCertificateRequestBtn').click(function(){
        var e = 'ajax.php?controller=Certificate&action=createNewCertificateRequest'; //console.debug(e);

        //var idCertificadoSolicitud = $("#idCertificadoSolicitud").val();
        var idAsegurado = $("#idAsegurado").val();
        var idTipoMercaderia = $("#idTipoMercaderia").val();
        var idPoliza = $("#idPoliza").val();
        var aFavorDe = $("#aFavorDe").val();
        var tipo = $("#tipo").val();
        var origen = $("#origen").val();
        var destino = $("#destino").val();
        var via = $("#via").val();
        var fechaEmbarque = $("#fechaEmbarque").val();
        var transportista = $("#transportista").val();
        var naveVueloCamion = $("#naveVueloCamion").val();
        var blAwbCrt = $("#blAwbCrt").val();
        var referenciaDespacho = $("#referenciaDespacho").val();
        var idMateriaAsegurada = $("#idMateriaAsegurada").val();
        var detalleMercaderia = $("#detalleMercaderia").val();
        var idEmbalaje = $("#idEmbalaje").val();
        var montoAseguradoCIF = $("#montoAseguradoCIF").val();
        var tasa = $("#tasa").val();
        var primaMin = $("#primaMin").val();
        var primaSeguro = $("#primaSeguro").val();
        var observaciones = $("#observaciones").val();

        if(idAsegurado === '' || idTipoMercaderia === '' || aFavorDe === '' || tipo === '' || origen === ''
            || destino === '' || via === '' || fechaEmbarque === '' || transportista === '' || naveVueloCamion === '' || blAwbCrt === ''
            || referenciaDespacho === '' || idMateriaAsegurada === '' || detalleMercaderia === '' || idEmbalaje === '' || montoAseguradoCIF === ''
            || tasa === '' || primaMin === '' || primaSeguro === '')
        {
            $('#messageNewCertificateRequest').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { idAsegurado: idAsegurado, idTipoMercaderia: idTipoMercaderia, idPoliza: idPoliza, aFavorDe: aFavorDe, tipo: tipo, origen: origen, destino: destino,
                    via: via, fechaEmbarque: fechaEmbarque, transportista: transportista, naveVueloCamion: naveVueloCamion, blAwbCrt: blAwbCrt, referenciaDespacho: referenciaDespacho,
                    idMateriaAsegurada: idMateriaAsegurada, detalleMercaderia: detalleMercaderia, idEmbalaje: idEmbalaje, montoAseguradoCIF: montoAseguradoCIF, tasa: tasa,
                    primaMin: primaMin, primaSeguro: primaSeguro, observaciones: observaciones },
                dataType : "json",
                beforeSend: function () {
                    $('#newCertificateRequestBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewCertificateRequest').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newCertificateRequestBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewCertificateRequest').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newCertificateRequestBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewCertificateRequest').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newCertificateRequestBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataCertificateRequestBtn").click(function() {
        //console.debug("clean");
        $("#newCertificateRequestForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>