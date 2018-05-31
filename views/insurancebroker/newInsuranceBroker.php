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
            <h4 class="modal-title">Nuevo Cliente</h4>
        </div>
        <div class="modal-body">
            <!-- form start -->
            <form id="newInsuranceBrokerForm" class="form-horizontal">
                <h5>Ingresa los datos de tu cliente.</h5>
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="rut">Rut *</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="rut" type="text" placeholder="Rut">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="nombre">Nombre *</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="nombre" type="text" placeholder="Nombre">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="direccion">Dirección</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="direccion" type="direccion" placeholder="Dirección">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="ciudad">Ciudad</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="ciudad" type="text" placeholder="Ciudad">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="telefono">Teléfono</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="telefono" type="text" placeholder="Teléfono">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="giro">Giro</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="giro" type="text" placeholder="Giro">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="razonSocial">Razón Social</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="razonSocial" type="text" placeholder="Razón Social">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="tasa">Tasa</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="tasa" type="text" placeholder="Tasa">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="primaMin">Prima Mínima</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="primaMin" type="text" placeholder="Prima Mínima">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="idVendedor">Vendedor</label>
                        <div class="col-sm-10">
                            <select id="idVendedor" class="form-control">
                                <?php foreach ($vendedores as $vendedor): ?>
                                    <option value="<?php echo $vendedor['ID_USUARIO']; ?>"><?php echo utf8_encode($vendedor['NOMBRE'] . " " . $vendedor['APELLIDO']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div id="messageNewInsuranceBroker" style="margin: 20px;"></div>

                </div>
            </form>

            <div id="newInsuranceBrokerSuccess" class="box-body text-center" style="display: none;">
                <h4>Tu cliente ha sido creado!</h4>
                <p>Ahora presiona Continuar para crear el usuario administrador del cliente creado.</p>
                <img src="dist/img/success-400.png" width="100px">
                <br>
                <br>
                <a id="continuarCrearAdmin" href="#" class="btn btn-default text-center">Continuar</a>
            </div>

            <form id="newUserForm" class="form-horizontal">
                <div class="box-body">
                    <h5>Ahora debes agregar un contacto responsable que será administrador del sistema.</h5>
                    <h5>La contraseña del usuario será los primeros 4 digitos del RUT.</h5>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="identificador">RUT</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="identificador" type="text" placeholder="RUT">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="correo">Correo</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="correo" type="email" placeholder="Correo">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="nombreUsuario">Nombre</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="nombreUsuario" type="text" placeholder="Nombre">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="apellido">Apellido</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="apellido" type="text" placeholder="Apellido">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="cargo">Cargo</label>
                        <div class="col-sm-10">
                            <select id="cargo" class="form-control">
                                <?php foreach ($cargos as $cargo): ?>
                                    <option value="<?php echo $cargo['ID_CARGO']; ?>"><?php echo utf8_encode($cargo['NOMBRE']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div id="messageNewUser" style="margin: 20px;"></div>

                </div>
            </form>

            <input type="hidden" id="idCorredoraNueva" value="">

        </div>
        <div class="modal-footer">
            <button id="cleanDataInsuranceBrokerBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newInsuranceBrokerBtn" class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Cargando">Guardar</button>
            <button id="newUserBtn" class="btn btn-primary" type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Cargando">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $('#newUserForm').hide();
    $('#newUserBtn').hide();

    $('#continuarCrearAdmin').click(function(){

        $('#newUserForm').show();
        $('#newUserBtn').show();

        $('#newInsuranceBrokerSuccess').hide();

        return false;
    });

    $('#newInsuranceBrokerBtn').click(function(){

        var e = 'ajax.php?controller=InsuranceBroker&action=createNewInsuranceBroker'; //console.debug(e);

        var rut = $("#rut").val(); //console.debug(rut);
        var nombre = $("#nombre").val(); //console.debug(nombre);
        var direccion = $("#direccion").val(); //console.debug(direccion);
        var ciudad = $("#ciudad").val(); //console.debug(ciudad);
        var telefono = $("#telefono").val(); //console.debug(telefono);
        var giro = $("#giro").val();
        var razonSocial = $("#razonSocial").val();
        var tasa = $("#tasa").val();
        var primaMin = $("#primaMin").val();
        var idVendedor = $("#idVendedor").val(); //console.debug(idVendedor);

        if(nombre === '' || rut === '' || nombreUsuario === '' || apellido === '' || correo === '')
        {
            $('#messageNewInsuranceBroker').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { nombre: nombre, rut:rut, direccion: direccion, ciudad: ciudad, telefono: telefono, giro: giro, razonSocial: razonSocial, tasa: tasa, primaMin: primaMin, idVendedor: idVendedor  },
                dataType : "json",
                beforeSend: function () {
                    $('#newInsuranceBrokerBtn').button('loading');
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status === "success"){
                        $('#messageNewInsuranceBroker').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newInsuranceBrokerBtn').hide();
                        $('#newInsuranceBrokerForm').hide();
                        $('#newInsuranceBrokerSuccess').show();
                        $('#idCorredoraNueva').val(data.id);
                    }
                    else{
                        $('#messageNewInsuranceBroker').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newInsuranceBrokerBtn').button('reset');
                    }

                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewInsuranceBroker').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newInsuranceBrokerBtn').button('reset');
                    return false;
                }
            });
        }

        return false;
    });

    $('#newUserBtn').click(function(){

        var identificador = $("#identificador").val(); //console.debug(nombre);
        var nombreUsuario = $("#nombreUsuario").val(); //console.debug(nombreUsuario);
        var apellido = $("#apellido").val(); //console.debug(nombre);
        var correo = $("#correo").val(); //console.debug(rut);
        var idCargo = $("#cargo").val(); //console.debug(direccion);
        var idPerfil = 3; //3: Administrador
        var idCorredora = $("#idCorredoraNueva").val();

        if(identificador === '' || nombreUsuario === '' || apellido === '' || correo === '' || idCorredora === '')
        {
            $('#messageNewUser').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            // Aca creamos al usuario administrador del Cliente
            var e = 'ajax.php?controller=User&action=createNewUser'; //console.debug(e);
            debugger;
            $.ajax({
                type: 'GET',
                url: e,
                data: { identificador: identificador, nombre: nombreUsuario, apellido: apellido, correo: correo, idCargo: idCargo, idCorredora: idCorredora, idPerfil: idPerfil },
                dataType : "json",
                beforeSend: function () {
                    $('#newUserBtn').button('loading');
                },
                success: function (data) {
                    console.debug(data);
                    $('#newUserBtn').button('reset');
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewUser').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        window.location.reload(true);
                    }
                    else{
                        $('#messageNewUser').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewUser').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newUserBtn').button('reset');
                    return false;
                }
            });

        }

        return false;
    });

    $("#cleanDataInsuranceBrokerBtn").click(function() {
        //console.debug("clean");
        $("#newInsuranceBrokerForm").find("input[type=text], input[type=email]").val("");
        return false;
    });

</script>