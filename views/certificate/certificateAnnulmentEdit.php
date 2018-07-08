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
                <label class="col-sm-3 control-label" for="idCertificado">Certificado *</label>
                <div class="col-sm-7">
                    <input type="text" id="buscadorCertificado" class="form-control" placeholder="Ingresa el número del certificado" value="<?php echo $certificadoAnular['NUMERO'] ?>" readonly>
                </div>
                <div class="col-sm-2">
                    <button id="btnBuscar" class="btn btn-default" disabled>Buscar</button>
                </div>
                <div class="col-sm-9 col-sm-offset-3" id="resultadoCertificado"></div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="motivo">Motivo *</label>
                <div class="col-sm-9">
                    <input id="motivo" class="form-control" type="text" minlength="3" maxlength="200" value="<?php echo $certificadoAnular['MOTIVO'] ?>">
                </div>
            </div>

            <table id="tablaCertificados" style="display: none;">
                <tbody class="buscar">
                <?php foreach ($certificados as $certificado): ?>
                    <tr>
                        <td class="numeroCertificado"
                            data-numerocertificado="<?php echo $certificado['NUMERO']; ?>"
                            data-idcertificado="<?php echo $certificado['ID_CERTIFICADO']; ?>">
                            <?php echo utf8_encode($certificado['NUMERO']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

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

    var idCertificadoSeleccionado = 0;

    $('#btnBuscar').click(function () {

        var numeroCertificado = "";
        var textoAbuscar = $('#buscadorCertificado').val();
        if(textoAbuscar === "") return false;

        var rex = new RegExp(textoAbuscar, 'i'); //console.log(rex);
        var i = 0;

        $(".numeroCertificado").each(function() {
            //console.log($(this).data("numerocertificado"));
            if($(this).data("numerocertificado") == textoAbuscar)
            {
                numeroCertificado = $(this).data("numerocertificado");
                idCertificadoSeleccionado = $(this).data("idcertificado");

                $('#resultadoCertificado').html("Certificado " + numeroCertificado + " existente.");

                return false;
            }
            else
            {
                $('#resultadoCertificado').html("No hay resultados para tu búsqueda.");
            }

        });

        return false;

    });

    $('#btnBuscar').trigger("click");

    $('#saveCertificateAnnulmentEdit').click(function(){
        var e = 'ajax.php?controller=Certificate&action=certificateAnnulmentEdit2db';
        var idCertificado = idCertificadoSeleccionado;
        var motivo = $("#motivo").val(); //console.debug(motivo);

        //if(idPoliza === '' || idCertificado === '' || motivo === '')
        if(idCertificado === '' || idCertificado === 0 || motivo === '')
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
                    if(data.status == "success"){
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