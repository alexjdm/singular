<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Corredoras
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> InsuranceBroker</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Corredoras</h3>
            <button id="newInsuranceBroker" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaCorredoras" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Rut</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Rut</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($corredoras as $corredora): ?>
                    <tr data-id="<?php echo $corredora['ID_CORREDORA'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo $corredora['NOMBRE'] ?></td>
                        <td><?php echo $corredora['RUT'] ?></td>
                        <td>
                            <button data-original-title="Editar" class="btn btn-xs btn-default editInsuranceBroker">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteInsuranceBroker">
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

        var table = $('#tablaCorredoras').DataTable();

        $("#newInsuranceBroker").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=InsuranceBroker&action=newInsuranceBroker',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaCorredoras").on("click", ".editInsuranceBroker", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idCorredora: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=InsuranceBroker&action=companyEdit',
                'GET',
                { idCorredora: id },
                defaultMessage);
            return false;
        }));

        $("#tablaCorredoras").on("click", ".deleteInsuranceBroker" ,(function () {
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
                        url: 'ajax.php?controller=InsuranceBroker&action=deleteInsuranceBroker',
                        data: { idCorredora: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status == 'error') {
                                $("#messageInsuranceBroker").fadeOut( "slow", function() {
                                    $('#messageInsuranceBroker').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageInsuranceBroker").fadeOut( "slow", function() {
                                    $('#messageInsuranceBroker').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=InsuranceBroker&action=index";
                            }
                        },
                        error: function(data) {
                            $("#messageInsuranceBroker").fadeOut( "slow", function() {
                                $('#messageInsuranceBroker').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));

    } );
</script>