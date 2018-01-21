<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Tipo de Mercaderías
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> MerchandiseType</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Tipos de Mercaderías</h3>
            <button id="newMerchandiseType" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaTipoMercaderias" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Tipo de Mercadería</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Tipo de Mercadería</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($tipoMercaderias as $tipoMercaderia): ?>
                    <tr data-id="<?php echo $tipoMercaderia['ID_TIPO_MERCADERIA'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo $tipoMercaderia['TIPO_MERCADERIA'] ?></td>
                        <td>
                            <button data-original-title="Editar" class="btn btn-xs btn-default editMerchandiseType">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteMerchandiseType">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>
                    <?php $n++; ?>
                <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    </div>

</section><!-- /.content -->

<script>
    $(function() {

        var table = $('#tablaTipoMercaderias').DataTable();

        $("#newMerchandiseType").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=MerchandiseType&action=newMerchandiseType',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaTipoMercaderias").on("click", ".editMerchandiseType", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idTipoMercaderia: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=MerchandiseType&action=merchandiseTypeEdit',
                'GET',
                { idTipoMercaderia: id },
                defaultMessage);
            return false;
        }));

        $("#tablaTipoMercaderias").on("click", ".deleteMerchandiseType" ,(function () {
            var id = $(this).closest('tr').data("id"); //console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará el tipo de mercadería. ¿Está seguro? ',
                    ok: 'Eliminar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=MerchandiseType&action=deleteMerchandiseType',
                        data: { idTipoMercaderia: id },
                        beforeSend: function() {
                        },
                        success: function(data) {
                            //console.log(data);
                            if (data.status == 'error') {
                                $( "#messageMerchandiseType" ).fadeOut( "slow", function() {
                                    $('#messageMerchandiseType').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $( "#messageMerchandiseType" ).fadeOut( "slow", function() {
                                    $('#messageMerchandiseType').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=MerchandiseType&action=index";
                            }
                        },
                        error: function(data) {
                            $( "#messageMerchandiseType" ).fadeOut( "slow", function() {
                                $('#messageMerchandiseType').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));

    } );
</script>