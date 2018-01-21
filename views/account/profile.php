<?php

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<section class="content-header">

    <h1>
        Perfil de usuario
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Account</a></li>
        <li class="active">profile</li>
    </ol>

</section>

<section class="content">

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="dist/img/user2-160x160.jpg" alt="User profile picture">

                    <h3 class="profile-username text-center"><?php echo $currentUser['nombre'] . ' ' . $currentUser['apellido'] ?></h3>

                    <p class="text-muted text-center">
                        <?php

                            foreach ($perfiles as $perfil)
                            {
                                if($perfil['ID_PERFIL'] == $currentUser['idPerfil'])
                                {
                                    echo $perfil['NOMBRE_PERFIL'];
                                    break;
                                }
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#personalData" data-toggle="tab">Datos</a></li>
                </ul>
                <div class="tab-content">

                    <div class="active tab-pane" id="personalData">

                        <input type="hidden" id="idUsuario" value="<?php echo $currentUser['id'] ?>">

                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="rut" class="col-sm-2 control-label">RUT</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="rut" placeholder="RUT" value="<?php echo $currentUser['identificador'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="correo" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="correo" placeholder="Email" value="<?php echo $currentUser['correo'] ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nombre" class="col-sm-2 control-label">Nombre</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nombre" placeholder="Nombre" value="<?php echo $currentUser['nombre'] ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="apellido" class="col-sm-2 control-label">Apellido</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="apellido" placeholder="Apellido" value="<?php echo $currentUser['apellido'] ?>">
                                </div>
                            </div>

                            <div class="form-group">

                                <label for="password" class="col-sm-2 control-label">Contraseña</label>

                                <div class="col-sm-10">
                                    <button id="changePassword" class="btn btn-danger">Cambiar Contraseña</button>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" id="saveUserEdit" class="btn btn-primary" style="float: right;">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    $(function() {

        $('#saveUserEdit').click(function(){
            var e = 'ajax.php?controller=User&action=userEdit2db';
            var idUsuario = $("#idUsuario").val();
            var nombre = $("#nombre").val();
            var apellido = $("#apellido").val();
            var correo = $("#correo").val();

            $.ajax({
                type: 'GET',
                url: e,
                data: { idUsuario: idUsuario, nombre: nombre, apellido: apellido, correo: correo },
                dataType : "json",
                beforeSend: function () {
                    $('#saveUserEdit').html("Cargando...");
                },
                success: function (data) {
                    console.debug("success");
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        console.debug("Login ok");
                        $('#messageEditUser').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#saveUserEdit').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                        $('#modalPrincipal').hide();
                        window.location.href = "index.php?controller=Account&action=profile";
                    }
                    else{
                        console.debug("Login fail");
                        $('#saveUserEdit').html("Guardar");
                        $('#messageEditUser').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    }
                },
                error: function (data) {
                    console.debug("error");
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#saveUserEdit').html("Guardar");
                    $('#messageEditUser').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                }
            });

            return false;
        });

        $('#changePassword').click(function(){

            var idUsuario = $("#idUsuario").val(); //console.debug(idUsuario);
            ajax_loadModal($('#modalPrincipal'),
                'ajax.php?controller=User&action=changePassword',
                'GET',
                { idUsuario: idUsuario },
                defaultMessage);

            return false;
        });

    } );
</script>