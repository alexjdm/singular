<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Usuarios
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> User</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista de Usuarios</h3>
            <button id="newUser" class="btn btn-primary" style="float: right;">Agregar</button>
        </div>

        <div class="box-body">
            <table id="tablaUsuarios" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
                <?php foreach ($usuarios as $usuario): ?>
                    <tr data-id="<?php echo $usuario['ID_USUARIO'] ?>">
                        <th><?php echo $n ?></th>
                        <td><?php echo $usuario['IDENTIFICADOR'] ?></td>
                        <td><?php echo $usuario['NOMBRE'] ?></td>
                        <td><?php echo $usuario['APELLIDO'] ?></td>
                        <td><?php echo $usuario['CORREO_ELECTRONICO'] ?></td>
                        <td>
                        <?php
                        foreach ($cargos as $cargo):
                            if($cargo['ID_CARGO'] == $usuario['ID_CARGO']):
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
                            if($corredora['ID_CORREDORA'] == $usuario['ID_CORREDORA']):
                                echo utf8_encode($corredora['NOMBRE']);
                                break;
                            endif;
                        endforeach;
                        ?>
                        </td>
                        <td>
                            <button data-original-title="Editar" class="btn btn-xs btn-default editUser">
                                <i class="fa fa-pencil"></i>
                            </button>
                            &nbsp
                            <button data-original-title="Eliminar" class="btn btn-xs btn-default deleteUser">
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

        var table = $('#listaUsuarios').DataTable();

        $("#newUser").click(function() {
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=User&action=newUser',
                'GET',
                {  },
                defaultMessage);
            return false;
        });

        $("#tablaUsuarios").on("click", ".editUser", (function() {
            var id = $(this).closest('tr').data("id"); console.debug("idUsuario: " + id);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=User&action=userEdit',
                'GET',
                { idUsuario: id },
                defaultMessage);
            return false;
        }));

        $("#tablaUsuarios").on("click", ".deleteUser" ,(function () {
            var id = $(this).closest('tr').data("id"); console.debug(id);
            showConfirmation($('#modalConfirmacion'),
                {
                    title: '¿ Está seguro ?',
                    message: 'Esta acción eliminará la compañia. ¿Está seguro? ',
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
                                $("#messageUser").fadeOut( "slow", function() {
                                    $('#messageUser').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                                });
                            } else {
                                $("#messageUser").fadeOut( "slow", function() {
                                    $('#messageUser').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                                });
                                window.location.href = "index.php?controller=User&action=index";
                            }
                        },
                        error: function(data) {
                            $("#messageUser").fadeOut( "slow", function() {
                                $('#messageUser').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                            });
                        }
                    });
                });
        }));

    } );
</script>