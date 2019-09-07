<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Solicitud de Certificados
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> CertificateRequest</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Solicitudes de Certificados</h3>
            <button id="newCertificateRequest" class="btn btn-primary" style="float: right;">NUEVO CERTIFICADO</button>
        </div>

        <div class="box-body">
            <table id="tablaCertificateRequests" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Fecha Solicitud</th>
                    <th>Cliente</th>
                    <th>Asegurado</th>
                    <th>Póliza</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <?php if($isSuperAdmin): ?>
                    <th>Solicitado Por</th>
                    <?php endif; ?>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Fecha Solicitud</th>
                    <th>Cliente</th>
                    <th>Asegurado</th>
                    <th>Póliza</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <?php if($isSuperAdmin): ?>
                    <th>Solicitado Por</th>
                    <?php endif; ?>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($certificadosVM as $certificadoVM): ?>
                    <tr data-id="<?php echo $certificadoVM['ID_CERTIFICADO'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo $certificadoVM['FECHA_SOLICITUD'] ?></td>
                        <td><?php echo $certificadoVM['CLIENTE'] ?></td>
                        <td><?php echo $certificadoVM['ASEGURADO'] ?></td>
                        <td><?php echo $certificadoVM['POLIZA'] ?></td>
                        <td><?php echo $certificadoVM['TIPO'] ?></td>
                        <td><?php echo $certificadoVM['ESTADO_SOLICITUD'] ?></td>
                        <?php if($isSuperAdmin): ?>
                            <?php echo '<td>' . $certificadoVM['USUARIO_SOLICITANTE'] . '</td>' ?>
                        <?php endif; ?>
                        <td style="width: 110px;">
                            <?php if($isSuperAdmin == true): ?>
                            <button title="Agregar" class="btn btn-xs btn-primary addCertificate">
                                <i class="fa fa-plus-circle"></i>
                            </button>
                            &nbsp
                            <?php endif; ?>
                            <?php if($certificadoVM['ESTADO_SOLICITUD'] == "Pendiente" || $isSuperAdmin == true): ?>
                            <button title="Editar" class="btn btn-xs btn-default editCertificateRequest">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button title="Eliminar" class="btn btn-xs btn-default deleteCertificateRequest">
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

        /*var table = $('#tablaCertificateRequests').DataTable({
            "scrollX": true
        });*/

        var table = $('#tablaCertificateRequests').DataTable({ "scrollX": true });

        $("#newCertificateRequest").click(function() {
            var id = $(this).closest('tr').data("id"); //console.debug("idCertificadoSolicitud: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Certificate&action=newCertificateRequest',
                'GET',
                { },
                defaultMessage, 'static');
            return false;
        });

        $(".addCertificate").click(function() {
            var id = $(this).closest('tr').data("id"); //console.debug("idCertificadoSolicitud: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Certificate&action=addCertificate',
                'GET',
                { idCertificadoSolicitud: id },
                defaultMessage);
            return false;
        });

        $("#tablaCertificateRequests").on("click", ".editCertificateRequest", (function() {
            var id = $(this).closest('tr').data("id"); //console.debug("idCertificadoSolicitud: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Certificate&action=certificateRequestEdit',
                'GET',
                { idCertificadoSolicitud: id },
                defaultMessage);
            return false;
        }));

        $("#tablaCertificateRequests").on("click", ".deleteCertificateRequest" ,(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará la solicitud de certificado. ¿Está seguro? ',
                    ok: 'Eliminar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=Certificate&action=deleteCertificate',
                        data: { idCertificado: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status == 'error') {
                                $("#messageCertificateRequest").fadeOut( "slow", function() {
                                    $('#messageCertificateRequest').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageCertificateRequest").fadeOut( "slow", function() {
                                    $('#messageCertificateRequest').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=Certificate&action=request";
                            }
                        },
                        error: function(data) {
                            $("#messageCertificateRequest").fadeOut( "slow", function() {
                                $('#messageCertificateRequest').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));

    });
</script>