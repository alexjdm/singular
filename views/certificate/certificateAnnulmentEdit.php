<style>
    .form-group{
        padding: 15px;
    }
</style>

<div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar Solicitud de Anulación de Certificado</h4>
        </div>
        <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
            <input id="idCertificadoAnulacion" value="<?php echo $certificadoAnular['ID_CERTIFICADO'] ?>" type="hidden">

            <div class="form-group">
                <label class="col-sm-3 control-label" for="idPoliza">Poliza *</label>
                <div class="col-sm-9">
                    <select id="idPoliza" class="form-control">
                        <?php foreach ($polizas as $poliza): ?>
                            <option value="<?php echo $poliza['ID_POLIZA']; ?>" <?php if($poliza['ID_POLIZA'] == $certificadoAnular['ID_POLIZA']) { echo "selected"; } ?>><?php echo utf8_encode($poliza['TIPO_POLIZA']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="buscadorCertificado">Certificado *</label>
                <div class="col-sm-7">
                    <input type="text" id="buscadorCertificado" class="form-control" placeholder="Ingresa el número del certificado" value="<?php echo $certificadoAnular['NUMERO'] ?>" readonly>
                </div>
                <div class="col-sm-2">
                    <button id="btnBuscar" class="btn btn-default" disabled>Buscar</button>
                </div>
                <div class="col-sm-9 col-sm-offset-3" id="resultadoCertificado" style="margin-top: 10px;"></div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="motivo">Motivo *</label>
                <div class="col-sm-9">
                    <input id="motivo" class="form-control" type="text" minlength="3" maxlength="200" value="<?php echo $certificadoAnular['MOTIVO'] ?>">
                </div>
            </div>

            <br>
            <div id="messageEditCertificateAnnulment" style="margin: 20px;"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            <!--<?php if ($certificadoAnulacion['HABILITADO'] == 1) { ?>
                <button type="button" class="btn btn-primary" id="toggleDesactivar">Desactivar</button>
            <?php } else if ($certificadoAnulacion['HABILITADO'] == 0) { ?>
                <button type="button" class="btn btn-primary" id="toggleActivar">Activar</button>
            <?php } ?>-->

            <button id="saveCertificateAnnulmentEdit" type="button" class="btn btn-primary">Guardar</button>

        </div>
    </div>
</div>

<script type="application/javascript">

    $("#btnBuscar").click(function () {
        var url = 'ajax.php?controller=Certificate&action=searchCertificate'; console.debug(url);
        var idPoliza = $("#idPoliza :selected").val();
        var numero = $("#buscadorCertificado").val();

        if(idPoliza === '' || numero === '')
        {
            $('#resultadoCertificado').html('<p><strong>Error! </strong> Debes ingresar el número del certificado</p>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: url,
                data: { idPoliza: idPoliza, numero: numero },
                dataType : "json",
                beforeSend: function () {
                    $('#resultadoCertificado').html("Buscando...");
                },
                success: function (data) {
                    console.debug("success");
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    //debugger;
                    if(data.status === "success"){
                        console.debug("success");
                        //debugger;
                        $('#resultadoCertificado').html("<p id='idCertificado' data-idcertificado='" + data.message[0].ID_CERTIFICADO + "'> N° " + data.message[0].NUMERO + " de " + data.message[0].ORIGEN + " a " + data.message[0].DESTINO + " el " + data.message[0].FECHA_EMBARQUE + "</p>");
                    }
                    else{
                        console.debug("fail");
                        $('#resultadoCertificado').html('<p><strong>Error! </strong>' + data.message + '</p>');
                    }
                },
                error: function (data) {
                    console.log("error");
                    console.debug(data);
                    //debugger;
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#resultadoCertificado').html('<p><strong>Error! </strong>' + data.message + '</p>');
                }
            });
        }

        return false;
    });

    $('#btnBuscar').trigger("click");

    $('#idPoliza').change(function () {
        $('#buscadorCertificado').html("");
        $('#resultadoCertificado').html("");
    });

    $('#saveCertificateAnnulmentEdit').click(function(){
        var e = 'ajax.php?controller=Certificate&action=certificateAnnulmentEdit2db';

        var idPoliza = $("#idPoliza :selected").val();
        var idCertificado = $("#idCertificado").data('idcertificado'); console.log(idCertificado);
        var motivo = $("#motivo").val(); //console.debug(motivo);

        if(idPoliza === '' || idCertificado === undefined || idCertificado === '' || idCertificado === 0 || motivo === '')
        {
            $('#messageNewCertificateAnnulment').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { idCertificado: idCertificado, motivo: motivo },
                dataType : "json",
                beforeSend: function () {
                    $('#newCertificateAnnulmentBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status === "success"){
                        $('#messageNewCertificateAnnulment').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newCertificateAnnulmentBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewCertificateAnnulment').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newCertificateAnnulmentBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewCertificateAnnulment').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newCertificateAnnulmentBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

</script>