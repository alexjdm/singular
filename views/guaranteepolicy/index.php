<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Solicitud de Garantías
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> GuaranteePolicy</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Solicitudes de Garantías</h3>
            <button id="newGuaranteePolicy" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaGuaranteePolicies" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Asegurado</th>
                        <th>Cliente</th>
                        <th>Tipo Garantía</th>
                        <th>Fecha Inicio</th>
                        <th>Plazo</th>
                        <th>Monto CIF</th>
                        <th>Derechos + IVA</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>N°</th>
                        <th>Asegurado</th>
                        <th>Cliente</th>
                        <th>Tipo Garantía</th>
                        <th>Fecha Inicio</th>
                        <th>Plazo</th>
                        <th>Monto CIF</th>
                        <th>Derechos + IVA</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($garantiasVM as $garantia): ?>
                    <tr data-id="<?php echo $garantia['ID_GARANTIA'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo $garantia['NOMBRE_ASEGURADO'] ?></td>
                        <td><?php echo $garantia['CLIENTE'] ?></td>
                        <td><?php echo $garantia['TIPO_GARANTIA'] ?></td>
                        <td><?php echo $garantia['FECHA_INICIO'] ?></td>
                        <td><?php echo $garantia['PLAZO'] ?></td>
                        <td><?php echo $garantia['MONTO_CIF'] ?></td>
                        <td><?php echo $garantia['DERECHOS'] ?></td>
                        <td><?php echo $garantia['ESTADO'] ?></td>
                        <td style="width: 70px;">
                            <button data-original-title="Editar" class="btn btn-xs btn-default editGuaranteePolicy">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteGuaranteePolicy">
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

        var table = $('#tablaGuaranteePolicies').DataTable({
            "scrollX": true
        });

        $("#newGuaranteePolicy").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=GuaranteePolicy&action=newGuaranteePolicy',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaGuaranteePolicies").on("click", ".editGuaranteePolicy", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idGarantia: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=GuaranteePolicy&action=guaranteePolicyEdit',
                'GET',
                { idGarantia: id },
                defaultMessage);
            return false;
        }));

        $("#tablaGuaranteePolicies").on("click", ".deleteGuaranteePolicy" ,(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará la solicitud de garantía. ¿Está seguro? ',
                    ok: 'Eliminar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=GuaranteePolicy&action=deleteGuaranteePolicy',
                        data: { idGarantia: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status === 'error') {
                                $("#messageGuaranteePolicy").fadeOut( "slow", function() {
                                    $('#messageGuaranteePolicy').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageGuaranteePolicy").fadeOut( "slow", function() {
                                    $('#messageGuaranteePolicy').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=GuaranteePolicy&action=index";
                            }
                        },
                        error: function(data) {
                            $("#messageGuaranteePolicy").fadeOut( "slow", function() {
                                $('#messageGuaranteePolicy').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));

    } );
</script>