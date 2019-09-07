<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Cargo_DAO {

    public function getJobTitlesList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM cargo WHERE HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getJobTitlesByInsuranceBrokerId($idCorredora){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM cargo WHERE (BASE = 1 OR ID_CORREDORA = '$idCorredora') AND HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function newJobTitle($nombre){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM cargo WHERE NOMBRE =:NOMBRE");
        $sql->execute(array('NOMBRE' => $nombre));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            $sql = $pdo->prepare("INSERT INTO `cargo`(`NOMBRE`, `HABILITADO`) VALUES (:NOMBRE, 1)");
            $sql->execute(array('NOMBRE' => $nombre));
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
            $message = "Este cargo ya se encuentra registrado.";
        }
        
        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function getJobTitle($idCargo){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM cargo WHERE ID_CARGO=:ID_CARGO AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_CARGO' => $idCargo, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function editJobTitle($idCargo, $nombre){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE cargo set NOMBRE =:NOMBRE WHERE ID_CARGO=:ID_CARGO");

        if ($sql->execute(array('NOMBRE' => $nombre, 'ID_CARGO' => $idCargo ))) {
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

    public function deleteJobTitle($idCargo){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE cargo set HABILITADO =:HABILITADO WHERE ID_CARGO=:ID_CARGO");

        if ($sql->execute(array('HABILITADO' => 0, 'ID_CARGO' => $idCargo ))) {
            $status  = "success";
            $message = "El cargo ha sido eliminado";
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