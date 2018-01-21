<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Seguros
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Insurance</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Seguros</h3>
            <button id="newInsurance" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaSeguros" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Cliente</th>
                    <th>Asegurado</th>
                    <th>Fecha Solicitud</th>
                    <th>Monto Asegurado</th>
                    <th>Prima de Seguro</th>
                    <th>Prima Cliente</th>
                    <th>Prima Cia.</th>
                    <th>Profit Cliente</th>
                    <th>Comisión Corredor</th>
                    <th>Diferencia Equal</th>
                    <th>Ingreso Equal</th>
                    <th>Comisión Vendedor</th>
                    <th>Medio</th>
                    <th>Poliza</th>
                    <th>Transbordo</th>
                    <th>Tipo Mercadería</th>
                    <th>Despacho</th>
                    <th>Ejecutivo</th>
                    <th>Tasa Cliente</th>
                    <th>Tasa Cia.</th>
                    <th>Prima Mín. Cliente</th>
                    <th>Prima Mín. Cia.</th>
                    <th>Comisión</th>
                    <th>Certificado</th>
                    <th>Factura</th>
                    <th>Monto</th>
                    <th>Estado Equal</th>
                    <th>Estado Cia.</th>
                    <th>Estado Intermediario</th>
                    <th>Estado Ejecutivo</th>
                    <th>Siniestro</th>
                    <th>Motivo</th>
                    <th>Monto Provisión</th>
                    <th>Fecha Denuncia</th>
                    <th>Indemnización</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Cliente</th>
                    <th>Asegurado</th>
                    <th>Fecha Solicitud</th>
                    <th>Monto Asegurado</th>
                    <th>Prima de Seguro</th>
                    <th>Prima Cliente</th>
                    <th>Prima Cia.</th>
                    <th>Profit Cliente</th>
                    <th>Comisión Corredor</th>
                    <th>Diferencia Equal</th>
                    <th>Ingreso Equal</th>
                    <th>Comisión Vendedor</th>
                    <th>Medio</th>
                    <th>Poliza</th>
                    <th>Transbordo</th>
                    <th>Tipo Mercadería</th>
                    <th>Despacho</th>
                    <th>Ejecutivo</th>
                    <th>Tasa Cliente</th>
                    <th>Tasa Cia.</th>
                    <th>Prima Mín. Cliente</th>
                    <th>Prima Mín. Cia.</th>
                    <th>Comisión</th>
                    <th>Certificado</th>
                    <th>Factura</th>
                    <th>Monto</th>
                    <th>Estado Equal</th>
                    <th>Estado Cia.</th>
                    <th>Estado Intermediario</th>
                    <th>Estado Ejecutivo</th>
                    <th>Siniestro</th>
                    <th>Motivo</th>
                    <th>Monto Provisión</th>
                    <th>Fecha Denuncia</th>
                    <th>Indemnización</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($seguros as $seguro): ?>
                    <tr data-id="<?php echo $seguro['ID_SEGURO'] ?>">
                        <th><?php echo $n ?></th>
                        <td>
                            <?php
                            foreach ($clientes as $cliente):
                                if($cliente['ID_CLIENTE'] == $seguro['ID_CLIENTE']):
                                    echo utf8_encode($cliente['NOMBRE']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <td>
                            <?php
                            foreach ($asegurados as $asegurado):
                                if($asegurado['ID_ASEGURADO'] == $seguro['ID_ASEGURADO']):
                                    echo utf8_encode($asegurado['NOMBRE']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <td><?php echo $seguro['FECHA_SOLICITUD'] ?></td>
                        <td><?php echo $seguro['MONTO_ASEGURADO'] ?></td>
                        <td><?php echo $seguro['PRIMA_SEGURO'] ?></td>
                        <td><?php echo $seguro['PRIMA_CLIENTE'] ?></td>
                        <td><?php echo $seguro['PRIMA_COMPANIA'] ?></td>
                        <td><?php echo $seguro['PROFIT_CLIENTE'] ?></td>
                        <td><?php echo $seguro['COMISION_CORREDOR'] ?></td>
                        <td><?php echo $seguro['DIFERENCIA_EQUAL'] ?></td>
                        <td><?php echo $seguro['INGRESO_EQUAL'] ?></td>
                        <td><?php echo $seguro['COMISION_VENDENDOR'] ?></td>
                        <td>
                            <?php
                            foreach ($tipoPolizas as $tipoPoliza):
                                if($tipoPoliza['ID_POLIZA'] == $seguro['ID_POLIZA']):
                                    echo utf8_encode($tipoPoliza['TIPO_POLIZA']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <td><?php echo $seguro['POLIZA'] ?></td>
                        <?php
                        foreach ($certificados as $certificado):
                            if($certificado['ID_CERTIFICADO'] == $seguro['ID_CERTIFICADO']):
                                echo "<td title='". $certificado['FORMATO'] ."'>";
                                echo utf8_encode($certificado['NUMERO']);
                                echo "</td>";
                                break;
                            endif;
                        endforeach;
                        foreach ($facturas as $factura):
                            if($factura['ID_FACTURA'] == $seguro['ID_FACTURA']):
                                echo "<td title='". $factura['MONTO'] . " " . $factura['FORMATO'] ."'>";
                                echo utf8_encode($factura['NUMERO']);
                                echo "</td>";
                                break;
                            endif;
                        endforeach;
                        ?>
                        <td><?php echo $seguro['TRASBORDO'] ?></td>
                        <td>
                            <?php
                            foreach ($tipoMercaderias as $tipoMercaderia):
                                if($tipoMercaderia['ID_TIPO_MERCADERIA'] == $seguro['ID_TIPO_MERCADERIA']):
                                    echo utf8_encode($tipoMercaderia['TIPO_MERCADERIA']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <td><?php echo $seguro['DESPACHO'] ?></td>
                        <td>
                            <?php
                            foreach ($vendedores as $vendedor):
                                if($vendedor['ID_VENDEDOR'] == $seguro['ID_VENDEDOR']):
                                    echo utf8_encode($vendedor['NOMBRE']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <td><?php echo $seguro['TASA_CLIENTE'] ?></td>
                        <td><?php echo $seguro['PRIMA_MIN_CLIENTE'] ?></td>
                        <td><?php echo $seguro['PRIMA_MIN_COMPANIA'] ?></td>
                        <td><?php echo $seguro['COMISION'] ?></td>
                        <td>
                            <button data-original-title="Editar" class="btn btn-xs btn-default editInsurance">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteInsurance">
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

        var table = $('#tablaSeguros').DataTable({
            "scrollX": true
        });

        $("#newInsurance").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Insurance&action=newInsurance',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaSeguros").on("click", ".editInsurance", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idAsegurado: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Insurance&action=insuredEdit',
                'GET',
                { idAsegurado: id },
                defaultMessage);
            return false;
        }));

        $("#tablaSeguros").on("click", ".deleteInsurance" ,(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará el asegurado. ¿Está seguro? ',
                    ok: 'Eliminar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=Insurance&action=deleteInsurance',
                        data: { idAsegurado: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status == 'error') {
                                $("#messageInsurance").fadeOut( "slow", function() {
                                    $('#messageInsurance').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageInsurance").fadeOut( "slow", function() {
                                    $('#messageInsurance').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=Insurance&action=index";
                            }
                        },
                        error: function(data) {
                            $("#messageInsurance").fadeOut( "slow", function() {
                                $('#messageInsurance').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));


    } );
</script>