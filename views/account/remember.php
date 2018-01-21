
<div class="login-box">
    <div class="login-logo">
        <b>Admin</b> FxLogos
    </div><!-- /.login-logo -->

    <div class="login-box-body">
        <blockquote>
            <p style="font-size: 10pt;">Por favor, escribe tu nombre de usuario o tu correo electrónico. Recibirás una contraseña temporal por correo electrónico.</p>
        </blockquote>
    </div>
    <br>
    <div class="login-box-body">
        <p class="login-box-msg">Ingrese su correo electrónico</p>
        <form action="" method="post">
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email" id="email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <div class="checkbox icheck">
                    </div>
                </div><!-- /.col -->
                <div class="col-xs-8">
                    <a id="rememberBtn" class="btn btn-primary btn-block btn-flat">Obtener una nueva contraseña</a>
                    <a id="backBtn" href="index.php?controller=Account&action=login" class="btn btn-primary btn-block btn-flat" style="display: none;">Volver a Login</a>
                </div><!-- /.col -->
            </div>
        </form>
    </div><!-- /.login-box-body -->
    <br>
    <div id="login-box-message"></div>

</div><!-- /.login-box -->

<script>
    $(function() {

        $('#rememberBtn').click(function (){

            var e = 'ajax.php?controller=Account&action=rememberMail';
            var email = $("#email").val();
            
            $.ajax({
                type: 'GET',
                url: e,
                data: { email: email },
                dataType : "json",
                beforeSend: function() {
                    $('#rememberBtn').html("Cargando...");
                },
                success: function(data) {
                    if(data.status == 'success')
                    {
                        $('#login-box-message').html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                        $('#rememberBtn').css("display", "none");
                        $('#backBtn').css("display", "block");
                    }
                    else
                    {
                        $('#rememberBtn').html("Obtener una nueva contraseña");
                        $('#login-box-message').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                    }

                },
                error: function(data) {
                    $('#rememberBtn').html("Obtener una nueva contraseña");
                    $('#login-box-message').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                }
            });
        });

    });
</script>