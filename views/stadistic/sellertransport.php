<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}
$hoy = date('d-m-Y');
?>

<section class="content-header">

    <h1>
        Transporte Vendedor
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Seller Transport</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Transporte Vendedor</h3>

            <div class="row" style="margin-top: 20px;">

                <div class="col-sm-2 col-xs-6">

                    <div class="input-group">
                        <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                            <span><?php echo date('d-m-Y', strtotime($hoy. ' - 29 days')) . " al " . $hoy ?></span>
                            <i class="fa fa-caret-down"></i>
                        </button>
                    </div>

                </div>

                <div class="col-sm-10 col-xs-6">

                    <button id="filter" class="btn btn-primary" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Cargando">Filtrar</button>
                    &nbsp;
                    <button id="exportSellerTransportStadistic" class="btn btn-default" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Exportando"> <i class="fa fa-file-excel-o"></i> Exportar</button>

                </div>
            </div>

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

        </div>

        <div class="box-footer">

        </div>

    </div>

</section><!-- /.content -->

<script>
    $(function() {

        var startDate = "<?php echo date('d-m-Y', strtotime($hoy. ' - 29 days')) ?>";
        var endDate = "<?php echo date('d-m-Y') ?>";

        $('#daterange-btn').daterangepicker(
            {
                ranges   : {
                    'Hoy'               : [moment(), moment()],
                    'Ayer'              : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 días'    : [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 días'   : [moment().subtract(29, 'days'), moment()],
                    'Este mes'          : [moment().startOf('month'), moment().endOf('month')],
                    'Mes anterior'      : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate  : moment(),
                opens: 'right'
            },
            function (start, end) {
                $('#daterange-btn span').html(start.format('DD-MM-YYYY') + ' al ' + end.format('DD-MM-YYYY'));
                startDate = start;
                endDate = end;
            }
        );


        $("#filter").click(function() {

            var fecha1 = $('#daterange-btn').data('daterangepicker').startDate.format('DD-MM-YYYY');
            var fecha2 = $('#daterange-btn').data('daterangepicker').endDate.format('DD-MM-YYYY');
            var fecha = fecha1 + ' al ' + fecha2;
            console.log(fecha);

            var button = $('#filter');

            $.ajax({
                type: 'GET',
                url: 'ajax.php?controller=Stadistic&action=sellertransportContent',
                data: { fecha: fecha },
                beforeSend: function() {
                    button.button('loading');
                },
                success: function(data) {
                    console.log(data);
                    $('.box-body').html(data);
                    button.button('reset');
                },
                error: function(data) {
                    $("#messageInsured").fadeOut( "slow", function() {
                        $('#messageInsured').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                    });
                    button.button('reset');
                }
            });

            return false;

        });

        $("#exportSellerTransportStadistic").click(function() {

            var button = $(this);
            var url='ajax.php?controller=Export&action=ExportSellerTransport';
            $.ajax({
                type:'POST',
                url: url,
                data: {},
                dataType:'json',
                beforeSend: function() {
                    console.log("before");
                    button.button('loading');
                }
            }).done(function(data){
                var $a = $("<a>");
                $a.attr("href",data.file);
                $("body").append($a);
                $a.attr("download","EstadisticaVendedores.xls");
                $a[0].click();
                $a.remove();

                button.button('reset');
            });

        });

        $("#filter").trigger("click");

    } );
</script>