<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Clientes
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Client</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Clientes</h3>
            <button id="newClient" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaClientes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Rut</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Teléfono</th>
                    <th>Giro</th>
                    <th>Razón Social</th>
                    <th>Tasa</th>
                    <th>Prima Mín.</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>N°</th>
                    <th>Rut</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Teléfono</th>
                    <th>Giro</th>
                    <th>Razón Social</th>
                    <th>Tasa</th>
                    <th>Prima Mín.</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($clientes as $cliente): ?>
                    <tr data-id="<?php echo $cliente['ID_CLIENTE'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo $cliente['RUT'] ?></td>
                        <td><?php echo $cliente['NOMBRE'] ?></td>
                        <td><?php echo $cliente['DIRECCION'] ?></td>
                        <td><?php echo $cliente['CIUDAD'] ?></td>
                        <td><?php echo $cliente['TELEFONO'] ?></td>
                        <td><?php echo $cliente['GIRO'] ?></td>
                        <td><?php echo $cliente['RAZON_SOCIAL'] ?></td>
                        <td><?php echo $cliente['TASA'] ?></td>
                        <td><?php echo $cliente['PRIMA_MIN'] ?></td>
                        <td>
                            <button data-original-title="Editar" class="btn btn-xs btn-default editClient">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteClient">
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

        var table = $('#tablaClientes').DataTable();

        $("#newClient").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Client&action=newClient',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaClientes").on("click", ".editClient", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idCliente: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=Client&action=clientEdit',
                'GET',
                { idCliente: id },
                defaultMessage);
            return false;
        }));

        $("#tablaClientes").on("click", ".deleteClient" ,(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará el cliente. ¿Está seguro? ',
                    ok: 'Eliminar',
                    cancel: 'Cancelar'
                }, function () {

                    $.ajax({
                        type: 'GET',
                        url: 'ajax.php?controller=Client&action=deleteClient',
                        data: { idCliente: id },
                        beforeSend: function() {
                        },
                        success: function(data) {

                            if (data.status == 'error') {
                                $("#messageClient").fadeOut( "slow", function() {
                                    $('#messageClient').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageClient").fadeOut( "slow", function() {
                                    $('#messageClient').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=Client&action=index";
                            }
                        },
                        error: function(data) {
                            $("#messageClient").fadeOut( "slow", function() {
                                $('#messageClient').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));

    } );
</script>