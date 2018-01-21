<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Pólizas
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Policies</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Pólizas</h3>
            <button id="newPolicy" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaPolicies" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Compañia</th>
                    <th>Nombre</th>
                    <th>Número</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Compañia</th>
                    <th>Nombre</th>
                    <th>Número</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($polizas as $poliza): ?>
                    <tr data-id="<?php echo $poliza['ID_POLIZA'] ?>">
                        <th><?php echo $n ?></th>
                        <td>
                            <?php
                            foreach ($companias as $compania):
                                if($compania['ID_COMPANIA'] == $poliza['ID_COMPANIA']):
                                    echo utf8_encode($compania['NOMBRE']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <td><?php echo $poliza['TIPO_POLIZA'] ?></td>
                        <td><?php echo $poliza['NUMERO'] ?></td>
                        <td>
                            <button data-original-title="Editar" class="btn btn-xs btn-default editPolicy">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deletePolicy">
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

        var table = $('#tablaPolicies').DataTable();

        $("#newPolicy").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Policy&action=newPolicy',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaPolicies").on("click", ".editPolicy", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idPolicy: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Policy&action=policyEdit',
                'GET',
                { idPoliza: id },
                defaultMessage);
            return false;
        }));

        $("#tablaPolicies").on("click", ".deletePolicy" ,(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará la poliza. ¿Está seguro? ',
                    ok: 'Eliminar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=Policy&action=deletePolicy',
                        data: { idPoliza: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status == 'error') {
                                $("#messagePolicy").fadeOut( "slow", function() {
                                    $('#messagePolicy').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messagePolicy").fadeOut( "slow", function() {
                                    $('#messagePolicy').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=Policy&action=index";
                            }
                        },
                        error: function(data) {
                            $("#messagePolicy").fadeOut( "slow", function() {
                                $('#messagePolicy').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));

    } );
</script>