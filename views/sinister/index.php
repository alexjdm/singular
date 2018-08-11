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
                    <th>RUT</th>
                    <th>Nombre</th>
                    <th>Motivo</th>
                    <th>Nombre Contacto</th>
                    <!--<th>Cargo</th>-->
                    <th>Teléfono</th>
                    <th>Correo</th>
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
                    <th>Motivo</th>
                    <th>Nombre Contacto</th>
                    <!--<th>Cargo</th>-->
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($siniestros as $siniestro): ?>
                    <tr data-id="<?php echo $siniestro['ID_SINIESTRO'] ?>">
                        <th><?php echo $n ?></th>
                        <?php
                        $idCertificado = 0;
                        $idAsegurado = 0;
                        foreach ($certificados as $certificado):
                            if($certificado['ID_CERTIFICADO'] == $siniestro['ID_CERTIFICADO']):
                                echo "<td>";
                                foreach ($polizas as $poliza):
                                    if($certificado['ID_POLIZA'] == $poliza['ID_POLIZA']):
                                        echo utf8_encode($poliza['TIPO_POLIZA'] . " (" . $poliza['NUMERO'] . ")");
                                        break;
                                    endif;
                                endforeach;
                                echo "</td>";
                                $idCertificado = $certificado['ID_CERTIFICADO'];
                                $idAsegurado = $certificado['ID_ASEGURADO'];
                                break;
                            endif;
                        endforeach;

                        foreach ($certificados as $certificado):
                            if($certificado['ID_CERTIFICADO'] == $idCertificado):
                                echo "<td>";
                                echo utf8_encode($certificado['NUMERO']);
                                echo "</td>";
                                break;
                            endif;
                        endforeach;

                        foreach ($asegurados as $asegurado):
                            if($asegurado['ID_ASEGURADO'] == $idAsegurado):
                                echo "<td>";
                                echo utf8_encode($asegurado['IDENTIFICADOR']);
                                echo "</td>";
                                echo "<td>";
                                echo utf8_encode($asegurado['NOMBRE']);
                                echo "</td>";
                                break;
                            endif;
                        endforeach;
                        ?>
                        <td><?php echo $siniestro['MOTIVO'] ?></td>
                        <td><?php echo $siniestro['NOMBRE'] ?></td>
                        <!--<td><?php echo $siniestro['CARGO'] ?></td>-->
                        <td><?php echo $siniestro['TELEFONO'] ?></td>
                        <td><?php echo $siniestro['CORREO'] ?></td>
                        <td style="width: 70px;">
                            <button data-original-title="Editar" class="btn btn-xs btn-default editSinister">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteSinister">
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