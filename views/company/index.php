<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Compañias
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Company</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Compañías</h3>
            <button id="newCompany" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaCompanias" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Tasa</th>
                    <th>Prima mínima</th>
                    <th>Límite embarque</th>
                    <th>Tipo de Cuenta</th>
                    <th>Comisión</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Tasa</th>
                    <th>Prima mínima</th>
                    <th>Límite embarque</th>
                    <th>Tipo de Cuenta</th>
                    <th>Comisión</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($companias as $compania): ?>
                    <tr data-id="<?php echo $compania['ID_COMPANIA'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo $compania['NOMBRE'] ?></td>
                        <td><?php echo $compania['TASA'] ?></td>
                        <td><?php echo $compania['PRIMA_MINIMA'] ?></td>
                        <td><?php echo $compania['LIMITE_EMBARQUE'] ?></td>
                        <td><?php echo $compania['TIPO_CUENTA'] ?></td>
                        <td><?php echo $compania['COMISION'] ?></td>
                        <td>
                            <button data-original-title="Editar" class="btn btn-xs btn-default editCompany">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteCompany">
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

        var table = $('#tablaCompanias').DataTable();

        $("#newCompany").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Company&action=newCompany',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaCompanias").on("click", ".editCompany", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idCompania: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Company&action=companyEdit',
                'GET',
                { idCompania: id },
                defaultMessage);
            return false;
        }));

        $("#tablaCompanias").on("click", ".deleteCompany" ,(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará la compañia. ¿Está seguro? ',
                    ok: 'Eliminar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=Company&action=deleteCompany',
                        data: { idCompania: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status == 'error') {
                                $("#messageCompany").fadeOut( "slow", function() {
                                    $('#messageCompany').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageCompany").fadeOut( "slow", function() {
                                    $('#messageCompany').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=Company&action=index";
                            }
                        },
                        error: function(data) {
                            $("#messageCompany").fadeOut( "slow", function() {
                                $('#messageCompany').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));

    } );
</script>