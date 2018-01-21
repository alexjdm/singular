<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Siniestro_DAO {

    public function getSinistersList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM siniestro WHERE HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getSinistersByState($state){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM siniestro WHERE ESTADO = :ESTADO AND HABILITADO='1'");
        $sql->execute(array('ESTADO' => $state));

        return $sql->fetchAll();
    }

    public function getSinisters($idCorredora){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM seguro WHERE ID_CLIENTE = :ID_CLIENTE AND HABILITADO='1'");
        $sql->execute(array('ID_CLIENTE' => $idCorredora));
        $seguros = $sql->fetchAll();

        $siniestros = array();
        if($seguros != null) {

            foreach ($seguros as $seguro)
            {
                $sql = $pdo->prepare("SELECT * FROM siniestro WHERE ID_SEGURO = :ID_SEGURO AND HABILITADO=1");
                $sql->execute(array('ID_SEGURO' => $seguro['ID_SEGURO']));

                $siniestros1 = $sql->fetchAll();
                if($siniestros1 != null)
                {
                    foreach ($siniestros1 as $siniestro)
                    {
                        array_push($siniestros, $siniestro);
                    }
                }
            }

        }

        return $siniestros;
    }

    public function newSinister($idSeguro, $motivo, $nombre, $cargo, $telefono, $correo){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM siniestro WHERE ID_SEGURO =:ID_SEGURO");
        $sql->execute(array('ID_SEGURO' => $idSeguro));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            $sql = $pdo->prepare("INSERT INTO `siniestro`(`ID_SEGURO`, `MOTIVO`, `NOMBRE`, `SINIESTRO`, `TELEFONO`, `CORREO`, `HABILITADO`) VALUES (:ID_SEGURO, :MOTIVO, :NOMBRE, :SINIESTRO, :TELEFONO, :CORREO, 1)");
            $sql->execute(array('ID_SEGURO' => $idSeguro, 'MOTIVO' => $motivo, 'NOMBRE' => $nombre, 'SINIESTRO' => $cargo, 'TELEFONO' => $telefono, 'CORREO' => $correo));
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
            $message = "Este siniestro ya se encuentra registrado.";
        }
        
        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function getSinister($idSiniestro){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM siniestro WHERE ID_SINIESTRO=:ID_SINIESTRO AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_SINIESTRO' => $idSiniestro, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    //TODO: Aun falta
    public function editSinister($idSiniestro, $idSeguro, $motivo, $nombre, $cargo, $telefono, $correo){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE siniestro set NOMBRE =:NOMBRE WHERE ID_SINIESTRO=:ID_SINIESTRO");

        if ($sql->execute(array('NOMBRE' => $nombre, 'ID_SINIESTRO' => $idSiniestro ))) {
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

    public function deleteSinister($idSiniestro){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE siniestro set HABILITADO =:HABILITADO WHERE ID_SINIESTRO=:ID_SINIESTRO");

        if ($sql->execute(array('HABILITADO' => 0, 'ID_SINIESTRO' => $idSiniestro ))) {
            $status  = "success";
            $message = "El siniestro ha sido eliminado";
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