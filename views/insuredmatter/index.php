<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Materias Aseguradas
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> InsuredMatter</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Materias Aseguradas</h3>
            <button id="newInsuredMatter" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaMateriaAsegurada" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Materia Asegurada</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Materia Asegurada</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($materiasAseguradas as $materiaAsegurada): ?>
                    <tr data-id="<?php echo $materiaAsegurada['ID_MATERIA_ASEGURADA'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo utf8_encode($materiaAsegurada['MATERIA_ASEGURADA']) ?></td>
                        <td>
                            <button data-original-title="Editar" class="btn btn-xs btn-default editInsuredMatter">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteInsuredMatter">
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

        var table = $('#tablaMateriaAsegurada').DataTable();

        $("#newInsuredMatter").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=InsuredMatter&action=newInsuredMatter',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaMateriaAsegurada").on("click", ".editInsuredMatter", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idMateriaAsegurada: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=InsuredMatter&action=insuredMatterEdit',
                'GET',
                { idMateriaAsegurada: id },
                defaultMessage);
            return false;
        }));

        $("#tablaMateriaAsegurada").on("click", ".deleteInsuredMatter" ,(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará la materia. ¿Está seguro? ',
                    ok: 'Eliminar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=InsuredMatter&action=deleteInsuredMatter',
                        data: { idMateriaAsegurada: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status == 'error') {
                                $("#messageInsuredMatter").fadeOut( "slow", function() {
                                    $('#messageInsuredMatter').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageInsuredMatter").fadeOut( "slow", function() {
                                    $('#messageInsuredMatter').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=InsuredMatter&action=index";
                            }
                        },
                        error: function(data) {
                            $("#messageInsuredMatter").fadeOut( "slow", function() {
                                $('#messageInsuredMatter').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));

    } );
</script>