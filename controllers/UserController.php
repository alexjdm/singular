<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("helpers/SessionHelper.php");
include_once("businesslogic/Usuario.php");
include_once("businesslogic/JobTitle.php");
include_once("businesslogic/InsuranceBroker.php");
include_once("businesslogic/Profile.php");
require "lib/phpmailer/class.phpmailer.php";

class UserController {

    public function __construct()
    {
    }

    public function index() {

        $userBusiness = new Usuario();
        $jobTitleBusiness = new JobTitle();
        $insuranceBrokerBusiness = new InsuranceBroker();
        $profilesBusiness = new Profile();

        $usuarios = $userBusiness->getUsersList();
        $cargos = $jobTitleBusiness->getJobTitlesList();
        $corredoras = $insuranceBrokerBusiness->getInsuranceBrokersList();
        $perfiles = $profilesBusiness->getProfilesList();

        require_once('views/user/index.php');
    }

    public function insuranceUsers() {

        $currentUser = getCurrentUser();
        $idCorredora = $currentUser['idCorredora'];

        $userBusiness = new Usuario();
        $jobTitleBusiness = new JobTitle();
        $insuranceBrokerBusiness = new InsuranceBroker();
        $profilesBusiness = new Profile();

        $usuarios = $userBusiness->getUsers($idCorredora);
        $cargos = $jobTitleBusiness->getJobTitlesList();
        $corredoras = $insuranceBrokerBusiness->getInsuranceBrokersList();
        $perfiles = $profilesBusiness->getProfilesList();

        require_once('views/user/index.php');
    }

    public function login() {
        require_once('views/account/login.php');
    }

    public function logout() {
        if (!isset($_SESSION)) {
            @session_start();
        }
        session_destroy();

        //$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        //$link = "http://$_SERVER[SERVER_NAME]/admin/index.php";
        //require_once('views/account/login.php');
        //header('Location: $_SERVER["SERVER_NAME"]/admin/index.php');
        echo '<script type="text/javascript">
        window.location.assign("index.php");
        </script>';
    }

    public function remember() {
        require_once('views/account/remember.php');
    }

    public function rememberMail() {
        $email = $_GET['email'];
        $password = $this->randomPassword();

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $pdo->prepare("SELECT * FROM usuario WHERE CORREO_ELECTRONICO=:EMAIL AND HABILITADO=1");
        $sql->execute(array('EMAIL' => $email));
        $resultado = $sql->fetch();

        if ($resultado != null) {

            $sql = $pdo->prepare("UPDATE usuario set CLAVE_USUARIO =:PASSWORD WHERE ID_USUARIO=:ID_USUARIO");

            if ($sql->execute(array('PASSWORD' => md5($password), 'ID_USUARIO' => $resultado['ID_USUARIO']))) {

                $correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()

                //Usamos el SetFrom para decirle al script quien envia el correo
                $correo->SetFrom("info@fxlogos.com", "FxLogos");

                //Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
                $correo->AddReplyTo("no-reply@fxlogos.com","FxLogos");

                //Usamos el AddAddress para agregar un destinatario
                //$correo->AddAddress($mail, $nombre);
                $correo->AddAddress($email);

                $e_subject = "Nueva Contraseña";
                $e_body = "Hola ". $resultado['NOMBRE'] . ".<br><br>" . PHP_EOL . PHP_EOL;
                $e_content = "Tu nueva contraseña es: " . $password . "<br><br>Saludos,<br>FxLogos" . PHP_EOL . PHP_EOL;

                $msg = wordwrap( $e_body . $e_content, 70 );

                //Ponemos el asunto del mensaje
                $correo->Subject = utf8_decode($e_subject);

                /*
                 * Si deseamos enviar un correo con formato HTML utilizaremos MsgHTML:
                 * $correo->MsgHTML("<strong>Mi Mensaje en HTML</strong>");
                 * Si deseamos enviarlo en texto plano, haremos lo siguiente:
                 * $correo->IsHTML(false);
                 * $correo->Body = "Mi mensaje en Texto Plano";
                 */
                $correo->MsgHTML($msg);

                //Enviamos el correo
                if(!$correo->Send())
                {
                    $status  = "error";
                    $message = "Hubo un error: " . $correo->ErrorInfo;
                }
                else {
                    $status  = "success";
                    $message = "Correo Enviado. Revisa tu bandeja de correos y encontrarás tu nueva contraseña.";
                }

            }
            else
            {
                $status  = "error";
                $message = "Ha ocurrido un error, por favor intenta nuevamente.";
            }

        }
        else {
            $status  = "error";
            $message = "Este correo no existe.";
        }

        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    /**
     *
     */
    /*public function validation() {

        //Recibir los datos ingresados en el formulario
        $email = $_GET['email']; //echo $email;
        $password = md5($_GET['password']); //echo $password;

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $pdo->prepare("SELECT * FROM usuario WHERE CORREO_ELECTRONICO=:EMAIL AND CLAVE_USUARIO=:PASSWORD AND HABILITADO=1");
        $sql->execute(array('EMAIL' => $email, 'PASSWORD' => $password));
        $resultado = $sql->fetch();
        //print_r($resultado);

        if ($resultado != null) {
            //Inicio de variables de sesión
            if (!isset($_SESSION)) {
                @session_start();
            }

            //Definimos las variables de sesión y redirigimos a la página de usuario
            $_SESSION['id'] = $resultado['ID_USUARIO'];
            $_SESSION['nombre'] = $resultado['NOMBRE'];
            $_SESSION['apellido'] = $resultado['APELLIDO'];
            $_SESSION['correo'] = $resultado['CORREO_ELECTRONICO'];
            $_SESSION['usuarioSkype'] = $resultado['USER_SKYPE'];
            $_SESSION['password'] = $resultado['CLAVE_USUARIO'];
            //$_SESSION['image'] = $resultado['IMAGE'];
            $_SESSION['idPerfil'] = $resultado['ID_PERFIL'];
            $_SESSION['fechaIngreso'] = $resultado['FECHA_INGRESO'];
            $_SESSION['idCargo'] = $resultado['ID_CARGO'];

            $sql = $pdo->prepare("SELECT * FROM corredora_usuario WHERE ID_USUARIO=:ID_USUARIO");
            $sql->execute(array('ID_USUARIO' => $resultado['ID_USUARIO']));
            $resultado = $sql->fetch();

            $_SESSION['idCorredora'] = $resultado['ID_CORREDORA'];

            $status  = "success";
            $message = "Usuario registrado.";
        } else {
            $sql = $pdo->prepare("SELECT * FROM usuario WHERE CORREO_ELECTRONICO=:EMAIL AND HABILITADO=1");
            $sql->execute(array('EMAIL' => $email));
            $resultado = $sql->fetch();

            if ($resultado != null) {
                $status  = "error";
                $message = "Clave incorrecta.";
            }
            else
            {
                $status  = "error";
                $message = "Usuario no registrado.";
            }
        }

        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }*/

    public function changePassword() {
        $idUsuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : null;
        require_once('views/account/changePassword.php');
    }

    //Guardar en BD los datos del usuario
    public function changePassword2db() {
        $idUsuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : null;
        $password = isset($_GET['password']) ? $_GET['password'] : null;

        $userBusiness = new Usuario();
        $userBusiness->changePasswordUser($idUsuario, $password);
    }

    public function error() {
        require_once('views/error/error.php');
    }

    private function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function sellers() {

        $userBusiness = new Usuario();
        $jobTitleBusiness = new JobTitle();
        $insuranceBrokerBusiness = new InsuranceBroker();

        $vendedores = $userBusiness->getSellersList();
        $cargos = $this->$jobTitleBusiness->getJobTitlesList();
        $corredoras = $insuranceBrokerBusiness->getInsuranceBrokersList();

        require_once('views/user/sellers.php');
    }

    public function newSeller() {

        $jobTitleBusiness = new JobTitle();
        $insuranceBrokerBusiness = new InsuranceBroker();

        $cargos = $jobTitleBusiness->getJobTitlesList();
        $corredoras = $insuranceBrokerBusiness->getInsuranceBrokersList();

        require_once('views/user/newSeller.php');
    }

    public function createNewSeller() {
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $rut = isset($_GET['rut']) ? $_GET['rut'] : null;
        $rut = FormatearRut($rut);
        $apellido = isset($_GET['apellido']) ? $_GET['apellido'] : null;
        $correo = isset($_GET['correo']) ? $_GET['correo'] : null;
        $idCargo = isset($_GET['idCargo']) ? $_GET['idCargo'] : null;
        $idCorredora = isset($_GET['idCorredora']) ? $_GET['idCorredora'] : null;
        $idPerfil = isset($_GET['idPerfil']) ? $_GET['idPerfil'] : null;

        $userBusiness = new Usuario();
        return $userBusiness->newUser($nombre, $rut, $apellido, $correo, $idCargo, $idCorredora, $idPerfil);
    }

    public function sellerEdit() {

        $idVendedor = isset($_GET['idVendedor']) ? $_GET['idVendedor'] : null;
        $userBusiness = new Usuario();
        $jobTitleBusiness = new JobTitle();
        $insuranceBrokerBusiness = new InsuranceBroker();

        $vendedor = $userBusiness->getUser($idVendedor);
        $cargos = $jobTitleBusiness->getJobTitlesList();
        $corredoras = $insuranceBrokerBusiness->getInsuranceBrokersList();

        require_once('views/user/sellerEdit.php');
    }

    public function newUser() {

        $jobTitleBusiness = new JobTitle();
        $profilesBusiness = new Profile();
        $insuranceBrokerBusiness = new InsuranceBroker();

        $cargos = $jobTitleBusiness ->getJobTitlesList();
        $perfiles = $profilesBusiness->getProfilesList();

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $corredoras = $insuranceBrokerBusiness->getInsuranceBrokersList();
        }
        else
        {
            $currentUser = getCurrentUser();
            $idCorredora = $currentUser['idCorredora'];
            $corredora = $insuranceBrokerBusiness->getInsuranceBroker($idCorredora);
            $corredoras = Array();
            array_push($corredoras, $corredora);

        }

        require_once('views/user/newUser.php');
    }

    public function createNewUser() {
        $identificador = isset($_GET['identificador']) ? $_GET['identificador'] : null;
        $identificador = FormatearRut($identificador);
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $apellido = isset($_GET['apellido']) ? $_GET['apellido'] : null;
        $correo = isset($_GET['correo']) ? $_GET['correo'] : null;
        $idCargo = isset($_GET['idCargo']) ? $_GET['idCargo'] : null;
        $idCorredora = isset($_GET['idCorredora']) ? $_GET['idCorredora'] : null;
        $idPerfil = isset($_GET['idPerfil']) ? $_GET['idPerfil'] : null;

        $userBusiness = new Usuario();
        return $userBusiness ->newUserByIdentifier($identificador, $nombre, $apellido, $correo, $idCargo, $idCorredora, $idPerfil);
    }

    public function userEdit() {
        $idUsuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : null;
        $jobTitleBusiness = new JobTitle();
        $profilesBusiness = new Profile();
        $userBusiness = new Usuario();
        $insuranceBrokerBusiness = new InsuranceBroker();

        $usuario = $userBusiness->getUser($idUsuario);
        $cargos = $jobTitleBusiness->getJobTitlesList();
        $perfiles = $profilesBusiness->getProfilesList();

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $corredoras = $insuranceBrokerBusiness->getInsuranceBrokersList();
        }
        else
        {
            $currentUser = getCurrentUser();
            $idCorredora = $currentUser['idCorredora'];
            $corredoras = $insuranceBrokerBusiness->getInsuranceBroker($idCorredora);
        }

        require_once('views/user/userEdit.php');
    }

    public function userEdit2db() {
        $idUsuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : null;
        $identificador = isset($_GET['identificador']) ? $_GET['identificador'] : null;
        $identificador = FormatearRut($identificador);
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $apellido = isset($_GET['apellido']) ? $_GET['apellido'] : null;
        $correo = isset($_GET['correo']) ? $_GET['correo'] : null;
        $idCargo = isset($_GET['idCargo']) ? $_GET['idCargo'] : null;
        $idPerfil = isset($_GET['idPerfil']) ? $_GET['idPerfil'] : null;
        $idCorredora = isset($_GET['idCorredora']) ? $_GET['idCorredora'] : null;

        $userBusiness = new Usuario();
        return $userBusiness->editUser($idUsuario, $identificador, $nombre, $apellido, $correo, $idCargo, $idPerfil, $idCorredora);
    }

    public function deleteUser() {
        $idUsuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : null;

        $userBusiness = new Usuario();
        return $userBusiness->deleteUser($idUsuario);
    }

    public function usersInsuranceBroker() {

        $jobTitleBusiness = new JobTitle();
        $profilesBusiness = new Profile();
        $userBusiness = new Usuario();

        $idCorredora = isset($_GET['idCorredora']) ? $_GET['idCorredora'] : null;
        $nombreCorredora = isset($_GET['corredora']) ? $_GET['corredora'] : null;

        $usuarios = $userBusiness->getUsersByIdInsuranceBroker($idCorredora);
        $cargos = $jobTitleBusiness->getJobTitlesList();
        $perfiles = $profilesBusiness->getProfilesList();

        require_once('views/user/usersInsuranceBroker.php');
    }

}