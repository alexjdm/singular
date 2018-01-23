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
            <h4 class="modal-title">Nuevo Corredora</h4>
        </div>
        <div class="modal-body">
            <!-- form start -->
            <form id="newInsuranceBrokerForm" class="form-horizontal">
                <h5>Ingresa los datos de tu corredora.</h5>
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

        </div>
        <div class="modal-footer">
            <button id="cleanDataInsuranceBrokerBtn" class="btn btn-default pull-left" type="submit">Limpiar</button>

            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="newInsuranceBrokerBtn" class="btn btn-primary" type="submit">Siguiente</button>
            <button id="newUserBtn" class="btn btn-primary" type="submit">Agregar</button>
        </div>
    </div>

</div>

<script type="application/javascript">

    $('#newUserForm').hide();
    $('#newUserBtn').hide();

    $('#newInsuranceBrokerBtn').click(function(){

        var rut = $("#rut").val(); //console.debug(rut);
        var nombre = $("#nombre").val(); //console.debug(nombre);

        if(nombre == '' || rut == '')
        {
            $('#messageNewInsuranceBroker').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $('#newInsuranceBrokerForm').hide();
            $('#newInsuranceBrokerBtn').hide();

            $('#newUserForm').show();
            $('#newUserBtn').show();
        }

        return false;
    });

    $('#newUserBtn').click(function(){

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

        var identificador = $("#identificador").val(); //console.debug(nombre);
        var nombreUsuario = $("#nombreUsuario").val(); //console.debug(nombreUsuario);
        var apellido = $("#apellido").val(); //console.debug(nombre);
        var correo = $("#correo").val(); //console.debug(rut);
        var idCargo = $("#cargo").val(); //console.debug(direccion);

        if(nombre === '' || rut === '' || nombreUsuario === '' || apellido === '' || correo === '')
        {
            $('#messageNewUser').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong> Debes rellenar los campos requeridos </div>');
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: e,
                data: { nombre: nombre, rut:rut, direccion: direccion, ciudad: ciudad, telefono: telefono, giro: giro, razonSocial: razonSocial, tasa: tasa, primaMin: primaMin, idVendedor: idVendedor  },
                dataType : "json",
                beforeSend: function () {
                    $('#newInsuranceBrokerBtn').html("Cargando...");
                },
                success: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    if(data.status == "success"){
                        $('#messageNewUser').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + data.message + '</div>');
                        $('#newInsuranceBrokerBtn').html('Siguiente');
                        //window.location.reload(true);

                        // Aca creamos al usuario administrador de la empresa Corredora
                        e = 'ajax.php?controller=User&action=createNewUser'; //console.debug(e);

                        var idCorredora = data.id;

                        $.ajax({
                            type: 'GET',
                            url: e,
                            data: { identificador: identificador, nombre: nombre, apellido: apellido, correo: correo, idCargo: idCargo, idCorredora: idCorredora },
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
                    else{
                        $('#messageNewUser').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                        $('#newInsuranceBrokerBtn').html("Siguiente");
                    }
                    return false;
                },
                error: function (data) {
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#messageNewUser').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    $('#newInsuranceBrokerBtn').html("Siguiente");
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