<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

$isSuperAdmin = isSuperAdmin();

?>

<section class="content-header">

    <h1>
        Asegurados
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Insured</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Asegurados</h3>
            <button id="newInsured" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">

            <div class="row" style="margin-top: 10px;">

                <div class="col-sm-6 col-xs-6">

                    <!--<div class="btn-group">
                        <button type="button" class="btn btn-default">Estado</button>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Ingresado</a></li>
                            <li><a href="#">No ingresado</a></li>
                        </ul>
                    </div>-->

                    <p>Aprobar todos los asegurados en estado: No ingresado</p>
                    <button id="aprobarTodos" class="btn btn-primary" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Cargando">Aprobar todos</button>

                    <!--<button id="filter" class="btn btn-primary" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Cargando">Filtrar</button>-->

                </div>
            </div>

            <div class="row" style="margin-top: 20px; padding: 0 20px;">

                <table id="tablaAsegurados" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <!--<th></th>-->
                        <th>N°</th>
                        <th>Rut</th>
                        <th>Nombre</th>
                        <th>Región</th>
                        <th>Comuna</th>
                        <th>Dirección</th>
                        <th>Estado</th>
                        <?php if($isSuperAdmin == true): ?>
                            <th>Creado Por</th>
                        <?php endif; ?>
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <!--<th></th>-->
                        <th>N°</th>
                        <th>Rut</th>
                        <th>Nombre</th>
                        <th>Región</th>
                        <th>Comuna</th>
                        <th>Dirección</th>
                        <th>Estado</th>
                        <?php if($isSuperAdmin == true): ?>
                            <th>Creado Por</th>
                        <?php endif; ?>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php $n = 1; ?>
                    <?php foreach ($aseguradosVM as $asegurado): ?>
                        <tr data-id="<?php echo $asegurado['ID_ASEGURADO'] ?>">
                            <!--<td></td>-->
                            <td><?php echo $n ?></td>
                            <td><?php echo $asegurado['IDENTIFICADOR'] ?></td>
                            <td><?php echo $asegurado['NOMBRE'] ?></td>
                            <td><?php echo $asegurado['REGION'] ?></td>
                            <td><?php echo $asegurado['COMUNA'] ?></td>
                            <td><?php echo $asegurado['DIRECCION'] ?></td>
                            <td><?php echo $asegurado['ESTADO'] ?></td>
                            <?php if($isSuperAdmin): ?>
                                <td><?php echo $asegurado['USUARIO'] ?></td>
                            <?php endif; ?>
                            <td style="width: 100px;">
                                <?php if($isSuperAdmin): ?>
                                    <?php
                                    if($asegurado['ESTADO'] == "No Ingresado")
                                    {
                                        echo '<button title="Ingresar" class="btn btn-xs btn-default validateInsured"><i class="fa fa-check"></i></button>';
                                    }
                                    else if ($asegurado['ESTADO'] == "Ingresado")
                                    {
                                        echo '<button title="No Ingresar" class="btn btn-xs btn-default invalidateInsured"><i class="fa fa-times"></i></button>';
                                    }
                                    else
                                    {
                                        echo '<button title="Ingresar" class="btn btn-xs btn-default validateInsured"><i class="fa fa-check"></i></button>';
                                    }
                                    ?>
                                    &nbsp
                                <?php endif; ?>
                                <?php if($asegurado['ESTADO'] == 0 || $isSuperAdmin == true): ?>
                                    <button data-original-title="Editar" class="btn btn-xs btn-default editInsured">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    &nbsp
                                    <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteInsured">
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

    </div>

</section><!-- /.content -->

<script>
    $(function() {

        var table = $('#tablaAsegurados').DataTable({
            scrollX: true,
            columnDefs: [
                {
                    targets: 0,
                    checkboxes: {
                        seletRow: true
                    }
                }
            ],
            select:{
                style: 'multi'
            },
            order: [[0, 'asc']]
        });


        $("#newInsured").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Insured&action=newInsured',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaAsegurados").on("click", ".validateInsured", (function() {
            var id = $(this).closest('tr').data("id"); //console.debug("idAsegurado: " + id);

            $.ajax({
                type: 'GET',
                url: 'ajax.php?controller=Insured&action=validateInsured',
                data: { idAsegurado: id },
                beforeSend: function() {
                },
                success: function(data) {

                    if (data.status === 'error') {
                        $("#messageInsured").fadeOut( "slow", function() {
                            $('#messageInsured').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                        });
                    } else {
                        $("#messageInsured").fadeOut( "slow", function() {
                            $('#messageInsured').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                        });
                        window.location.href = "index.php?controller=Insured&action=index";
                    }
                },
                error: function(data) {
                    $("#messageInsured").fadeOut( "slow", function() {
                        $('#messageInsured').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                    });
                }
            });

            return false;
        }));

        $("#tablaAsegurados").on("click", ".invalidateInsured", (function() {
            var id = $(this).closest('tr').data("id"); //console.debug("idAsegurado: " + id);

            $.ajax({
                type: 'GET',
                url: 'ajax.php?controller=Insured&action=invalidateInsured',
                data: { idAsegurado: id },
                beforeSend: function() {
                },
                success: function(data) {

                    if (data.status === 'error') {
                        $("#messageInsured").fadeOut( "slow", function() {
                            $('#messageInsured').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                        });
                    } else {
                        $("#messageInsured").fadeOut( "slow", function() {
                            $('#messageInsured').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                        });
                        window.location.href = "index.php?controller=Insured&action=index";
                    }
                },
                error: function(data) {
                    $("#messageInsured").fadeOut( "slow", function() {
                        $('#messageInsured').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                    });
                }
            });

            return false;
        }));

        $("#tablaAsegurados").on("click", ".editInsured", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idAsegurado: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Insured&action=insuredEdit',
                'GET',
                { idAsegurado: id },
                defaultMessage);
            return false;
        }));

        $("#aprobarTodos").click(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción aprobará todos los asegurados pendientes. ¿Está seguro? ',
                    ok: 'Aprobar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=Insured&action=approveAllInsured',
                        data: { },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status === 'error') {
                                $("#messageInsured").fadeOut( "slow", function() {
                                    $('#messageInsured').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageInsured").fadeOut( "slow", function() {
                                    $('#messageInsured').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=Insured&action=index";
                            }
                        },
                        error: function(data) {
                            $("#messageInsured").fadeOut( "slow", function() {
                                $('#messageInsured').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        });

        $("#tablaAsegurados").on("click", ".deleteInsured" ,(function () {
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
                        url: 'ajax.php?controller=Insured&action=deleteInsured',
                        data: { idAsegurado: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status === 'error') {
                                $("#messageInsured").fadeOut( "slow", function() {
                                    $('#messageInsured').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageInsured").fadeOut( "slow", function() {
                                    $('#messageInsured').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=Insured&action=index";
                            }
                        },
                        error: function(data) {
                            $("#messageInsured").fadeOut( "slow", function() {
                                $('#messageInsured').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));


    } );
</script>