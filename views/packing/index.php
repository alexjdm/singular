<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Embalajes
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Packing</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Embalajes</h3>
            <button id="newPacking" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaEmbalaje" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Embalaje</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Embalaje</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($embalajes as $embalaje): ?>
                    <tr data-id="<?php echo $embalaje['ID_EMBALAJE'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo utf8_encode($embalaje['EMBALAJE']) ?></td>
                        <td>
                            <button data-original-title="Editar" class="btn btn-xs btn-default editPacking">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deletePacking">
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

        var table = $('#tablaEmbalaje').DataTable();

        $("#newPacking").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Packing&action=newPacking',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaEmbalaje").on("click", ".editPacking", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idEmbalaje: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Packing&action=packingEdit',
                'GET',
                { idEmbalaje: id },
                defaultMessage);
            return false;
        }));

        $("#tablaEmbalaje").on("click", ".deletePacking" ,(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará el embalaje. ¿Está seguro? ',
                    ok: 'Eliminar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=Packing&action=deletePacking',
                        data: { idEmbalaje: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status == 'error') {
                                $("#messagePacking").fadeOut( "slow", function() {
                                    $('#messagePacking').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messagePacking").fadeOut( "slow", function() {
                                    $('#messagePacking').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=Packing&action=index";
                            }
                        },
                        error: function(data) {
                            $("#messagePacking").fadeOut( "slow", function() {
                                $('#messagePacking').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));

    } );
</script>