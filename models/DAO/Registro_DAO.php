<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Registro_DAO {

    public function getAllLog(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM registro");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function save($idUsuario, $fecha, $descripcion, $url, $idCorredora){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("INSERT INTO `registro`(`ID_USUARIO`, `FECHA`, `DESCRIPCION`, `URL`, `ID_CORREDORA`) VALUES (:ID_USUARIO,:FECHA,:DESCRIPCION,:URL,:ID_CORREDORA)");
        $sql->execute(array('ID_USUARIO' => $idUsuario, 'FECHA' => $fecha, 'DESCRIPCION' => $descripcion, 'URL' => $url, 'ID_CORREDORA' => $idCorredora));
        $id = $pdo->lastInsertId();

        if(!empty($id)) {
            $status  = "success";
            $message = "Registro exitoso.";
        }
        else{
            $status  = "error";
            $message = "Error con la base de datos, por favor intente nuevamente.";
        }
        
        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

}