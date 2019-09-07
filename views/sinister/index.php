<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Siniestros
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Sinister</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Siniestros</h3>
            <button id="newSinister" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaSiniestros" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Poliza</th>
                    <th>Certificado</th>
                    <th>Cliente</th>
                    <th>Asegurado</th>
                    <th>Motivo</th>
                    <th>Nombre Contacto</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th>Número</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Poliza</th>
                    <th>Certificado</th>
                    <th>Cliente</th>
                    <th>Asegurado</th>
                    <th>Motivo</th>
                    <th>Nombre Contacto</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th>Número</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($siniestrosVM as $siniestro): ?>
                    <tr data-id="<?php echo $siniestro['ID_SINIESTRO'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo $siniestro['POLIZA'] ?></td>
                        <td><?php echo $siniestro['NUMERO_CERTIFICADO'] ?></td>
                        <td><?php echo $siniestro['CLIENTE'] ?></td>
                        <td><?php echo $siniestro['ASEGURADO'] ?></td>
                        <td><?php echo $siniestro['MOTIVO'] ?></td>
                        <td><?php echo $siniestro['NOMBRE'] ?></td>
                        <td><?php echo $siniestro['TELEFONO'] ?></td>
                        <td><?php echo $siniestro['CORREO'] ?></td>
                        <td><?php echo $siniestro['ESTADO'] ?></td>
                        <td><?php echo $siniestro['NUMERO'] ?></td>
                        <td style="width: 100px;">
                            <?php if ($siniestro['ESTADO'] == "Pendiente"): ?>
                            <button title="Agregar" class="btn btn-xs btn-primary addSinister">
                                <i class="fa fa-plus-circle"></i>
                            </button>
                            &nbsp
                            <?php elseif($siniestro['ESTADO'] == "Listo"): ?>
                                <a title="Ver" class="btn btn-xs btn-default" target="_blank" href="<?php echo $siniestro['UBICACION']; ?>">
                                    <i class="fa fa-download"></i>
                                </a>
                                &nbsp
                            <?php else: ?>

                            <?php endif; ?>
                            <button title="Editar" class="btn btn-xs btn-default editSinister">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button title="Eliminar" class="btn btn-xs btn-default deleteSinister">
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

        var table = $('#tablaSiniestros').DataTable({
            "scrollX": true
        });

        $(".addSinister").click(function() {
            var id = $(this).closest('tr').data("id"); //console.debug("idCertificadoSolicitud: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Sinister&action=addSinister',
                'GET',
                { idSiniestro: id },
                defaultMessage);
            return false;
        });

        $("#newSinister").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Sinister&action=newSinister',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaSiniestros").on("click", ".editSinister", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idSiniestro: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Sinister&action=sinisterEdit',
                'GET',
                { idSiniestro: id },
                defaultMessage);
            return false;
        }));

        $("#tablaSiniestros").on("click", ".deleteSinister" ,(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará el siniestro. ¿Está seguro? ',
                    ok: 'Eliminar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=Sinister&action=deleteSinister',
                        data: { idSiniestro: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status === 'error') {
                                $("#messageSinister").fadeOut("slow", function() {
                                    $('#messageSinister').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageSinister").fadeOut("slow", function() {
                                    $('#messageSinister').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=Sinister&action=index";
                            }
                        },
                        error: function(data) {
                            $( "#messageSinister" ).fadeOut( "slow", function() {
                                $('#messageSinister').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));


    } );
</script>