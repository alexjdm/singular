<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Embalaje_DAO {

    public function getPackingsList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM embalaje WHERE HABILITADO = TRUE ORDER BY EMBALAJE");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function newPacking($nombre, $idPoliza){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM embalaje WHERE EMBALAJE =:EMBALAJE AND ID_POLIZA =:ID_POLIZA");
        $sql->execute(array('EMBALAJE' => $nombre, 'ID_POLIZA' => $idPoliza));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            $sql = $pdo->prepare("INSERT INTO `embalaje`(`EMBALAJE`, `ID_POLIZA`, `HABILITADO`) VALUES (:EMBALAJE, :ID_POLIZA, TRUE)");
            $sql->execute(array('EMBALAJE' => $nombre, 'ID_POLIZA' => $idPoliza));
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
            $message = "Este embalaje ya se encuentra registrado.";
        }
        
        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function getPacking($idPacking){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM embalaje WHERE ID_EMBALAJE=:ID_EMBALAJE AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_EMBALAJE' => $idPacking, 'HABILITADO' => true));

        return $sql->fetchAll()[0];
    }

    public function editPacking($idPacking, $nombre, $idPoliza){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE embalaje set EMBALAJE =:EMBALAJE, ID_POLIZA = :ID_POLIZA WHERE ID_EMBALAJE=:ID_EMBALAJE");

        if ($sql->execute(array('EMBALAJE' => $nombre, 'ID_POLIZA' => $idPoliza, 'ID_EMBALAJE' => $idPacking ))) {
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

    public function deletePacking($idPacking){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE embalaje set HABILITADO =:HABILITADO WHERE ID_EMBALAJE=:ID_EMBALAJE");

        if ($sql->execute(array('HABILITADO' => false, 'ID_EMBALAJE' => $idPacking ))) {
            $status  = "success";
            $message = "El embalaje ha sido eliminado";
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