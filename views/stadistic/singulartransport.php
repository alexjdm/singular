<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}
$hoy = date('d-m-Y');
?>

<section class="content-header">

    <h1>
        Transporte Singular
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Singular Transport</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Transporte Singular</h3>


            <div class="row">
                <div class="col-sm-1 col-xs-6"></div>
                <div class="col-sm-1 col-xs-6">
                    <div class="description-block border-right">
                        <h5 class="description-header"><?php echo $numeroCertificados; ?></h5>
                        <span class="description-text">CERTIFICADOS</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-1 col-xs-6">
                    <div class="description-block border-right">
                        <h5 class="description-header"><?php echo $montoAsegurado; ?></h5>
                        <span class="description-text">MONTO ASEGURADO</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-1 col-xs-6">
                    <div class="description-block border-right">
                        <h5 class="description-header"><?php echo $primaSeguro; ?></h5>
                        <span class="description-text">PRIMA DE SEGURO</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-1 col-xs-6">
                    <div class="description-block">
                        <h5 class="description-header"><?php echo $primaCliente; ?></h5>
                        <span class="description-text">PRIMA CLIENTE</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <div class="col-sm-1 col-xs-6">
                    <div class="description-block">
                        <h5 class="description-header"><?php echo $primaCia; ?></h5>
                        <span class="description-text">PRIMA COMPAÑÍA</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <div class="col-sm-1 col-xs-6">
                    <div class="description-block">
                        <h5 class="description-header"><?php echo $difCliente; ?></h5>
                        <span class="description-text">DIFERENCIA CLIENTE</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <div class="col-sm-1 col-xs-6">
                    <div class="description-block">
                        <h5 class="description-header"><?php echo $comisionCorredor; ?></h5>
                        <span class="description-text">COMISIÓN CORREDOR</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <div class="col-sm-1 col-xs-6">
                    <div class="description-block">
                        <h5 class="description-header"><?php echo $difEqual; ?></h5>
                        <span class="description-text">DIFERENCIA EQUAL</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <div class="col-sm-1 col-xs-6">
                    <div class="description-block">
                        <h5 class="description-header"><?php echo $ingresoEqual; ?></h5>
                        <span class="description-text">INGRESO EQUAL</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <div class="col-sm-1 col-xs-6">
                    <div class="description-block">
                        <h5 class="description-header"><?php echo $comisionVendedor; ?></h5>
                        <span class="description-text">COMISIÓN VENDEDOR</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <div class="col-sm-1 col-xs-6"></div>
            </div>
            <!-- /.row -->


        </div>

        <div class="box-body">
            <table id="tablaSiniestros" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Cliente</th>
                    <th>Asegurado</th>
                    <th>Mes</th>
                    <th>Fecha Solicitud</th>
                    <th>Monto Asegurado</th>
                    <th>Prima Seguro</th>
                    <th>Prima Cliente</th>
                    <th>Prima Compañía</th>
                    <th>Profit Cliente</th>
                    <th>Comisión Corredor</th>
                    <th>Diferencia Equal</th>
                    <th>Ingreso Equal</th>
                    <th>Comisión Vendedor</th>
                    <th>Medio</th>
                    <th>Poliza</th>
                    <th>Número Certificado</th>
                    <th>Transbordo</th>
                    <th>Tipo Mercadería</th>
                    <th>Ejecutivo</th>
                    <th>Certificado</th>
                    <th>Factura</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Cliente</th>
                    <th>Asegurado</th>
                    <th>Mes</th>
                    <th>Fecha Solicitud</th>
                    <th>Monto Asegurado</th>
                    <th>Prima Seguro</th>
                    <th>Prima Cliente</th>
                    <th>Prima Compañía</th>
                    <th>Profit Cliente</th>
                    <th>Comisión Corredor</th>
                    <th>Diferencia Equal</th>
                    <th>Ingreso Equal</th>
                    <th>Comisión Vendedor</th>
                    <th>Medio</th>
                    <th>Poliza</th>
                    <th>Número Certificado</th>
                    <th>Transbordo</th>
                    <th>Tipo Mercadería</th>
                    <th>Ejecutivo</th>
                    <th>Certificado</th>
                    <th>Factura</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($transportesVM as $transporteVM): ?>
                    <tr data-id="<?php echo $transporteVM['ID_CERTIFICADO'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo $transporteVM['CLIENTE'] ?></td>
                        <td><?php echo $transporteVM['ASEGURADO'] ?></td>
                        <td><?php echo $transporteVM['MES'] ?></td>
                        <td><?php echo $transporteVM['FECHA_SOLICITUD'] ?></td>
                        <td><?php echo $transporteVM['MONTO_ASEGURADO'] ?></td>
                        <td><?php echo $transporteVM['PRIMA_SEGURO'] ?></td>
                        <td><?php echo $transporteVM['PRIMA_CLIENTE'] ?></td>
                        <td><?php echo $transporteVM['PRIMA_CIA'] ?></td>
                        <td><?php echo $transporteVM['PROFIT_CLIENTE'] ?></td>
                        <td><?php echo $transporteVM['COMISION_CORREDORA'] ?></td>
                        <td><?php echo $transporteVM['DIFERENCIA_EQUAL'] ?></td>
                        <td><?php echo $transporteVM['INGRESO_EQUAL'] ?></td>
                        <td><?php echo $transporteVM['COMISION_VENDEDORA'] ?></td>
                        <td><?php echo $transporteVM['MEDIO'] ?></td>
                        <td><?php echo $transporteVM['POLIZA'] ?></td>
                        <td><?php echo $transporteVM['NUMERO_CERTIFICADO'] ?></td>
                        <td><?php echo $transporteVM['TRANSBORDO'] ?></td>
                        <td><?php echo $transporteVM['TIPO_MERCADERIA'] ?></td>
                        <td><?php echo $transporteVM['EJECUTIVO'] ?></td>
                        <td><?php echo $transporteVM['CERTIFICADO'] ?></td>
                        <td><?php echo $transporteVM['FACTURA'] ?></td>

                        <td style="width: 70px;">
                            <button data-original-title="Editar" class="btn btn-xs btn-default editSellerTransport">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteSellerTransport">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>
                    <?php $n++; ?>
                <?php endforeach; ?>
                </tbody>

            </table>
        </div>

        <div class="box-footer">

        </div>

    </div>

</section><!-- /.content -->

<script>
    $(function() {

        var table = $('#tablaSiniestros').DataTable({
            "scrollX": true
        });

        $("#newSellerTransport").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=SellerTransport&action=newSellerTransport',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaSiniestros").on("click", ".editSellerTransport", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idSiniestro: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=SellerTransport&action=SellerTransportEdit',
                'GET',
                { idSiniestro: id },
                defaultMessage);
            return false;
        }));

        $("#tablaSiniestros").on("click", ".deleteSellerTransport" ,(function () {
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
                        url: 'ajax.php?controller=SellerTransport&action=deleteSellerTransport',
                        data: { idSiniestro: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status === 'error') {
                                $("#messageSellerTransport").fadeOut("slow", function() {
                                    $('#messageSellerTransport').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageSellerTransport").fadeOut("slow", function() {
                                    $('#messageSellerTransport').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=SellerTransport&action=index";
                            }
                        },
                        error: function(data) {
                            $( "#messageSellerTransport" ).fadeOut( "slow", function() {
                                $('#messageSellerTransport').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));


    } );
</script>