<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class TipoMercaderia_DAO {

    public function getMerchandiseTypesList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM tipo_mercaderia WHERE HABILITADO='1' ORDER BY TIPO_MERCADERIA");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function newMerchandiseType($nombre){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM tipo_mercaderia WHERE TIPO_MERCADERIA =:TIPO_MERCADERIA");
        $sql->execute(array('TIPO_MERCADERIA' => $nombre));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            $sql = $pdo->prepare("INSERT INTO `tipo_mercaderia`(`TIPO_MERCADERIA`, `HABILITADO`) VALUES (:TIPO_MERCADERIA, TRUE)");
            $sql->execute(array('TIPO_MERCADERIA' => $nombre));
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
        else{
            $status  = "error";
            $message = "Este tipo de mercadería ya se encuentra registrada.";
        }
        
        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function getMerchandiseType($idMerchandiseType){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM tipo_mercaderia WHERE ID_TIPO_MERCADERIA=:ID_TIPO_MERCADERIA AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_TIPO_MERCADERIA' => $idMerchandiseType, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function editMerchandiseType($idMerchandiseType, $nombre){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE tipo_mercaderia set TIPO_MERCADERIA =:TIPO_MERCADERIA WHERE ID_TIPO_MERCADERIA=:ID_TIPO_MERCADERIA");

        if ($sql->execute(array('TIPO_MERCADERIA' => $nombre, 'ID_TIPO_MERCADERIA' => $idMerchandiseType ))) {
            $status  = "success";
            $message = "Los datos han sido actualizados.";
        }
        else
        {
            $status  = "error";
            $message = "Ha ocurrido un problema con la actualización de los datos.";
        }

        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function deleteMerchandiseType($idMerchandiseType){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE tipo_mercaderia set HABILITADO =:HABILITADO WHERE ID_TIPO_MERCADERIA=:ID_TIPO_MERCADERIA");

        if ($sql->execute(array('HABILITADO' => false, 'ID_TIPO_MERCADERIA' => $idMerchandiseType))) {
            $status  = "success";
            $message = "El tipo de mercadería ha sido eliminado";
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

}