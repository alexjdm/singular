<style>
    .form-group{
        padding: 15px;
    }
</style>

<div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar Tipo de Mercadería</h4>
        </div>
        <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
            <input id="idTipoMercaderia" value="<?php echo $tipoMercaderia['ID_TIPO_MERCADERIA'] ?>" type="hidden">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="tipoMercaderia">Tipo de Mercadería</label>
                <div class="col-sm-9">
                    <input class="form-control" id="tipoMercaderia" type="text" value="<?php echo $tipoMercaderia['TIPO_MERCADERIA'] ?>">
                </div>
            </div>
            <br>
            <div id="messageEditMerchandiseType"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            <!--<?php if ($tipoMercaderia['HABILITADO'] == 1) { ?>
                <button type="button" class="btn btn-primary" id="toggleDesactivar">Desactivar</button>
            <?php } else if ($tipoMercaderia['HABILITADO'] == 0) { ?>
                <button type="button" class="btn btn-primary" id="toggleActivar">Activar</button>
            <?php } ?>-->

            <button id="saveMerchandiseTypeEdit" type="button" class="btn btn-primary">Guardar</button>

        </div>
    </div>
</div>

<script type="application/javascript">

    $('#saveMerchandiseTypeEdit').click(function(){
        var e = 'ajax.php?controller=MerchandiseType&action=merchandiseTypeEdit2db';
        var idTipoMercaderia = $("#idTipoMercaderia").val();
        var tipoMercaderia = $("#tipoMercaderia").val();

        $.ajax({
            type: 'GET',
            url: e,
            data: { idTipoMercaderia: idTipoMercaderia, tipoMercaderia: tipoMercaderia },
            dataType : "json",
            beforeSend: function () {
                $('#saveMerchandiseTypeEdit').html("Cargando...");
            },
            success: function (data) {
                console.debug("success");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                if(data.status == "success"){
                    console.debug("success");
                    $('#messageEditMerchandiseType').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                    $('#saveMerchandiseTypeEdit').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                    $('#modalPrincipal').hide();
                    window.location.reload(true);
                }
                else{
                    console.debug("fail");
                    $('#saveMerchandiseTypeEdit').html("Guardar");
                    $('#messageEditMerchandiseType').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                }
            },
            error: function (data) {
                console.debug("error");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                $('#saveMerchandiseTypeEdit').html("Guardar");
                $('#messageEditMerchandiseType').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
            }
        });
    });

</script>