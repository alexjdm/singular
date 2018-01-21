<?php
/**
 * Created by PhpStorm.
 * Insurance: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Seguro_DAO {

    public function getInsurancesList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM seguro WHERE HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getInsurances($idCorredora){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM seguro WHERE ID_CLIENTE = :ID_CLIENTE AND HABILITADO='1'");
        $sql->execute(array('ID_CLIENTE' => $idCorredora));

        return $sql->fetchAll();
    }

    public function getInsurance($idSeguro){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM seguro WHERE ID_SEGURO=:ID_SEGURO AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_SEGURO' => $idSeguro, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function editInsurance($idSeguro, $nombre, $apellido, $rut, $correo, $idCargo, $habilitado, $idPerfil){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE seguro set IDENTIFICADOR =:IDENTIFICADOR, NOMBRE =:NOMBRE, APELLIDO =:APELLIDO, CORREO_ELECTRONICO =:CORREO_ELECTRONICO, ID_CARGO =:ID_CARGO, HABILITADO =:HABILITADO, ID_PERFIL =:ID_PERFIL WHERE ID_SEGURO=:ID_SEGURO");

        if ($sql->execute(array('IDENTIFICADOR' => $rut, 'NOMBRE' => $nombre, 'APELLIDO' => $apellido, 'CORREO_ELECTRONICO' => $correo, 'ID_CARGO' => $idCargo, 'HABILITADO' => $habilitado, 'ID_PERFIL' => $idPerfil, 'ID_SEGURO' => $idSeguro ))) {
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

    public function deleteInsurance($idSeguro){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE seguro set HABILITADO =:HABILITADO WHERE ID_SEGURO=:ID_SEGURO");

        if ($sql->execute(array('HABILITADO' => 0, 'ID_SEGURO' => $idSeguro ))) {
            $status  = "success";
            $message = "El seguro ha sido eliminado";
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

    public function newInsurance($rut, $nombre, $apellido, $giro, $idCargo, $idPerfil){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $password = $this->randomPassword();

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM seguro WHERE CORREO_ELECTRONICO=:CORREO_ELECTRONICO");
        $sql->execute(array('CORREO_ELECTRONICO' => $correo));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            $sql = $pdo->prepare("INSERT INTO `seguro`(`IDENTIFICADOR`, `NOMBRE`, `APELLIDO`, `CORREO_ELECTRONICO`, `ID_CARGO`, `CLAVE_USUARIO`, `HABILITADO`, `ID_PERFIL`) VALUES (:rut,:nombre,:apellido,:correo,:idCargo,:clave,1,:idPerfil)");
            $sql->execute(array('rut' => $rut, 'nombre' => $nombre, 'apellido' => $apellido, 'correo' => $correo, 'idCargo' => $idCargo, 'clave' => md5($password), 'idPerfil' => $idPerfil));
            $id = $pdo->lastInsertId();

            if(!empty($id)) {
                $status  = "success";
                $message = "Registro exitoso.";
            }
            else{
                $status  = "error";
                $message = "Error con la base de datos, por favor intente nuevamente.";
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

}