<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Tipos de Medios
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> MedioType</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Tipos de Medios</h3>
            <button id="newMedioType" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaMedioTypes" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
                <?php foreach ($tipoMedios as $tipoMedio): ?>
                    <tr data-id="<?php echo $tipoMedio['ID_TIPO_MEDIO'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo $tipoMedio['TIPO_MEDIO'] ?></td>
                        <td>
                            <button data-original-title="Edit Row" class="btn btn-xs btn-default editMedioType">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Delete" class="btn btn-xs btn-default deleteMedioType">
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

        var table = $('#tablaMedioTypes').DataTable();

        $("#newMedioType").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=MedioType&action=newMedioType',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaMedioTypes").on("click", ".editMedioType", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idMedioType: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=MedioType&action=medioTypeEdit',
                'GET',
                { idMedioType: id },
                defaultMessage);
            return false;
        }));

        $("#tablaMedioTypes").on("click", ".deleteMedioType" ,(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará el tipo de medio. ¿Está seguro? ',
                    ok: 'Eliminar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=MedioType&action=deleteMedioType',
                        data: { idMedioType: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status == 'error') {
                                $("#messageMedioType").fadeOut( "slow", function() {
                                    $('#messageMedioType').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageMedioType").fadeOut( "slow", function() {
                                    $('#messageMedioType').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=MedioType&action=index";
                            }
                        },
                        error: function(data) {
                            $("#messageMedioType").fadeOut( "slow", function() {
                                $('#messageMedioType').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));

    } );
</script>