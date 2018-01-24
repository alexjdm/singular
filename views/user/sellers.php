<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Vendedores
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Seller</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Vendedores</h3>
            <button id="newSeller" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaVendedores" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Rut</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Cargo</th>
                    <th>Perfil</th>
                    <th>Corredora</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Rut</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Cargo</th>
                    <th>Perfil</th>
                    <th>Corredora</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($vendedores as $vendedor): ?>
                    <tr data-id="<?php echo $vendedor['ID_USUARIO'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo $vendedor['IDENTIFICADOR'] ?></td>
                        <td><?php echo $vendedor['NOMBRE'] ?></td>
                        <td><?php echo $vendedor['APELLIDO'] ?></td>
                        <td><?php echo $vendedor['CORREO_ELECTRONICO'] ?></td>
                        <td>
                            <?php
                            foreach ($cargos as $cargo):
                                if($cargo['ID_CARGO'] == $vendedor['ID_CARGO']):
                                    echo utf8_encode($cargo['NOMBRE']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <td>
                            <?php
                            foreach ($perfiles as $perfil):
                                if($perfil['ID_PERFIL'] == $usuario['ID_PERFIL']):
                                    echo utf8_encode($perfil['NOMBRE_PERFIL']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <td>
                            <?php
                            foreach ($corredoras as $corredora):
                                if($corredora['ID_CORREDORA'] == $vendedor['ID_CORREDORA']):
                                    echo utf8_encode($corredora['NOMBRE']);
                                    break;
                                endif;
                            endforeach;
                            ?>
                        </td>
                        <td>
                            <button data-original-title="Editar" class="btn btn-xs btn-default editSeller">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteSeller">
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

        var table = $('#tablaVendedores').DataTable();

        $("#newSeller").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=User&action=newSeller',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaVendedores").on("click", ".editSeller", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idVendedor: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=User&action=sellerEdit',
                'GET',
                { idVendedor: id },
                defaultMessage);
            return false;
        }));

        $("#tablaVendedores").on("click", ".deleteSeller" ,(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará al vendedor. ¿Está seguro? ',
                    ok: 'Eliminar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=User&action=deleteUser',
                        data: { idUsuario: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status === 'error') {
                                $("#messageSeller").fadeOut( "slow", function() {
                                    $('#messageSeller').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageSeller").fadeOut( "slow", function() {
                                    $('#messageSeller').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=User&action=index";
                            }
                        },
                        error: function(data) {
                            $("#messageSeller").fadeOut( "slow", function() {
                                $('#messageSeller').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));


    } );
</script>