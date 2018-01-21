<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

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
            <table id="tablaAsegurados" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Rut</th>
                    <th>Nombre</th>
                    <th>Giro</th>
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
                    <th>N°</th>
                    <th>Rut</th>
                    <th>Nombre</th>
                    <th>Giro</th>
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
                <?php foreach ($asegurados as $asegurado): ?>
                    <tr data-id="<?php echo $asegurado['ID_ASEGURADO'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo $asegurado['IDENTIFICADOR'] ?></td>
                        <td><?php echo $asegurado['NOMBRE'] ?></td>
                        <td><?php echo $asegurado['GIRO'] ?></td>
                        <td>
                            <?php
                            foreach ($regiones as $region):
                                if($region['ID_REGION'] == $asegurado['ID_REGION']):
                                    echo utf8_encode($region['NOMBRE']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <td>
                            <?php
                            foreach ($comunas as $comuna):
                                if($comuna['ID_COMUNA'] == $asegurado['ID_COMUNA']):
                                    echo utf8_encode($comuna['NOMBRE']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <td><?php echo $asegurado['DIRECCION'] ?></td>
                        <td>
                            <?php
                            if($asegurado['ESTADO'] == 0)
                            {
                                echo "No Ingresado";
                            }
                            else if ($asegurado['ESTADO'] == 1)
                            {
                                echo "Ingresado";
                            }
                            else
                            {
                                echo "Desconocido";
                            }
                            ?>
                        </td>
                        <?php if($isSuperAdmin): ?>
                        <td>
                            <?php
                            foreach ($usuarios as $usuario):
                                if($usuario['ID_USUARIO'] == $asegurado['ID_USUARIO_CREADOR']):
                                    echo utf8_encode($usuario['NOMBRE'] . ' ' . $usuario['APELLIDO']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <?php endif; ?>
                        <td>
                            <?php if($isSuperAdmin): ?>
                                <?php
                                if($asegurado['ESTADO'] == 0)
                                {
                                    echo '<button title="Ingresado" class="btn btn-xs btn-default validateInsured"><i class="fa fa-check"></i></button>';
                                }
                                else if ($asegurado['ESTADO'] == 1)
                                {
                                    echo '<button title="No Ingresado" class="btn btn-xs btn-default invalidateInsured"><i class="fa fa-times"></i></button>';
                                }
                                else
                                {
                                    echo '<button title="Ingresado" class="btn btn-xs btn-default validateInsured"><i class="fa fa-check"></i></button>';
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

</section><!-- /.content -->

<script>
    $(function() {

        var table = $('#tablaAsegurados').DataTable();

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

                    if (data.status == 'error') {
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

                    if (data.status == 'error') {
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

                            if (data.status == 'error') {
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