<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Solicitud de Anulación de Certificado
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> CertificateAnnulment</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Solicitudes de Anulación de Certificado</h3>
            <button id="newCertificateAnnulment" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaCertificadoAnulacion" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Certificado N°</th>
                    <th>Poliza</th>
                    <th>RUT</th>
                    <th>Nombre</th>
                    <th>Motivo</th>
                    <th>Cert. Reemplazo</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Certificado N°</th>
                    <th>Poliza</th>
                    <th>RUT</th>
                    <th>Nombre</th>
                    <th>Motivo</th>
                    <th>Cert. Reemplazo</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($certificadoAnulaciones as $certificadoAnulacion): ?>
                    <tr data-id="<?php echo $certificadoAnulacion['ID_CERTIFICADO_ANULACION'] ?>">
                        <th><?php echo $n ?></th>
                        <?php
                        foreach ($certificados as $certificado):
                            if($certificado['ID_CERTIFICADO'] == $certificadoAnulacion['ID_CERTIFICADO']):
                                echo "<td title='". $certificado['FORMATO'] ."'>";
                                echo utf8_encode($certificado['NUMERO']);
                                echo "</td>";
                                foreach ($polizas as $poliza):
                                    if($poliza['ID_POLIZA'] == $certificado['ID_POLIZA']):
                                        echo '<td>' . utf8_encode($poliza['TIPO_POLIZA']) . '</td>';
                                        break;
                                    endif;
                                endforeach;
                                foreach ($asegurados as $asegurado):
                                    if($asegurado['ID_ASEGURADO'] == $certificado['ID_ASEGURADO']):
                                        echo "<td>";
                                        echo utf8_encode($asegurado['IDENTIFICADOR']);
                                        echo "</td>";
                                        echo "<td>";
                                        echo utf8_encode($asegurado['NOMBRE']);
                                        echo "</td>";
                                        break;
                                    endif;
                                endforeach;
                                break;
                            endif;
                        endforeach;
                        ?>
                        <td><?php echo $certificadoAnulacion['MOTIVO'] ?></td>
                        <?php
                        if($certificadoAnulacion['ID_CERTIFICADO_REEMPLAZO'] != 0)
                        {
                            foreach ($certificados as $certificado):
                                if($certificado['ID_CERTIFICADO'] == $certificadoAnulacion['ID_CERTIFICADO_REEMPLAZO']):
                                    echo "<td title='". $certificado['FORMATO'] ."'>";
                                    echo utf8_encode($certificado['NUMERO']);
                                    echo "</td>";
                                    break;
                                endif;
                            endforeach;
                        }
                        else
                        {
                            echo "<td> ";
                            if($isSuperAdmin == true):
                                echo '
                                    <button title="Agregar N° Certificado" class="btn btn-xs btn-primary addReplaceCertificateNumber">
                                        <i class="fa fa-plus-circle"></i>
                                    </button>
                                ';
                            endif;
                            echo "</td>";
                        }
                        ?>
                        <?php
                        if($certificadoAnulacion['ESTADO'] == 0)
                        {
                            echo '<td>Pendiente</td>';
                        }
                        else if($certificadoAnulacion['ESTADO'] == 1)
                        {
                            echo '<td>Listo</td>';
                        }
                        ?>
                        <td>
                            <?php if($certificadoAnulacion['ESTADO'] == 0 || $isSuperAdmin == true): ?>
                            <button data-original-title="Editar" class="btn btn-xs btn-default editCertificateAnnulment">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteCertificateAnnulment">
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

        var table = $('#tablaCertificadoAnulacion').DataTable();

        $("#newCertificateAnnulment").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=CertificateAnnulment&action=newCertificateAnnulment',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaCertificadoAnulacion").on("click", ".addReplaceCertificateNumber", (function() {
            var id = $(this).closest('tr').data("id"); //console.debug("idCertificadoAnulacion: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=CertificateAnnulment&action=addReplaceCertificateNumber',
                'GET',
                { idCertificadoAnulacion: id },
                defaultMessage);
            return false;
        }));

        $("#tablaCertificadoAnulacion").on("click", ".editCertificateAnnulment", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idCertificadoAnulacion: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=CertificateAnnulment&action=certificateAnnulmentEdit',
                'GET',
                { idCertificadoAnulacion: id },
                defaultMessage);
            return false;
        }));

        $("#tablaCertificadoAnulacion").on("click", ".deleteCertificateAnnulment" ,(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará la anulación del certificado. ¿Está seguro? ',
                    ok: 'Eliminar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=CertificateAnnulment&action=deleteCertificateAnnulment',
                        data: { idCertificadoAnulacion: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status == 'error') {
                                $("#messageCertificateAnnulment").fadeOut( "slow", function() {
                                    $('#messageCertificateAnnulment').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageCertificateAnnulment").fadeOut( "slow", function() {
                                    $('#messageCertificateAnnulment').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=CertificateAnnulment&action=index";
                            }
                        },
                        error: function(data) {
                            $("#messageCertificateAnnulment").fadeOut( "slow", function() {
                                $('#messageCertificateAnnulment').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));

    } );
</script>