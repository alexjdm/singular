<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Solicitud de Modificación de Certificado
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> CertificateModify</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Solicitudes de Modificación de Certificado</h3>
            <button id="newCertificateModify" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaCertificadoModificacion" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Poliza</th>
                    <th>Certificado</th>
                    <th>RUT</th>
                    <th>Nombre</th>
                    <th>Donde dice</th>
                    <th>Debe decir</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Poliza</th>
                    <th>Certificado</th>
                    <th>RUT</th>
                    <th>Nombre</th>
                    <th>Donde dice</th>
                    <th>Debe decir</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($certificadoModificaciones as $certificadoModificacion): ?>
                    <tr data-id="<?php echo $certificadoModificacion['ID_CERTIFICADO_MODIFICACION'] ?>">
                        <th><?php echo $n ?></th>
                        <?php
                        foreach ($certificados as $certificado):
                            if($certificado['ID_CERTIFICADO'] == $certificadoModificacion['ID_CERTIFICADO']):
                                echo "<td>";
                                foreach ($polizas as $poliza):
                                    if($poliza['ID_POLIZA'] == $certificado['ID_POLIZA']):
                                        echo utf8_encode($poliza['TIPO_POLIZA']);
                                        break;
                                    endif;
                                endforeach;
                                echo "</td>";
                                echo "<td title='". $certificado['FORMATO'] ."'>";
                                echo utf8_encode($certificado['NUMERO']);
                                echo "</td>";
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
                        <td><?php echo $certificadoModificacion['DONDE_DICE'] ?></td>
                        <td><?php echo $certificadoModificacion['DEBE_DECIR'] ?></td>
                        <td>
                            <?php
                                if($certificadoModificacion['ESTADO'] == 0)
                                {
                                    echo "Pendiente";
                                }
                                else if($certificadoModificacion['ESTADO'] == 1)
                                {
                                    echo "Listo";
                                }
                                else
                                {
                                    echo "Sin información";
                                }
                            ?>
                        </td>
                        <td style="width: 100px;">
                            <?php if($isSuperAdmin == true && $certificadoModificacion['ESTADO'] == 0): ?>
                                <button title="Agregar" class="btn btn-xs btn-primary changeCertificate">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                                &nbsp
                            <?php endif; ?>
                            <button data-original-title="Editar" class="btn btn-xs btn-default editCertificateModify">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteCertificateModify">
                                <i class="fa fa-trash-o"></i>
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

        var table = $('#tablaCertificadoModificacion').DataTable({ "scrollX": true });

        $("#newCertificateModify").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=CertificateModify&action=newCertificateModify',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $(".changeCertificate").click(function() {
            var id = $(this).closest('tr').data("id"); //console.debug("idCertificadoSolicitud: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Certificate&action=changeCertificate',
                'GET',
                { idCertificadoModificacion: id },
                defaultMessage);
            return false;
        });

        $("#tablaCertificadoModificacion").on("click", ".setCertificateModify", (function() {

            var id = $(this).closest('tr').data("id"); //console.debug("idCertificadoModificacion: " + id);
            var estado = $(this).data("estado"); //console.debug("Estado: " + estado);

            $.ajax({
                type: 'GET',
                url: 'ajax.php?controller=CertificateModify&action=setCertificateModify',
                data: { idCertificadoModificacion: id, estado: estado },
                beforeSend: function() {
                },
                success: function(data) {

                    if (data.status == 'error') {
                        $("#messageCertificateModify").fadeOut( "slow", function() {
                            $('#messageCertificateModify').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                        });
                    } else {
                        $("#messageCertificateModify").fadeOut( "slow", function() {
                            $('#messageCertificateModify').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                        });
                        window.location.href = "index.php?controller=CertificateModify&action=index";
                    }
                },
                error: function(data) {
                    $("#messageCertificateModify").fadeOut( "slow", function() {
                        $('#messageCertificateModify').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                    });
                }
            });
        }));

        $("#tablaCertificadoModificacion").on("click", ".editCertificateModify", (function() {
            var id = $(this).closest('tr').data("id"); //console.debug("idCertificadoModificacion: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=CertificateModify&action=certificateModifyEdit',
                'GET',
                { idCertificadoModificacion: id },
                defaultMessage);
            return false;
        }));

        $("#tablaCertificadoModificacion").on("click", ".deleteCertificateModify" ,(function () {
            var id = $(this).closest('tr').data("id"); //console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará la modificación del certificado. ¿Está seguro? ',
                    ok: 'Eliminar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=CertificateModify&action=deleteCertificateModify',
                        data: { idCertificadoModificacion: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status == 'error') {
                                $( "#messageCertificateModify" ).fadeOut( "slow", function() {
                                    $('#messageCertificateModify').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $( "#messageCertificateModify" ).fadeOut( "slow", function() {
                                    $('#messageCertificateModify').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=CertificateModify&action=index";
                            }
                        },
                        error: function(data) {
                            $( "#messageCertificateModify" ).fadeOut( "slow", function() {
                                $('#messageCertificateModify').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));

    } );
</script>