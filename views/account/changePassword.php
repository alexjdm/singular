<div class="modal-dialog">
    <div class="modal-content" style="width:450px;margin-left:75px;margin-top:75px;">
        <div class="modal-header">
            <button type="button" class="close closeContraseña" data-dismiss="" aria-hidden="true">×</button>
            <h4 class="tituloLabel">Nueva Contraseña</h4>
        </div>
        <div class="modal-body">
            <input id="idUsuario" type="hidden" value="<?php echo $idUsuario ?>">
            <div class="editor">
                <div class="editor-label" style="width:200px">
                    Escriba su nueva contraseña
                </div>
                <div class="editor-field">
                    <input type="password" id="PASSWORD1" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="editor">
                <div class="editor-label" style="width:200px">
                    Repita su nueva contraseña
                </div>
                <div class="editor-field">
                    <input type="password" id="PASSWORD2" class="form-control" autocomplete="off">
                </div>
            </div>
            <div id="messagePassword" style="margin-top: 10px;"></div>
        </div>

        <div class="modal-footer">
            <button id="cerrarContrasena" class="btn btn-default" type="button" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button type="button" id="guardarContrasena" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</div>

<script type="application/javascript">

    $('#guardarContrasena').click(function(){
        var e = 'ajax.php?controller=User&action=changePassword2db'; //console.debug(e);
        var idUsuario = $("#idUsuario").val();
        var pass1 = $("#PASSWORD1").val();
        var pass2 = $("#PASSWORD2").val();

        if(pass1 == '' || pass2 == '')
        {
            $('#messagePassword').html('<div class="alert alert-danger" role="alert"><strong>Error!</strong> Debe llenar todos los campos requeridos.</div>');
            return false;
        }

        if(pass1 != pass2)
        {
            $('#messagePassword').html('<div class="alert alert-danger" role="alert"><strong>Error!</strong> Ambas contraseñas deben ser iguales.</div>');
            return false;
        }
        else if (pass1.length < 2 && pass1.length > 200)
        {
            $('#messagePassword').html('<div class="alert alert-danger" role="alert"><strong>Error!</strong> Tu contraseña debe tener al menos 3 caracteres.</div>');
            return false;
        }

        $.ajax({
            type: 'GET',
            url: e,
            data: { idUsuario: idUsuario, password: pass1},
            beforeSend: function () {
                $('#guardarContrasena').html("Cargando...");
            },
            success: function (data) {
                console.debug(data);
                var returnedData = JSON.parse(data); console.debug(returnedData)
                if(returnedData.status == "success"){
                    console.debug("Login ok");
                    $('#messagePassword').html('<div class="alert alert-success" role="alert"><strong>Listo! </strong>' + returnedData.message + '</div>');
                    $('#guardarContrasena').html('<i class="fa fa-check" aria-hidden="true"></i> Listo');
                    $('#cerrarContrasena').html('Cerrar');
                    $('#guardarContrasena').attr('disabled','disabled');
                    //$("#modalSubmodal").hide();
                }
                else{
                    console.debug("Register fail");
                    $('#guardarContrasena').html("Guardar");
                    $('#messagePassword').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + returnedData.message + '</div>');
                }
            },
            error: function (data) {
                var returnedData = JSON.parse(data); console.debug(returnedData);
                $('#guardarContrasena').html("Guardar");
                $('#messagePassword').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + returnedData.message + '</div>');
            }
        });

    });

</script>