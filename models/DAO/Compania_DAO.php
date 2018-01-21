<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Compania_DAO {

    public function getCompaniesList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM compania WHERE HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function newCompany($nombre, $tasa, $prima_minima, $limite_embarque, $tipo_cuenta, $comision){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM compania WHERE NOMBRE =:NOMBRE");
        $sql->execute(array('NOMBRE' => $nombre));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            $sql = $pdo->prepare("INSERT INTO `compania`(`NOMBRE`, `TASA`, `PRIMA_MINIMA`, `LIMITE_EMBARQUE`, `TIPO_CUENTA`, `COMISION`, `HABILITADO`) VALUES (:nombre,:tasa,:prima_minima,:limite_embarque,:tipo_cuenta,:comision,1)");
            $sql->execute(array('nombre' => $nombre, 'tasa' => $tasa, 'prima_minima' => $prima_minima, 'limite_embarque' => $limite_embarque, 'tipo_cuenta' => $tipo_cuenta, 'comision' => $comision));
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
            $message = "Esta compañia ya se encuentra registrada.";
        }


        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function getCompany($idCompania){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM compania WHERE ID_COMPANIA=:ID_COMPANIA AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_COMPANIA' => $idCompania, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function editCompany($idCompania, $nombre, $tasa, $prima_minima, $limite_embarque, $tipo_cuenta, $comision){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE compania set NOMBRE =:NOMBRE, TASA =:TASA, PRIMA_MINIMA=:PRIMA_MINIMA, LIMITE_EMBARQUE =:LIMITE_EMBARQUE, TIPO_CUENTA =:TIPO_CUENTA, COMISION =:COMISION WHERE ID_COMPANIA=:ID_COMPANIA");

        if ($sql->execute(array('NOMBRE' => $nombre, 'TASA' => $tasa, 'PRIMA_MINIMA' => $prima_minima, 'LIMITE_EMBARQUE' => $limite_embarque, 'TIPO_CUENTA' => $tipo_cuenta, 'COMISION' => $comision, 'ID_COMPANIA' => $idCompania ))) {
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

    public function deleteCompany($idCompania){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE compania set HABILITADO =:HABILITADO WHERE ID_COMPANIA=:ID_COMPANIA");

        if ($sql->execute(array('HABILITADO' => 0, 'ID_COMPANIA' => $idCompania ))) {
            $status  = "success";
            $message = "La compañia ha sido eliminado";
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