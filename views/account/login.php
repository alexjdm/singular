<div class="login-box">
    <div class="login-logo">
        <b>Singular</b> Seguros
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Ingrese para inciar su sesión</p>
        <form action="" method="post">
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email" id="email" name="email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-7">
                    <!--<div class="checkbox icheck">
                        <label>
                            <input id="remember" type="checkbox"> Recordarme
                        </label>
                    </div>-->
                </div><!-- /.col -->
                <div class="col-xs-5">
                    <a id="loginBtn" class="btn btn-primary btn-block btn-flat" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Cargando">Ingresar</a>
                </div><!-- /.col -->
            </div>
        </form>

        <!--<div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div>-->

        <a href="index.php?controller=Account&action=remember">Olvidé mi contraseña</a><br>
        <!--<a href="register.html" class="text-center">Register a new membership</a>-->

    </div><!-- /.login-box-body -->
    <br>
    <div id="login-box-message"></div>

</div><!-- /.login-box -->

<script>
    $(function() {

        $('#loginBtn').click(function (){

            var pathname = window.location.pathname; //console.log(pathname);
            var url      = window.location.href;     //console.log(url);
            var index = url.lastIndexOf("/");
            var url2 = url.substr(0, index+1); //console.debug(url2);
            var e = 'ajax.php?controller=Account&action=validation';
            console.debug(url2 + e);

            var email = $("#email").val(); //console.debug(email);
            var password = $("#password").val(); //console.debug(password);
            //var remember = $("remember").checked;

            $.ajax({
                type: 'GET',
                url: url2 + e,
                data: { email: email, password: password },
                dataType : "json",
                beforeSend: function() {
                    //$('#loginBtn').html("Cargando...");
                    $('#loginBtn').button('loading');
                },
                success: function(data) {
                    console.debug(data);
                    var returnedData = data;
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    console.debug('success');

                    if(returnedData.status == 'success')
                    {
                        console.debug("Login ok");
                        window.location.href = "index.php?controller=Home&action=index";
                    }
                    else
                    {
                        console.debug("Login fail");
                        //$('#loginBtn').html("Ingresar");
                        $('#loginBtn').button('reset');
                        $('#login-box-message').html('<div class="alert alert-danger" role="alert">' + returnedData.message + '</div>');
                    }

                },
                error: function(xhr, status, thrown) {
                    console.log(xhr);
                    console.log(status);
                    console.log(thrown);
                    //debugger;
                    var data = JSON.parse(xhr.responseText.trim()); console.debug(data);

                    if(data.status == 'success')
                    {
                        console.debug("Login ok");
                        window.location.href = "index.php?controller=Home&action=index";
                    }
                    else
                    {
                        console.debug("Login fail");
                        //$('#loginBtn').html("Ingresar");
                        $('#loginBtn').button('reset');
                        $('#login-box-message').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                    }

                    /*console.debug('Error');
                    $('#loginBtn').html("Ingresar");
                    $('#login-box-message').html('<div class="alert alert-danger" role="alert">' + thrown + '</div>');*/
                }
            });
        });

    });
</script>