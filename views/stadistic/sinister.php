<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}
$hoy = date('d-m-Y');
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
                    <button id="exportSinisterStadistic" class="btn btn-default" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Exportando"> <i class="fa fa-file-excel-o"></i> Exportar</button>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-1 col-xs-6"></div>
                <div class="col-sm-2 col-xs-6">
                    <div class="description-block border-right">
                        <h5 class="description-header" id="numeroCertificados"><?php echo $numeroCertificados; ?></h5>
                        <span class="description-text">CERTIFICADOS</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-2 col-xs-6">
                    <div class="description-block border-right">
                        <h5 class="description-header" id="montoAsegurado"><?php echo $montoAsegurado; ?></h5>
                        <span class="description-text">MONTO ASEGURADO</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-2 col-xs-6">
                    <div class="description-block border-right">
                        <h5 class="description-header" id="primaSeguro"><?php echo $primaSeguro; ?></h5>
                        <span class="description-text">PRIMA DE SEGURO</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-2 col-xs-6">
                    <div class="description-block">
                        <h5 class="description-header" id="montoProvision"><?php echo $montoProvision; ?></h5>
                        <span class="description-text">MONTO PROVISIÓN</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <div class="col-sm-2 col-xs-6">
                    <div class="description-block">
                        <h5 class="description-header" id="indemnizacion"><?php echo $indemnizacion; ?></h5>
                        <span class="description-text">INDEMNIZACIÓN</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <div class="col-sm-1 col-xs-6"></div>
            </div>
            <!-- /.row -->

        </div>

        <div class="box-body" id="infoSinister">

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
                url: 'ajax.php?controller=Stadistic&action=sinisterContent',
                data: { fecha: fecha },
                beforeSend: function() {
                    button.button('loading');
                },
                success: function(data) {
                    console.log(data);
                    //debugger;
                    //var dataContent = data.find(".box-body");
                    //$('.content').html(data);
                    $('.box-body').html(data);
                    /*if (data.status === 'error') {
                        $("#messageInsured").fadeOut( "slow", function() {
                            $('#messageInsured').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                        });
                    } else {
                        $("#messageInsured").fadeOut( "slow", function() {
                            $('#messageInsured').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                        });
                        //window.location.href = "index.php?controller=Insured&action=index";
                    }*/
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

        $("#exportSinisterStadistic").click(function() {

            var fecha1 = $('#daterange-btn').data('daterangepicker').startDate.format('DD-MM-YYYY');
            var fecha2 = $('#daterange-btn').data('daterangepicker').endDate.format('DD-MM-YYYY');
            var fecha = fecha1 + ' al ' + fecha2;
            console.log(fecha);

            var button = $('#exportSinisterStadistic');

            var url='ajax.php?controller=Export&action=ExportSinisterStadistic';
            $.ajax({
                type:'POST',
                url: url,
                data: { fecha: fecha },
                dataType:'json',
                beforeSend: function() {
                    console.log("before");
                    button.button('loading');
                }
            }).done(function(data){
                var $a = $("<a>");
                $a.attr("href",data.file);
                $("body").append($a);
                $a.attr("download","EstadisticaSiniestros.xls");
                $a[0].click();
                $a.remove();

                button.button('reset');
            });

        });


        $("#tablaSiniestros").on("click", ".editSinister", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idSiniestro: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Stadistic&action=sinisterEdit',
                'GET',
                { idSiniestro: id },
                defaultMessage);
            return false;
        }));

        $("#filter").trigger("click");

    } );
</script>