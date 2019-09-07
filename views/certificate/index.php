<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Certificados
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Certificate</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Certificados</h3>
            <button id="newCertificate" class="btn btn-primary" style="float: right;">Ingresar</button>
        </div>

        <div class="box-body">
            <table id="tablaCertificates" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Fecha Solicitud</th>
                    <th>Solicitado Por</th>
                    <th>Para Asegurado</th>
                    <th>N° Póliza</th>
                    <th>Número</th>
                    <th>Formato</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Fecha Solicitud</th>
                    <th>Solicitado Por</th>
                    <th>Para Asegurado</th>
                    <th>N° Póliza</th>
                    <th>Número</th>
                    <th>Formato</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($certificadosVM as $certificado): ?>
                    <tr data-id="<?php echo $certificado['ID_CERTIFICADO'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo $certificado['FECHA_SOLICITUD'] ?></td>
                        <td><?php echo $certificado['NOMBRE_USUARIO'] ?></td>
                        <td><?php echo $certificado['NOMBRE_ASEGURADO'] ?></td>
                        <td><?php echo $certificado['POLIZA'] ?></td>
                        <td><?php echo $certificado['NUMERO'] ?></td>
                        <td><?php echo $certificado['FORMATO'] ?></td>
                        <td style="width: 100px;">
                            <a title="Descargar" target="_blank" class="btn btn-xs btn-default downloadCertificate" href="<?php echo $certificado['UBICACION'] ?>">
                                <i class="fa fa-download"></i>
                            </a>
                            &nbsp
                            <button title="Ver Certificado" class="btn btn-xs btn-default viewCertificate">
                                <i class="fa fa-eye"></i>
                            </button>
                            <!--<button title="Editar" class="btn btn-xs btn-default editCertificate">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp-->
                            <?php if($isSuperAdmin == true): ?>
                            &nbsp
                            <button title="Eliminar" class="btn btn-xs btn-default deleteCertificate">
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

        var table = $('#tablaCertificates').DataTable({
            "scrollX": true
        });

        /*var table = $('#tablaCertificates').DataTable();*/

        $("#newCertificate").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Certificate&action=newCertificate',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaCertificates").on("click", ".editCertificate", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idCertificado: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Certificate&action=certificateEdit',
                'GET',
                { idCertificado: id },
                defaultMessage);
            return false;
        }));

        $("#tablaCertificates").on("click", ".viewCertificate", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idCertificado: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Certificate&action=viewCertificate',
                'GET',
                { idCertificado: id },
                defaultMessage);
            return false;
        }));

        $("#tablaCertificates").on("click", ".deleteCertificate" ,(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará el certificado. ¿Está seguro? ',
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
                                $("#messageCertificate").fadeOut( "slow", function() {
                                    $('#messageCertificate').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageCertificate").fadeOut( "slow", function() {
                                    $('#messageCertificate').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=Certificate&action=index";
                            }
                        },
                        error: function(data) {
                            $("#messageCertificate").fadeOut( "slow", function() {
                                $('#messageCertificate').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));

    } );
</script>