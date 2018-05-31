<style>
    .form-group{
        padding: 15px;
    }
</style>

<div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar Solicitud de Certificado</h4>
        </div>
        <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
            <input id="idCertificadoSolicitud" value="<?php echo $certificadoSolicitud['ID_CERTIFICADO_SOLICITUD'] ?>" type="hidden">

            <div class="form-group">
                <label class="col-sm-3 control-label" for="idAsegurado">Asegurado *</label>
                <div class="col-sm-7">
                    <input type="text" id="buscadorAsegurado" class="form-control" placeholder="Ingresa el rut del asegurado">
                </div>
                <div class="col-sm-2">
                    <button id="btnBuscar" class="btn btn-default">Buscar</button>
                </div>
                <div class="col-sm-9 col-sm-offset-3" id="resultadoAsegurado">
                    <?php foreach ($asegurados as $asegurado): ?>
                        <?php if($asegurado['ID_ASEGURADO'] == $solicitudGarantia['ID_ASEGURADO']) { echo utf8_encode($asegurado['NOMBRE']); } ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <table id="tablaAsegurados" style="display: none;">
                <tbody class="buscar">
                <?php foreach ($asegurados as $asegurado): ?>
                    <tr>
                        <td class="identificadorAsegurado" data-nombre="<?php echo utf8_encode($asegurado['NOMBRE']); ?>"
                            data-identificador="<?php echo utf8_encode($asegurado['IDENTIFICADOR']); ?>"
                            data-idasegurado="<?php echo $asegurado['ID_ASEGURADO']; ?>">
                            <?php echo utf8_encode($asegurado['IDENTIFICADOR']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!--<div class="form-group">
                <label class="col-sm-4 control-label" for="idAsegurado">Asegurado *</label>
                <div class="col-sm-8">
                    <select id="idAsegurado" class="form-control">
                        <?php foreach ($asegurados as $asegurado): ?>
                            <option value="<?php echo $asegurado['ID_ASEGURADO']; ?>" <?php if($asegurado['ID_ASEGURADO'] == $certificadoSolicitud['ID_ASEGURADO']) { echo "selected"; } ?>><?php echo utf8_encode($asegurado['NOMBRE']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>-->

            <div class="form-group">
                <label class="col-sm-4 control-label" for="aFavorDe">A favor de *</label>
                <div class="col-sm-8">
                    <input class="form-control" id="aFavorDe" type="text" placeholder="A favor de" value="<?php echo $certificadoSolicitud['A_FAVOR_DE'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="idAsegurado">Transporte *</label>
                <div class="col-sm-8">
                    <select id="idPoliza" class="form-control">
                        <?php foreach ($polizas as $poliza): ?>
                            <option value="<?php echo $poliza['ID_POLIZA']; ?>" <?php if($poliza['ID_POLIZA'] == $certificadoSolicitud['ID_POLIZA']) { echo "selected"; } ?>><?php echo utf8_encode($poliza['TIPO_POLIZA']); ?></option>
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
                    <input class="form-control" id="origen" type="text" placeholder="Origen" value="<?php echo $certificadoSolicitud['ORIGEN'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="destino">Destino *</label>
                <div class="col-sm-8">
                    <input class="form-control" id="destino" type="text" placeholder="Destino" value="<?php echo $certificadoSolicitud['DESTINO'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="via">Via *</label>
                <div class="col-sm-8">
                    <input class="form-control" id="via" type="text" placeholder="Via" value="<?php echo $certificadoSolicitud['VIA'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="fechaEmbarque">Fecha de Embarque *</label>
                <div class="col-sm-8">
                    <input class="form-control" id="fechaEmbarque" type="text" placeholder="Fecha de Embarque" value="<?php echo $certificadoSolicitud['FECHA_EMBARQUE'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="transportista">Transportista *</label>
                <div class="col-sm-8">
                    <input class="form-control" id="transportista" type="text" placeholder="Transportista" value="<?php echo $certificadoSolicitud['TRANSPORTISTA'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="naveVueloCamion">Nave / Vuelo / Camión *</label>
                <div class="col-sm-8">
                    <input class="form-control" id="naveVueloCamion" type="text" placeholder="Nave / Vuelo / Camión" value="<?php echo $certificadoSolicitud['NAVE_VUELO_CAMION'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="blAwbCrt">B/L / AWB / CRT *</label>
                <div class="col-sm-8">
                    <input class="form-control" id="blAwbCrt" type="text" placeholder="B/L / AWB / CRT" value="<?php echo $certificadoSolicitud['BL_AWB_CRT'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="referenciaDespacho">Referencia / Despacho *</label>
                <div class="col-sm-8">
                    <input class="form-control" id="referenciaDespacho" type="text" placeholder="Referencia / Despacho" value="<?php echo $certificadoSolicitud['REFERENCIA_DESPACHO'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="idMateriaAsegurada">Materia Asegurada *</label>
                <div class="col-sm-8">
                    <select id="idMateriaAsegurada" class="form-control">
                        <?php foreach ($materiasAseguradas as $materiaAsegurada): ?>
                            <option value="<?php echo $materiaAsegurada['ID_MATERIA_ASEGURADA']; ?>" <?php if($materiaAsegurada['ID_MATERIA_ASEGURADA'] == $certificadoSolicitud['ID_MATERIA_ASEGURADA']) { echo "selected"; } ?>><?php echo utf8_encode($materiaAsegurada['MATERIA_ASEGURADA']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="idTipoMercaderia">Tipo de Mercadería *</label>
                <div class="col-sm-8">
                    <select id="idTipoMercaderia" class="form-control">
                        <?php foreach ($tipoMercaderias as $tipoMercaderia): ?>
                            <option value="<?php echo $tipoMercaderia['ID_TIPO_MERCADERIA']; ?>" <?php if($tipoMercaderia['ID_TIPO_MERCADERIA'] == $certificadoSolicitud['ID_TIPO_MERCADERIA']) { echo "selected"; } ?>><?php echo utf8_encode($tipoMercaderia['TIPO_MERCADERIA']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="detalleMercaderia">Detalle Mercaderia *</label>
                <div class="col-sm-8">
                    <input class="form-control" id="detalleMercaderia" type="text" placeholder="Detalle Mercaderia" value="<?php echo $certificadoSolicitud['DETALLE_MERCADERIA'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="idEmbalaje">Embalaje *</label>
                <div class="col-sm-8">
                    <select id="idEmbalaje" class="form-control">
                        <?php foreach ($embalajes as $embalaje): ?>
                            <option value="<?php echo $embalaje['ID_EMBALAJE']; ?>" <?php if($embalaje['ID_EMBALAJE'] == $certificadoSolicitud['ID_EMBALAJE']) { echo "selected"; } ?>><?php echo utf8_encode($embalaje['EMBALAJE']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="montoAseguradoCIF">Monto Asegurado *</label>
                <div class="col-sm-8">
                    <input class="form-control" id="montoAseguradoCIF" type="text" placeholder="Monto Asegurado" value="<?php echo $certificadoSolicitud['MONTO_ASEGURADO_CIF'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="tasa">Tasa *</label>
                <div class="col-sm-8">
                    <input class="form-control" id="tasa" type="text" placeholder="Tasa" value="<?php echo $certificadoSolicitud['TASA'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="primaMin">Prima Mín. *</label>
                <div class="col-sm-8">
                    <input class="form-control" id="primaMin" type="text" placeholder="Prima Mínima" value="<?php echo $certificadoSolicitud['PRIMA_MIN'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="primaSeguro">Prima de Seguro *</label>
                <div class="col-sm-8">
                    <input class="form-control" id="primaSeguro" type="text" placeholder="Prima de Seguro" value="<?php echo $certificadoSolicitud['PRIMA_SEGURO'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="observaciones">Observaciones</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="observaciones" placeholder="Observaciones"><?php echo $certificadoSolicitud['OBSERVACIONES'] ?></textarea>
                </div>
            </div>

            <br>
            <div id="messageEditCertificadoSolicitud"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            <!--<?php if ($certificadoSolicitud['HABILITADO'] == 1) { ?>
                <button type="button" class="btn btn-primary" id="toggleDesactivar">Desactivar</button>
            <?php } else if ($certificadoSolicitud['HABILITADO'] == 0) { ?>
                <button type="button" class="btn btn-primary" id="toggleActivar">Activar</button>
            <?php } ?>-->

            <button id="saveCertificadoSolicitudEdit" type="button" class="btn btn-primary">Guardar</button>

        </div>
    </div>
</div>

<script type="application/javascript">

    var idAseguradoSeleccionado = "";

    $('#btnBuscar').click(function () {
        var nombreAsegurado = "";
        var identificadorAsegurado = "";
        var textoAbuscar = $('#buscadorAsegurado').val();

        var rex = new RegExp(textoAbuscar, 'i'); //console.log(rex);
        var i = 0;
        var filtro = $('.identificadorAsegurado').filter(function () {

            if(rex.test($(this).text()) === true)
            {
                nombreAsegurado = $(this).data("nombre"); //console.log($(this).data("nombre"));
                identificadorAsegurado = $(this).data("identificador");
                idAseguradoSeleccionado = $(this).data("idasegurado");
                i = i +1;
            }

            if(i > 1)
            {
                nombreAsegurado = "";
                identificadorAsegurado = "No hay un resultado único a esta búsqueda.";
            }

            return "";
        });

        $('#resultadoAsegurado').html(identificadorAsegurado + " " + nombreAsegurado);

        return false;

    });

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

    $('#saveCertificadoSolicitudEdit').click(function(){
        var e = 'ajax.php?controller=Certificate&action=certificateRequestEdit2db';

        var idCertificadoSolicitud = $("#idCertificadoSolicitud").val(); console.log(idCertificadoSolicitud);
        //var idAsegurado = $("#idAsegurado").val();
        var idAsegurado = idAseguradoSeleccionado;
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

        if(idAsegurado == '' || idTipoMercaderia == '' || aFavorDe == '' || tipo == '' || origen == ''
            || destino == '' || via == '' || fechaEmbarque == '' || transportista == '' || naveVueloCamion == '' || blAwbCrt == ''
            || referenciaDespacho == '' || idMateriaAsegurada == '' || detalleMercaderia == '' || idEmbalaje == '' || montoAseguradoCIF == ''
            || tasa == '' || primaMin == '' || primaSeguro == '')
        {
            $('#messageEditCertificadoSolicitud').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { idCertificadoSolicitud: idCertificadoSolicitud, idAsegurado: idAsegurado, idTipoMercaderia: idTipoMercaderia, idPoliza: idPoliza, aFavorDe: aFavorDe, tipo: tipo, origen: origen, destino: destino,
                    via: via, fechaEmbarque: fechaEmbarque, transportista: transportista, naveVueloCamion: naveVueloCamion, blAwbCrt: blAwbCrt, referenciaDespacho: referenciaDespacho,
                    idMateriaAsegurada: idMateriaAsegurada, detalleMercaderia: detalleMercaderia, idEmbalaje: idEmbalaje, montoAseguradoCIF: montoAseguradoCIF, tasa: tasa,
                    primaMin: primaMin, primaSeguro: primaSeguro, observaciones: observaciones },
                dataType : "json",
                beforeSend: function () {
                    $('#saveCertificadoSolicitudEdit').html("Cargando...");
                },
                success: function (data) {
                    console.debug("success");
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        console.debug("success");
                        $('#messageEditCertificadoSolicitud').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#saveCertificadoSolicitudEdit').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                        $('#modalPrincipal').hide();
                        window.location.reload(true);
                    }
                    else{
                        console.debug("fail");
                        $('#saveCertificadoSolicitudEdit').html("Guardar");
                        $('#messageEditCertificadoSolicitud').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    }
                },
                error: function (data) {
                    console.debug("error");
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#saveCertificadoSolicitudEdit').html("Guardar");
                    $('#messageEditCertificadoSolicitud').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                }
            });
        }

    });

</script>