<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class TipoMedio_DAO {

    public function getMedioTypesList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM tipo_medio WHERE HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function newMedioType($tipoMedio){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM tipo_medio WHERE TIPO_MEDIO =:TIPO_MEDIO");
        $sql->execute(array('TIPO_MEDIO' => $tipoMedio));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            $sql = $pdo->prepare("INSERT INTO `tipo_medio`(`TIPO_MEDIO`, `HABILITADO`) VALUES (:TIPO_MEDIO, 1)");
            $sql->execute(array('TIPO_MEDIO' => $tipoMedio));
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
            $message = "Este mediotype ya se encuentra registrado.";
        }
        
        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function getMedioType($idMedioType){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM tipo_medio WHERE ID_TIPO_MEDIO=:ID_TIPO_MEDIO AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_TIPO_MEDIO' => $idMedioType, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function editMedioType($idMedioType, $tipoMedio){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE mediotype set TIPO_MEDIO =:TIPO_MEDIO WHERE ID_TIPO_MEDIO=:ID_TIPO_MEDIO");

        if ($sql->execute(array('TIPO_MEDIO' => $tipoMedio, 'ID_TIPO_MEDIO' => $idMedioType ))) {
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

    public function deleteMedioType($idMedioType){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE mediotype set HABILITADO =:HABILITADO WHERE ID_TIPO_MEDIO=:ID_TIPO_MEDIO");

        if ($sql->execute(array('HABILITADO' => 0, 'ID_TIPO_MEDIO' => $idMedioType ))) {
            $status  = "success";
            $message = "El mediotype ha sido eliminado";
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