<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 03-04-2016
 * Time: 23:50
 */

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

?>

<div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nuevo Usuario</h4>
        </div>
        <div class="modal-body">
            <!-- form start -->
            <form id="newUserForm" class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="identificador">RUT *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="identificador" type="text" placeholder="Sin puntos y con guión. Ej. 12345678-9">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="nombre">Nombre *</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="nombre" type="text" placeholder="Nombre">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="apellido">Apellido</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="apellido" type="apellido" placeholder="Apellido">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="correo">Correo</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="correo" type="text" placeholder="Correo">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="idCargo">Cargo</label>
                        <div class="col-sm-9">
                            <select id="idCargo" class="form-control">
                                <?php foreach ($cargos as $cargo): ?>
                                    <option value="<?php echo $cargo['ID_CARGO']; ?>"><?php echo utf8_encode($cargo['NOMBRE']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="idPerfil">Perfil</label>
                        <div class="col-sm-9">
                            <select id="idPerfil" class="form-control">
                                <?php foreach ($perfiles as $perfil): ?>
                                    <option value="<?php echo $perfil['ID_PERFIL']; ?>"><?php echo utf8_encode($perfil['NOMBRE_PERFIL']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="idCorredora">Cliente</label>
                        <div class="col-sm-9">
                            <select id="idCorredora" class="form-control">
                                <?php foreach ($corredoras as $corredora): ?>
                                    <option value="<?php echo $corredora['ID_CORREDORA']; ?>"><?php echo utf8_encode($corredora['NOMBRE']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div id="messageNewUser" style="margin: 20px;"></div>

                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button id="cleanDataUserBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newUserBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $('#newUserBtn').click(function(){
        var e = 'ajax.php?controller=User&action=createNewUser'; console.debug(e);

        var identificador = $("#identificador").val(); console.debug(identificador);
        var nombre = $("#nombre").val(); console.debug(nombre);
        var apellido = $("#apellido").val(); console.debug(apellido);
        var correo = $("#correo").val(); console.debug(correo);
        var idCargo = $("#idCargo").val(); console.debug(idCargo);
        var idCorredora = $("#idCorredora").val(); console.debug(idCorredora);
        var idPerfil = $("#idPerfil").val(); console.debug(idPerfil);

        if(nombre === '' && identificador === '')
        {
            $('#messageNewUser').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { identificador:identificador, nombre: nombre, apellido: apellido, correo: correo, idCargo: idCargo, idCorredora: idCorredora, idPerfil: idPerfil },
                dataType : "json",
                beforeSend: function () {
                    $('#newUserBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewUser').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newUserBtn').html('Agregar');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewUser').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newUserBtn').html("Agregar");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewUser').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newUserBtn').html("Agregar");
                    return false;
                }
            });
        }

        return false;
    });

    $("#cleanDataUserBtn").click(function() {
        console.debug("clean");
        $("#newUserForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>