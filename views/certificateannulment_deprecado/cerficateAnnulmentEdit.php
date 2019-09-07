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
            <input id="idCargo" value="<?php echo $certificadoAnulacion['ID_CERTIFICADO_ANULACION'] ?>" type="hidden">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="poliza">Poliza</label>
                <div class="col-sm-9">
                    <select id="poliza" class="form-control">
                        <?php foreach ($seguros as $seguro): ?>
                            <option value="<?php echo $seguro['POLIZA']; ?>" <?php if($seguro['POLIZA'] == $certificadoAnulacion['POLIZA']) { echo "selected"; } ?>><?php echo utf8_encode($seguro['POLIZA']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="nombre">Nombre</label>
                <div class="col-sm-9">
                    <input class="form-control" id="nombre" type="text" value="<?php echo $certificadoAnulacion['NOMBRE'] ?>">
                </div>
            </div>
            <br>
            <div id="messageEditCertificateAnnulment"></div>
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

    $('#saveCertificateAnnulmentEdit').click(function(){
        var e = 'ajax.php?controller=CertificateAnnulment&action=jobTitleEdit2db';
        var idCargo = $("#idCargo").val();
        var nombre = $("#nombre").val();

        $.ajax({
            type: 'GET',
            url: e,
            data: { idCargo: idCargo, nombre: nombre },
            dataType : "json",
            beforeSend: function () {
                $('#saveCertificateAnnulmentEdit').html("Cargando...");
            },
            success: function (data) {
                console.debug("success");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                if(data.status == "success"){
                    console.debug("success");
                    $('#messageEditCertificateAnnulment').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                    $('#saveCertificateAnnulmentEdit').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                    $('#modalPrincipal').hide();
                    window.location.reload(true);
                }
                else{
                    console.debug("fail");
                    $('#saveCertificateAnnulmentEdit').html("Guardar");
                    $('#messageEditCertificateAnnulment').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                }
            },
            error: function (data) {
                console.debug("error");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                $('#saveCertificateAnnulmentEdit').html("Guardar");
                $('#messageEditCertificateAnnulment').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
            }
        });
    });

</script>