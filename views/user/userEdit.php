<style>
    .form-group{
        padding: 15px;
    }
</style>

<div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Editar Usuario</h4>
        </div>
        <div class="modal-body" style="max-height: 600px; overflow-y: auto;">
            <input id="idUsuario" value="<?php echo $usuario['ID_USUARIO'] ?>" type="hidden">
            <div class="form-group">
                    <label class="col-sm-3 control-label" for="identificador">RUT</label>
                <div class="col-sm-9">
                    <input class="form-control" id="identificador" type="text" value="<?php echo $usuario['IDENTIFICADOR'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="nombre">Nombre</label>
                <div class="col-sm-9">
                    <input class="form-control" id="nombre" type="text" value="<?php echo $usuario['NOMBRE'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="apellido">Apellido</label>
                <div class="col-sm-9">
                    <input class="form-control" id="apellido" type="text" value="<?php echo $usuario['APELLIDO'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="correo">Correo</label>
                <div class="col-sm-9">
                    <input class="form-control" id="correo" type="correo" value="<?php echo $usuario['CORREO_ELECTRONICO'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="idCargo">Cargo</label>
                <div class="col-sm-9">
                    <select id="idCargo" class="form-control">
                        <?php foreach ($cargos as $cargo): ?>
                            <option value="<?php echo $cargo['ID_CARGO']; ?>" <?php if($cargo['ID_CARGO'] == $usuario['ID_CARGO']) { echo "selected"; } ?>><?php echo utf8_encode($cargo['NOMBRE']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="idPerfil">Perfil</label>
                <div class="col-sm-9">
                    <select id="idPerfil" class="form-control">
                        <?php foreach ($perfiles as $perfil): ?>
                            <option value="<?php echo $perfil['ID_PERFIL']; ?>" <?php if($perfil['ID_PERFIL'] == $usuario['ID_PERFIL']) { echo "selected"; } ?>><?php echo utf8_encode($perfil['NOMBRE_PERFIL']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="idCorredora">Corredora</label>
                <div class="col-sm-9">
                        <select id="idCorredora" class="form-control">
                        <?php foreach ($corredoras as $corredora): ?>
                            <option value="<?php echo $corredora['ID_CORREDORA']; ?>" <?php if($corredora['ID_CORREDORA'] == $usuario['ID_CORREDORA']) { echo "selected"; } ?>><?php echo utf8_encode($corredora['NOMBRE']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">

                <label for="password" class="col-sm-3 control-label">Contraseña</label>

                <div class="col-sm-9">
                    <button id="changePassword" class="btn btn-danger">Cambiar Contraseña</button>
                </div>
            </div>
            <br>
            <div id="messageEditUser"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            <!--<?php if ($usuario['HABILITADO'] == 1) { ?>
                <button type="button" class="btn btn-primary" id="toggleDesactivar">Desactivar</button>
            <?php } else if ($usuario['HABILITADO'] == 0) { ?>
                <button type="button" class="btn btn-primary" id="toggleActivar">Activar</button>
            <?php } ?>-->

            <button id="saveUserEdit" type="button" class="btn btn-primary">Guardar</button>

        </div>
    </div>
</div>

<script type="application/javascript">

    $('#saveUserEdit').click(function(){
        var e = 'ajax.php?controller=User&action=userEdit2db';
        var idUsuario = $("#idUsuario").val();
        var nombre = $("#nombre").val();
        var identificador = $("#identificador").val();
        var apellido = $("#apellido").val();
        var correo = $("#correo").val();
        var idCargo = $("#idCargo").val();
        var idPerfil = $("#idPerfil").val();
        var idCorredora = $("#idCorredora").val();

        $.ajax({
            type: 'GET',
            url: e,
            data: { idUsuario: idUsuario, identificador: identificador, nombre: nombre, apellido:apellido, correo: correo, idCargo: idCargo, idPerfil: idPerfil, idCorredora: idCorredora },
            dataType : "json",
            beforeSend: function () {
                $('#saveUserEdit').html("Cargando...");
            },
            success: function (data) {
                console.debug("success");
                console.debug(data);
                //var returnedData = JSON.parse(data); console.debug(returnedData);
                if(data.status === "success"){
                    console.debug("success");
                    $('#messageEditUser').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                    $('#saveUserEdit').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                    $('#modalPrincipal').hide();
                    window.location.reload(true);
                }
                else{
                    console.debug("fail");
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
    });

    $('#changePassword').click(function(){

        var idUsuario = $("#idUsuario").val(); //console.debug(idUsuario);
        ajax_loadModal($('#modalSubmodal'),
            'ajax.php?controller=User&action=changePassword',
            'GET',
            { idUsuario: idUsuario },
            defaultMessage);

        return false;
    });

</script>