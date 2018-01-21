<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class _Corredora_DAO {

    public function getInsuranceBrokersList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM corredora WHERE HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function newInsuranceBroker($rut, $nombre){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM corredora WHERE RUT =:RUT");
        $sql->execute(array('RUT' => $rut));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            $sql = $pdo->prepare("INSERT INTO `corredora`(`RUT`, `NOMBRE`, `HABILITADO`) VALUES (:rut, :nombre, 1)");
            $sql->execute(array('rut' => $rut, 'nombre' => $nombre));
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
            $message = "Esta corredora ya se encuentra registrada.";
        }


        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function getInsuranceBroker($idCorredora){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM corredora WHERE ID_CORREDORA=:ID_CORREDORA AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_CORREDORA' => $idCorredora, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function editInsuranceBroker($idCorredora, $rut, $nombre){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE corredora set RUT =:RUT, NOMBRE =:NOMBRE WHERE ID_CORREDORA=:ID_CORREDORA");

        if ($sql->execute(array('RUT' => $rut, 'NOMBRE' => $nombre, 'ID_CORREDORA' => $idCorredora ))) {
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

    public function deleteInsuranceBroker($idCorredora){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE corredora set HABILITADO =:HABILITADO WHERE ID_CORREDORA=:ID_CORREDORA");

        if ($sql->execute(array('HABILITADO' => 0, 'ID_CORREDORA' => $idCorredora ))) {
            $status  = "success";
            $message = "La corredora ha sido eliminado";
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