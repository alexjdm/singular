<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class MateriaAsegurada_DAO {

    public function getInsuredMattersList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM materia_asegurada WHERE HABILITADO = TRUE ORDER BY MATERIA_ASEGURADA");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function newInsuredMatter($nombre){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM materia_asegurada WHERE MATERIA_ASEGURADA =:MATERIA_ASEGURADA");
        $sql->execute(array('MATERIA_ASEGURADA' => $nombre));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            $sql = $pdo->prepare("INSERT INTO `materia_asegurada`(`MATERIA_ASEGURADA`, `HABILITADO`) VALUES (:MATERIA_ASEGURADA, 1)");
            $sql->execute(array('MATERIA_ASEGURADA' => $nombre));
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
            $message = "Esta materia ya se encuentra registrada.";
        }
        
        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function getInsuredMatter($idInsuredMatter){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM materia_asegurada WHERE ID_MATERIA_ASEGURADA=:ID_MATERIA_ASEGURADA AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_MATERIA_ASEGURADA' => $idInsuredMatter, 'HABILITADO' => true));

        return $sql->fetchAll()[0];
    }

    public function editInsuredMatter($idInsuredMatter, $nombre){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE materia_asegurada set MATERIA_ASEGURADA =:MATERIA_ASEGURADA WHERE ID_MATERIA_ASEGURADA=:ID_MATERIA_ASEGURADA");

        if ($sql->execute(array('MATERIA_ASEGURADA' => $nombre, 'ID_MATERIA_ASEGURADA' => $idInsuredMatter ))) {
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

    public function deleteInsuredMatter($idInsuredMatter){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE materia_asegurada set HABILITADO =:HABILITADO WHERE ID_MATERIA_ASEGURADA=:ID_MATERIA_ASEGURADA");

        if ($sql->execute(array('HABILITADO' => false, 'ID_MATERIA_ASEGURADA' => $idInsuredMatter ))) {
            $status  = "success";
            $message = "La materia ha sido eliminado";
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