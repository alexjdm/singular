<style>
    .form-group{
        padding: 15px;
    }
</style>

<div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar Solicitud de Modificación de Certificado</h4>
        </div>
        <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
            <input id="idCargo" value="<?php echo $certificadoModificacion['ID_CERTIFICADO_MODIFICACION'] ?>" type="hidden">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="poliza">Poliza</label>
                <div class="col-sm-9">
                    <select id="poliza" class="form-control">
                        <?php foreach ($seguros as $seguro): ?>
                            <option value="<?php echo $seguro['POLIZA']; ?>" <?php if($seguro['POLIZA'] == $certificadoModificacion['POLIZA']) { echo "selected"; } ?>><?php echo utf8_encode($seguro['POLIZA']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="nombre">Nombre</label>
                <div class="col-sm-9">
                    <input class="form-control" id="nombre" type="text" value="<?php echo $certificadoModificacion['NOMBRE'] ?>">
                </div>
            </div>
            <br>
            <div id="messageEditCertificateModify"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            <!--<?php if ($certificadoModificacion['HABILITADO'] == 1) { ?>
                <button type="button" class="btn btn-primary" id="toggleDesactivar">Desactivar</button>
            <?php } else if ($certificadoModificacion['HABILITADO'] == 0) { ?>
                <button type="button" class="btn btn-primary" id="toggleActivar">Activar</button>
            <?php } ?>-->

            <button id="saveCertificateModifyEdit" type="button" class="btn btn-primary">Guardar</button>

        </div>
    </div>
</div>

<script type="application/javascript">

    $('#saveCertificateModifyEdit').click(function(){
        var e = 'ajax.php?controller=CertificateModify&action=jobTitleEdit2db';
        var idCargo = $("#idCargo").val();
        var nombre = $("#nombre").val();

        $.ajax({
            type: 'GET',
            url: e,
            data: { idCargo: idCargo, nombre: nombre },
            dataType : "json",
            beforeSend: function () {
                $('#saveCertificateModifyEdit').html("Cargando...");
            },
            success: function (data) {
                console.debug("success");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                if(data.status == "success"){
                    console.debug("success");
                    $('#messageEditCertificateModify').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                    $('#saveCertificateModifyEdit').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                    $('#modalPrincipal').hide();
                    window.location.reload(true);
                }
                else{
                    console.debug("fail");
                    $('#saveCertificateModifyEdit').html("Guardar");
                    $('#messageEditCertificateModify').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                }
            },
            error: function (data) {
                console.debug("error");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                $('#saveCertificateModifyEdit').html("Guardar");
                $('#messageEditCertificateModify').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
            }
        });
    });

</script>