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
        <li><a href="#"><i class="fa fa-dashboard"></i> Certificate</a></li>
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
                    <th>RUT Asegurado</th>
                    <th>Asegurado</th>
                    <th>A favor de</th>
                    <th>Transporte</th>
                    <th>Tipo</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Via</th>
                    <th>Fecha Embarque</th>
                    <th>Transportista</th>
                    <th>Nave / Vuelo / Camión</th>
                    <th>B/L / AWB / CRT</th>
                    <th>Referencia / Despacho</th>
                    <th>Materia Asegurada</th>
                    <th>Tipo de Mercadería</th>
                    <th>Detalle Mercadería</th>
                    <th>Embalaje</th>
                    <th>Monto Asegurado</th>
                    <th>Tasa</th>
                    <th>Prima Mín.</th>
                    <th>Prima Seguro</th>
                    <th>Observaciones</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>RUT Asegurado</th>
                    <th>Asegurado</th>
                    <th>A favor de</th>
                    <th>Transporte</th>
                    <th>Tipo</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Via</th>
                    <th>Fecha Embarque</th>
                    <th>Transportista</th>
                    <th>Nave / Vuelo / Camión</th>
                    <th>B/L / AWB / CRT</th>
                    <th>Referencia / Despacho</th>
                    <th>Materia Asegurada</th>
                    <th>Tipo de Mercadería</th>
                    <th>Detalle Mercadería</th>
                    <th>Embalaje</th>
                    <th>Monto Asegurado</th>
                    <th>Tasa</th>
                    <th>Prima Mín.</th>
                    <th>Prima Seguro</th>
                    <th>Observaciones</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($certificados as $certificado): ?>
                    <tr data-id="<?php echo $certificado['ID_CERTIFICADO_SOLICITUD'] ?>">
                        <th><?php echo $n ?></th>
                        <?php
                        foreach ($asegurados as $asegurado):
                            if($asegurado['ID_ASEGURADO'] == $certificado['ID_ASEGURADO']):
                                echo '<td>' . utf8_encode($asegurado['IDENTIFICADOR']) . '</td>';
                                echo '<td>' . utf8_encode($asegurado['NOMBRE']) . '</td>';
                                break;
                            endif;
                        endforeach;
                        ?>
                        <td><?php echo $certificado['A_FAVOR_DE'] ?></td>
                        <td>
                            <?php
                            foreach ($polizas as $poliza):
                                if($poliza['ID_POLIZA'] == $certificado['ID_POLIZA']):
                                    echo utf8_encode($poliza['TIPO_POLIZA']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <td><?php echo $certificado['TIPO'] ?></td>
                        <td><?php echo $certificado['ORIGEN'] ?></td>
                        <td><?php echo $certificado['DESTINO'] ?></td>
                        <td><?php echo $certificado['VIA'] ?></td>
                        <td><?php echo $certificado['FECHA_EMBARQUE'] ?></td>
                        <td><?php echo $certificado['TRANSPORTISTA'] ?></td>
                        <td><?php echo $certificado['NAVE_VUELO_CAMION'] ?></td>
                        <td><?php echo $certificado['BL_AWB_CRT'] ?></td>
                        <td><?php echo $certificado['REFERENCIA_DESPACHO'] ?></td>
                        <td>
                            <?php
                            foreach ($materiasAseguradas as $materiaAsegurada):
                                if($materiaAsegurada['ID_MATERIA_ASEGURADA'] == $certificado['ID_MATERIA_ASEGURADA']):
                                    echo utf8_encode($materiaAsegurada['MATERIA_ASEGURADA']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <td>
                            <?php
                            foreach ($tipoMercaderias as $tipoMercaderia):
                                if($tipoMercaderia['ID_TIPO_MERCADERIA'] == $certificado['ID_TIPO_MERCADERIA']):
                                    echo utf8_encode($tipoMercaderia['TIPO_MERCADERIA']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <td><?php echo $certificado['DETALLE_MERCADERIA'] ?></td>
                        <td>
                            <?php
                            foreach ($embalajes as $embalaje):
                                if($embalaje['ID_EMBALAJE'] == $certificado['ID_EMBALAJE']):
                                    echo utf8_encode($embalaje['ID_EMBALAJE']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <td><?php echo $certificado['MONTO_ASEGURADO_CIF'] ?></td>
                        <td><?php echo $certificado['TASA'] ?></td>
                        <td><?php echo $certificado['PRIMA_MIN'] ?></td>
                        <td><?php echo $certificado['PRIMA_SEGURO'] ?></td>
                        <td><?php echo $certificado['OBSERVACIONES'] ?></td>

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

        var table = $('#tablaCertificateRequests').DataTable({
            "scrollX": true
        });

        $("#newCertificateRequest").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Certificate&action=newCertificateRequest',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaCertificateRequests").on("click", ".editCertificateRequest", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idCertificadoSolicitud: " + id);
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
                        url: 'ajax.php?controller=Certificate&action=deleteCertificateRequest',
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
                                window.location.href = "index.php?controller=Certificate&action=index";
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