<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Cargos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> JobTitle</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Cargos</h3>
            <button id="newJobTitle" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaCargos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($cargos as $cargo): ?>
                    <tr data-id="<?php echo $cargo['ID_CARGO'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo $cargo['NOMBRE'] ?></td>
                        <td>
                            <?php if($cargo['BASE'] == 0 && !isSuperAdmin()): ?>
                            <button data-original-title="Editar" class="btn btn-xs btn-default editJobTitle">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteJobTitle">
                                <i class="fa fa-times"></i>
                            </button>
                            <?php endif; ?>
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

        var table = $('#tablaCargos').DataTable();

        $("#newJobTitle").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=JobTitle&action=newJobTitle',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaCargos").on("click", ".editJobTitle", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idCargo: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=JobTitle&action=jobTitleEdit',
                'GET',
                { idCargo: id },
                defaultMessage);
            return false;
        }));

        $("#tablaCargos").on("click", ".deleteJobTitle" ,(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará el cargo. ¿Está seguro? ',
                    ok: 'Eliminar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=JobTitle&action=deleteJobTitle',
                        data: { idCargo: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status == 'error') {
                                $( "#messageJobTitle" ).fadeOut( "slow", function() {
                                    $('#messageJobTitle').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $( "#messageJobTitle" ).fadeOut( "slow", function() {
                                    $('#messageJobTitle').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=JobTitle&action=index";
                            }
                        },
                        error: function(data) {
                            $( "#messageJobTitle" ).fadeOut( "slow", function() {
                                $('#messageJobTitle').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));


    } );
</script>