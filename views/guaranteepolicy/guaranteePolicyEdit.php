<style>
    .form-group{
        padding: 15px;
    }
</style>

<div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar Solicitud de Garantía</h4>
        </div>
        <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
            <input id="idGarantia" value="<?php echo $solicitudGarantia['ID_GARANTIA'] ?>" type="hidden">

            <div class="form-group">
                <label class="col-sm-3 control-label" for="idAsegurado">Asegurado *</label>
                <div class="col-sm-7">
                    <input type="text" id="buscadorAsegurado" class="form-control" placeholder="Ingresa el rut del asegurado" value="<?php echo utf8_encode($aseguradoSel['IDENTIFICADOR']); ?>">
                </div>
                <div class="col-sm-2">
                    <button id="btnBuscar" class="btn btn-default">Buscar</button>
                </div>
                <div class="col-sm-9 col-sm-offset-3" id="resultadoAsegurado">
                    <?php echo utf8_encode($aseguradoSel['NOMBRE']); ?>
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
                <label class="col-sm-3 control-label" for="asegurado">Asegurado *</label>
                <div class="col-sm-9">
                    <select id="asegurado" class="form-control">
                        <?php foreach ($asegurados as $asegurado): ?>
                            <option value="<?php echo $asegurado['ID_ASEGURADO']; ?>" <?php if($asegurado['ID_ASEGURADO'] == $solicitudGarantia['ID_ASEGURADO']) { echo "selected"; } ?>><?php echo utf8_encode($asegurado['NOMBRE']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="tipoMercaderia">Tipo de Mercadería *</label>
                <div class="col-sm-9">
                    <select id="tipoMercaderia" class="form-control">
                        <?php foreach ($tipoMercaderias as $tipoMercaderia): ?>
                            <option value="<?php echo $tipoMercaderia['ID_TIPO_MERCADERIA']; ?>" <?php if($tipoMercaderia['ID_TIPO_MERCADERIA'] == $solicitudGarantia['ID_TIPO_MERCADERIA']) { echo "selected"; } ?>><?php echo utf8_encode($tipoMercaderia['TIPO_MERCADERIA']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="embalaje">Embalaje *</label>
                <div class="col-sm-9">
                    <select id="embalaje" class="form-control">
                        <?php foreach ($embalajes as $embalaje): ?>
                            <option value="<?php echo $embalaje['ID_EMBALAJE']; ?>" <?php if($embalaje['ID_EMBALAJE'] == $solicitudGarantia['ID_EMBALAJE']) { echo "selected"; } ?>><?php echo utf8_encode($embalaje['EMBALAJE']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>-->

            <div class="form-group">
                <label class="col-sm-3 control-label" for="tipoMercaderia">Tipo de Mercadería *</label>
                <div class="col-sm-9">
                    <input class="form-control" id="tipoMercaderia" type="text" placeholder="Ingrese el tipo de mercadería" value="<?php echo $solicitudGarantia['TIPO_MERCADERIA'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="embalaje">Embalaje *</label>
                <div class="col-sm-9">
                    <input class="form-control" id="embalaje" type="text" placeholder="Embalaje" value="<?php echo $solicitudGarantia['EMBALAJE'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="direccion">Dirección *</label>
                <div class="col-sm-9">
                    <input class="form-control" id="direccion" type="text" placeholder="Dirección" value="<?php echo utf8_encode($solicitudGarantia['DIRECCION']); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="fechaInicio">Fecha Inicio *</label>
                <div class="col-sm-9">
                    <input class="form-control" id="fechaInicio" type="text" placeholder="Fecha Inicio" value="<?php echo utf8_encode($solicitudGarantia['FECHA_INICIO']); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="plazo">Plazo *</label>
                <div class="col-sm-9">
                    <input class="form-control" id="plazo" type="text" placeholder="Ingrese el plazo en días" value="<?php echo utf8_encode($solicitudGarantia['PLAZO']); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="montoCIF">Monto CIF *</label>
                <div class="col-sm-9">
                    <input class="form-control" id="montoCIF" type="text" placeholder="Monto CIF" value="<?php echo utf8_encode($solicitudGarantia['MONTO_CIF']); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="derechos">Derechos *</label>
                <div class="col-sm-9">
                    <input class="form-control" id="derechos" type="text" placeholder="Derechos" readonly value="<?php echo utf8_encode($solicitudGarantia['DERECHOS']); ?>">
                </div>
            </div>

            <br>
            <div id="messageEditGuaranteePolicy"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="saveGuaranteePolicyEdit" type="button" class="btn btn-primary">Guardar</button>

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

        //$('#resultadoAsegurado').html(identificadorAsegurado + " " + nombreAsegurado);
        $('#resultadoAsegurado').html(nombreAsegurado);

        return false;

    });

    $('#btnBuscar').trigger("click");

    $('#saveGuaranteePolicyEdit').click(function(){
        var e = 'ajax.php?controller=GuaranteePolicy&action=guaranteePolicyEdit2db';
        var idGarantia = $("#idGarantia").val();
        //var idAsegurado = $("#asegurado").val(); //console.debug(idAsegurado);
        var idAsegurado = idAseguradoSeleccionado;
        var tipoMercaderia = $("#tipoMercaderia").val(); //console.debug(tipoMercaderia);
        var embalaje = $("#embalaje").val();
        var direccion = $("#direccion").val();
        var fechaInicio = $("#fechaInicio").val();
        var plazo = $("#plazo").val();
        var montoCIF = $("#montoCIF").val();
        var derechos = $("#derechos").val();

        if(idAsegurado === '' || tipoMercaderia === '' || embalaje === '' || direccion === ''
            || fechaInicio === '' || plazo === '' || montoCIF === '' || derechos === '')
        {
            $('#messageNewGuaranteePolicy').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else {
            $.ajax({
                type: 'GET',
                url: e,
                data: { idGarantia: idGarantia, idAsegurado: idAsegurado, tipoMercaderia: tipoMercaderia, embalaje: embalaje, direccion: direccion, fechaInicio: fechaInicio, plazo: plazo, montoCIF: montoCIF, derechos: derechos },
                dataType : "json",
                beforeSend: function () {
                    $('#saveGuaranteePolicyEdit').html("Cargando...");
                },
                success: function (data) {
                    console.debug("success");
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status === "success"){
                        console.debug("success");
                        $('#messageEditGuaranteePolicy').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#saveGuaranteePolicyEdit').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                        $('#modalPrincipal').hide();
                        window.location.reload(true);
                    }
                    else{
                        console.debug("fail");
                        $('#saveGuaranteePolicyEdit').html("Guardar");
                        $('#messageEditGuaranteePolicy').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    }
                },
                error: function (data) {
                    console.debug("error");
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#saveGuaranteePolicyEdit').html("Guardar");
                    $('#messageEditGuaranteePolicy').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                }
            });
        }

    });

</script>