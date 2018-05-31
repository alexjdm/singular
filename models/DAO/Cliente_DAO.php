<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Cliente_DAO {

    public function getClientsList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM cliente WHERE HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function newClient($nombre, $rut, $direccion, $ciudad, $telefono, $giro, $razonSocial, $tasa, $primaMin){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM cliente WHERE RUT =:RUT");
        $sql->execute(array('RUT' => $rut));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            $sql = $pdo->prepare("INSERT INTO `cliente`(`NOMBRE`, `RUT`, `DIRECCION`, `CIUDAD`, `TELEFONO`, `GIRO`, `RAZON_SOCIAL`, `TASA`, `PRIMA_MIN`, `HABILITADO`) VALUES (:NOMBRE,:RUT,:DIRECCION,:CIUDAD,:TELEFONO,:GIRO,:RAZON_SOCIAL,:TASA,:PRIMA_MIN,1)");
            $sql->execute(array('NOMBRE' => $nombre, 'RUT' => $rut, 'DIRECCION' => $direccion, 'CIUDAD' => $ciudad, 'TELEFONO' => $telefono, 'GIRO' => $giro, 'RAZON_SOCIAL' => $razonSocial, 'TASA' => $tasa, 'PRIMA_MIN' => $primaMin));
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
            $message = "Este cliente ya se encuentra registrado.";
        }
        
        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function getClient($idCliente){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM cliente WHERE ID_CLIENTE=:ID_CLIENTE AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_CLIENTE' => $idCliente, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function editClient($idCliente, $nombre, $rut, $direccion, $ciudad, $telefono, $giro, $razonSocial, $tasa, $primaMin){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE cliente set NOMBRE =:NOMBRE, RUT =:RUT, DIRECCION=:DIRECCION, CIUDAD =:CIUDAD, TELEFONO =:TELEFONO, GIRO =:GIRO, RAZON_SOCIAL =:RAZON_SOCIAL, TASA =:TASA, PRIMA_MIN =:PRIMA_MIN WHERE ID_CLIENTE=:ID_CLIENTE");

        if ($sql->execute(array('NOMBRE' => $nombre, 'RUT' => $rut, 'DIRECCION' => $direccion, 'CIUDAD' => $ciudad, 'TELEFONO' => $telefono, 'GIRO' => $giro, 'RAZON_SOCIAL' => $razonSocial, 'TASA' => $tasa, 'PRIMA_MIN' => $primaMin, 'ID_CLIENTE' => $idCliente ))) {
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

    public function deleteClient($idCliente){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE cliente set HABILITADO =:HABILITADO WHERE ID_CLIENTE=:ID_CLIENTE");

        if ($sql->execute(array('HABILITADO' => 0, 'ID_CLIENTE' => $idCliente ))) {
            $status  = "success";
            $message = "El cliente ha sido eliminado";
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