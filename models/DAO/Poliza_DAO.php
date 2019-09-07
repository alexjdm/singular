<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Poliza_DAO {

    public function getAllPolicies(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM poliza");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getPoliciesList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM poliza WHERE HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getValidatePoliciesList(){

        $fechaActual = date("Y-m-d");
        $fechaHace3meses = date('Y-m-d', strtotime(date('Y-m-d'). ' - 3 months'));

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM poliza WHERE ((FECHA_INICIO <= '$fechaHace3meses' AND '$fechaHace3meses' <= FECHA_FIN) OR (FECHA_INICIO <= '$fechaActual' AND '$fechaActual' <= FECHA_FIN)) AND HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function newPolicy($idCompania, $tipoPoliza, $numeroPoliza){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM poliza WHERE TIPO_POLIZA =:TIPO_POLIZA AND NUMERO =:NUMERO AND ID_COMPANIA =:ID_COMPANIA");
        $sql->execute(array('TIPO_POLIZA' => $tipoPoliza, 'NUMERO' => $numeroPoliza, 'ID_COMPANIA' => $idCompania));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            $sql = $pdo->prepare("INSERT INTO `poliza`(`ID_COMPANIA`, `TIPO_POLIZA`, `NUMERO`, `HABILITADO`) VALUES (:ID_COMPANIA, :TIPO_POLIZA, :NUMERO, 1)");
            $sql->execute(array('ID_COMPANIA' => $idCompania, 'TIPO_POLIZA' => $tipoPoliza, 'NUMERO' => $numeroPoliza));
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
            $message = "Este poliza ya se encuentra registrado.";
        }
        
        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function getPolicy($idPoliza){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM poliza WHERE ID_POLIZA=:ID_POLIZA AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_POLIZA' => $idPoliza, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function editPolicy($idPoliza, $idCompania, $tipoPoliza, $numeroPoliza){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE poliza set ID_COMPANIA = :ID_COMPANIA, TIPO_POLIZA = :TIPO_POLIZA, NUMERO = :NUMERO  WHERE ID_POLIZA=:ID_POLIZA");

        if ($sql->execute(array('ID_COMPANIA' => $idCompania, 'TIPO_POLIZA' => $tipoPoliza, 'NUMERO' => $numeroPoliza, 'ID_POLIZA' => $idPoliza))) {
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

    public function deletePolicy($idPoliza){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE poliza set HABILITADO =:HABILITADO WHERE ID_POLIZA=:ID_POLIZA");

        if ($sql->execute(array('HABILITADO' => 0, 'ID_POLIZA' => $idPoliza))) {
            $status  = "success";
            $message = "La poliza ha sido eliminado";
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