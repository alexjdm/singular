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
            <button id="newCertificateRequest" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaCertificateRequests" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Fecha Solicitud</th>
                    <th>RUT Asegurado</th>
                    <th>Asegurado</th>
                    <th>A favor de</th>
                    <th>Transporte</th>
                    <th>Tipo</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Via</th>
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
                    <th>RUT Asegurado</th>
                    <th>Asegurado</th>
                    <th>A favor de</th>
                    <th>Transporte</th>
                    <th>Tipo</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Via</th>
                    <th>Estado</th>
                    <?php if($isSuperAdmin): ?>
                    <th>Solicitado Por</th>
                    <?php endif; ?>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($certificadoSolicitudes as $certificadoSolicitud): ?>
                    <tr data-id="<?php echo $certificadoSolicitud['ID_CERTIFICADO_SOLICITUD'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo FormatearFechaCompletaSpa($certificadoSolicitud['FECHA_SOLICITUD']) ?></td>
                        <?php
                        foreach ($asegurados as $asegurado):
                            if($asegurado['ID_ASEGURADO'] == $certificadoSolicitud['ID_ASEGURADO']):
                                echo '<td>' . utf8_encode($asegurado['IDENTIFICADOR']) . '</td>';
                                echo '<td>' . utf8_encode($asegurado['NOMBRE']) . '</td>';
                                break;
                            endif;
                        endforeach;
                        ?>
                        <td><?php echo $certificadoSolicitud['A_FAVOR_DE'] ?></td>
                        <?php
                        foreach ($polizas as $poliza):
                            if($poliza['ID_POLIZA'] == $certificadoSolicitud['ID_POLIZA']):
                                echo '<td>' . utf8_encode($poliza['TIPO_POLIZA']) . '</td>';
                                break;
                            endif;
                        endforeach;
                        ?>
                        <td><?php echo $certificadoSolicitud['TIPO'] ?></td>
                        <td><?php echo $certificadoSolicitud['ORIGEN'] ?></td>
                        <td><?php echo $certificadoSolicitud['DESTINO'] ?></td>
                        <td><?php echo $certificadoSolicitud['VIA'] ?></td>
                        <?php
                        if($certificadoSolicitud['ESTADO'] == 0)
                        {
                            echo '<td>Pendiente</td>';
                        }
                        else if($certificadoSolicitud['ESTADO'] == 1)
                        {
                            echo '<td>Listo</td>';
                        }
                        ?>
                        <?php if($isSuperAdmin): ?>
                            <?php
                            foreach ($usuarios as $usuario):
                                if($usuario['ID_USUARIO'] == $certificadoSolicitud['ID_USUARIO_SOLICITANTE']):
                                    echo '<td>' . utf8_encode($usuario['NOMBRE'] . ' ' . $usuario['APELLIDO']) . '</td>';
                                    break;
                                endif;
                            endforeach;
                            ?>
                        <?php endif; ?>
                        <td>
                            <button data-original-title="Editar" class="btn btn-xs btn-default editCertificateRequest">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteCertificateRequest">
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

        /*var table = $('#tablaCertificateRequests').DataTable({
            "scrollX": true
        });*/

        var table = $('#tablaCertificateRequests').DataTable();

        $("#newCertificateRequest").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=CertificateRequest&action=newCertificateRequest',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaCertificateRequests").on("click", ".editCertificateRequest", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idCertificadoSolicitud: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=CertificateRequest&action=certificateRequestEdit',
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
                        url: 'ajax.php?controller=CertificateRequest&action=deleteCertificateRequest',
                        data: { idCertificadoSolicitud: id },
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
                                window.location.href = "index.php?controller=CertificateRequest&action=index";
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

    } );
</script>