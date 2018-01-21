<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Usuario_DAO {

    public function validateEmailPassword($correo, $password)
    {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM usuario WHERE CORREO_ELECTRONICO=:CORREO_ELECTRONICO AND CLAVE_USUARIO=:CLAVE_USUARIO AND HABILITADO=:HABILITADO");
        $sql->execute(array('CORREO_ELECTRONICO' => $correo, 'CLAVE_USUARIO' => $password, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function validateEmail($correo)
    {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM usuario WHERE CORREO_ELECTRONICO=:CORREO_ELECTRONICO AND HABILITADO=:HABILITADO");
        $sql->execute(array('CORREO_ELECTRONICO' => $correo, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function getUsersList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM usuario WHERE HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getUsers($idCorredora){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT ID_USUARIO FROM corredora_usuario WHERE ID_CORREDORA = :ID_CORREDORA");
        $sql->execute(array('ID_CORREDORA' => $idCorredora));

        $idUsuarios = $sql->fetchAll();
        $usuarios = array();
        if($idUsuarios != null)
        {
            $ids = '';
            $arrayIds = array();
            foreach ($idUsuarios as $idUsuario) {
                array_push($arrayIds, $idUsuario['ID_USUARIO']);
            }
            $ids = join("','",$arrayIds);

            $sql = $pdo->prepare("SELECT * FROM usuario WHERE ID_USUARIO in ('$ids') AND HABILITADO=1");
            $sql->execute(array());

            $usuarios = $sql->fetchAll();
        }

        return $usuarios;
    }

    public function getSellersList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM usuario WHERE ID_PERFIL = 1 AND HABILITADO=1");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getSellersListByInsuranceBrokerId($idCorredora){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM usuario WHERE ID_PERFIL = 1 AND HABILITADO=1 AND ID_CORREDORA = :ID_CORREDORA");
        $sql->execute(array('ID_CORREDORA' => $idCorredora));

        return $sql->fetchAll();
    }

    public function getUsersByIdInsuranceBroker($idCorredora){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT ID_USUARIO FROM corredora_usuario WHERE ID_CORREDORA = :ID_CORREDORA");
        $sql->execute(array('ID_CORREDORA' => $idCorredora));

        $idUsuarios = $sql->fetchAll();
        $usuarios = array();
        if($idUsuarios != null)
        {
            $ids = '';
            $arrayIds = array();
            foreach ($idUsuarios as $idUsuario) {
                array_push($arrayIds, $idUsuario['ID_USUARIO']);
            }
            $ids = join("','",$arrayIds);

            $sql = $pdo->prepare("SELECT * FROM usuario WHERE ID_USUARIO IN ('$ids') AND HABILITADO=1");
            $sql->execute(array());
            $usuarios = $sql->fetchAll();
        }

        return $usuarios;
    }

    public function getSuperAdminsList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM usuario WHERE ID_PERFIL = -1 AND HABILITADO=1");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getUser($idUsuario){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM usuario WHERE ID_USUARIO=:ID_USUARIO AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_USUARIO' => $idUsuario, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function editUser($idUsuario, $rut, $nombre, $apellido, $correo, $idCargo, $habilitado){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $usuario = $this->getUser($idUsuario);
        $rut = isset($rut) ? $rut : $usuario['IDENTIFICADOR'];
        $nombre = isset($nombre) ? $nombre : $usuario['NOMBRE'];
        $apellido = isset($apellido) ? $apellido : $usuario['APELLIDO'];
        $correo = isset($correo) ? $correo : $usuario['CORREO_ELECTRONICO'];
        $idCargo = isset($idCargo) ? $idCargo : $usuario['ID_CARGO'];
        $habilitado = isset($habilitado) ? $habilitado : $usuario['HABILITADO'];

        $sql = $pdo->prepare("UPDATE usuario set IDENTIFICADOR =:IDENTIFICADOR, NOMBRE =:NOMBRE, APELLIDO =:APELLIDO, CORREO_ELECTRONICO =:CORREO_ELECTRONICO, ID_CARGO =:ID_CARGO, HABILITADO =:HABILITADO WHERE ID_USUARIO=:ID_USUARIO");

        if ($sql->execute(array('IDENTIFICADOR' => $rut, 'NOMBRE' => $nombre, 'APELLIDO' => $apellido, 'CORREO_ELECTRONICO' => $correo, 'ID_CARGO' => $idCargo, 'HABILITADO' => $habilitado, 'ID_USUARIO' => $idUsuario ))) {
            $status  = "success";
            $message = "Los datos han sido actualizados.";
        }
        else
        {
            $status  = "error";
            $message = "Ha ocurrido un problema con la actualización de tu contraseña.";
        }

        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function changePasswordUser($idUsuario, $password){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE usuario set CLAVE_USUARIO =:PASSWORD WHERE ID_USUARIO=:ID_USUARIO");

        if ($sql->execute(array('PASSWORD' => md5($password), 'ID_USUARIO' => $idUsuario))) {
            $status  = "success";
            $message = "Tu contraseña ha sido actualizada.";
        }
        else
        {
            $status  = "error";
            $message = "Ha ocurrido un problema con la actualización de tu contraseña.";
        }

        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function deleteUser($idUsuario){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE usuario set HABILITADO =:HABILITADO WHERE ID_USUARIO=:ID_USUARIO");

        if ($sql->execute(array('HABILITADO' => 0, 'ID_USUARIO' => $idUsuario ))) {
            $status  = "success";
            $message = "El usuario ha sido eliminado";
        }
        else
        {
            $status  = "error";
            $message = "Ha ocurrido un problema, por favor intenta nuevamente.";
        }

        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function newUser($identificador, $nombre, $apellido, $correo, $idCargo, $idCorredora, $idPerfil){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        //$password = $this->randomPassword();
        $password = substr($identificador, 0, 4);
        date_default_timezone_set('America/Santiago');
        $fechaIngreso = date("Y-m-d H:i:s");

        if(!$this->isEmail($correo)) {
            $status  = "error";
            $message = "Has ingresado una dirección de correo electrónico no válido, intenta nuevamente.";
        }
        else{
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = $pdo->prepare("SELECT * FROM usuario WHERE CORREO_ELECTRONICO=:CORREO_ELECTRONICO");
            $sql->execute(array('CORREO_ELECTRONICO' => $correo));
            $resultado = $sql->fetch();

            if ($resultado == null) {

                $sql = $pdo->prepare("INSERT INTO `usuario`(`IDENTIFICADOR`, `NOMBRE`, `APELLIDO`, `CORREO_ELECTRONICO`, `ID_CARGO`, `FECHA_INGRESO`, `ID_CORREDORA`, `CLAVE_USUARIO`, `HABILITADO`, `ID_PERFIL`) VALUES (:identificador,:nombre,:apellido,:correo,:idCargo, :fechaIngreso, :idCorredora,:clave,1,:idPerfil)");
                $sql->execute(array('identificador' => $identificador, 'nombre' => $nombre, 'apellido' => $apellido, 'correo' => $correo, 'idCargo' => $idCargo, 'fechaIngreso' => $fechaIngreso, 'idCorredora' => $idCorredora, 'clave' => md5($password), 'idPerfil' => $idPerfil));
                $id = $pdo->lastInsertId();

                if(!empty($id)) {

                    $sql = $pdo->prepare("INSERT INTO `corredora_usuario`(`ID_CORREDORA`, `ID_USUARIO`) VALUES (:idCorredora,:idUsuario)");
                    $sql->execute(array('idCorredora' => $idCorredora, 'idUsuario' => $id));

                    $status  = "success";
                    $message = "Registro exitoso.";
                }
                else{
                    $status  = "error";
                    $message = "Error con la base de datos, por favor intente nuevamente.";
                }

            }
            else{
                $status  = "error";
                $message = "Correo Electrónico ya se encuentra registrado.";
            }
        }

        $data = array(
            'status'  => $status,
            'message' => $message,
            'password' => $password
        );

        echo json_encode($data);

        Database::disconnect();
    }

    // Email address verification, do not edit.
    private function isEmail($email) {
        return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
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


}