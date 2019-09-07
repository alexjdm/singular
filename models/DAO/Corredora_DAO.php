<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Corredora_DAO {

    public function getInsuranceBrokersList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM corredora WHERE HABILITADO='1' ORDER BY NOMBRE ASC");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getClients($idCorredora){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT ID_CLIENTE FROM corredora_cliente WHERE ID_CORREDORA = :ID_CORREDORA");
        $sql->execute(array('ID_CORREDORA' => $idCorredora));

        $idClientes = $sql->fetchAll();
        $clientes = array();
        if($idClientes != null)
        {
            $ids = '';
            $arrayIds = array();
            foreach ($idClientes as $idCliente) {
                array_push($arrayIds, $idCliente['ID_CLIENTE']);
            }
            $ids = join("','",$arrayIds);

            $sql = $pdo->prepare("SELECT * FROM corredora WHERE ID_CORREDORA in ('$ids') AND HABILITADO=1 ORDER BY NOMBRE ASC");
            $sql->execute(array());

            $clientes = $sql->fetchAll();

            /*foreach ($idClientes as $idCliente)
            {
                $sql = $pdo->prepare("SELECT * FROM corredora WHERE ID_CORREDORA = :ID_CORREDORA AND HABILITADO=1");
                $sql->execute(array('ID_CORREDORA' => $idCliente['ID_CLIENTE']));

                $cliente = $sql->fetchAll();
                if($cliente != null)
                {
                    foreach ($cliente as $cliente1)
                    {
                        array_push($clientes, $cliente1);
                    }
                }
            }*/
        }

        return $clientes;
    }

    public function getInsuranceBrokersByUserId($idUsuario){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT ID_CORREDORA FROM corredora_usuario WHERE ID_USUARIO = :ID_USUARIO");
        $sql->execute(array('ID_USUARIO' => $idUsuario));

        $idCorredoras = $sql->fetchAll();
        $corredoras = array();
        if($idCorredoras != null)
        {
            foreach ($idCorredoras as $idCorredora)
            {
                $sql = $pdo->prepare("SELECT * FROM corredora WHERE ID_CORREDORA = :ID_CORREDORA AND HABILITADO=1");
                $sql->execute(array('ID_CORREDORA' => $idCorredora['ID_CORREDORA']));

                $corredorasUsuario = $sql->fetchAll();
                if($corredorasUsuario != null)
                {
                    foreach ($corredorasUsuario as $corredoraUsuario)
                    {
                        array_push($corredoras, $corredoraUsuario);
                    }
                }
            }
        }

        return $corredoras;
    }

    public function getInsuranceBrokerByUserId($idUsuario){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM corredora_usuario WHERE ID_USUARIO = :ID_USUARIO");
        $sql->execute(array('ID_USUARIO' => $idUsuario));

        $idCorredora = $sql->fetchAll()[0];

        $sql = $pdo->prepare("SELECT * FROM corredora WHERE ID_CORREDORA = :ID_CORREDORA AND HABILITADO=1");
        $sql->execute(array('ID_CORREDORA' => $idCorredora['ID_CORREDORA']));

        $corredora = $sql->fetchAll()[0];
        return $corredora;

        /*
        $idCorredoras = $sql->fetchAll();
        $corredoras = array();
        if($idCorredoras != null)
        {
            foreach ($idCorredoras as $idCorredora)
            {
                $sql = $pdo->prepare("SELECT * FROM corredora WHERE ID_CORREDORA = :ID_CORREDORA AND HABILITADO=1");
                $sql->execute(array('ID_CORREDORA' => $idCorredora['ID_CORREDORA']));

                $corredorasUsuario = $sql->fetchAll();
                if($corredorasUsuario != null)
                {
                    foreach ($corredorasUsuario as $corredoraUsuario)
                    {
                        array_push($corredoras, $corredoraUsuario);
                    }
                }
            }
        }
        return $corredoras;
        */
    }

    public function newInsuranceBroker($nombre, $rut, $direccion, $ciudad, $telefono, $giro, $razonSocial, $tasa, $primaMin, $idVendedor, $idCorredoraCreadora){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM corredora WHERE RUT =:RUT AND HABILITADO = 1");
        $sql->execute(array('RUT' => $rut));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            $sql = $pdo->prepare("INSERT INTO `corredora`(`NOMBRE`, `RUT`, `DIRECCION`, `CIUDAD`, `TELEFONO`, `GIRO`, `RAZON_SOCIAL`, `TASA`, `PRIMA_MIN`, `ID_USUARIO_VENDEDOR`, `HABILITADO`) VALUES (:NOMBRE,:RUT,:DIRECCION,:CIUDAD,:TELEFONO,:GIRO,:RAZON_SOCIAL,:TASA,:PRIMA_MIN,:ID_USUARIO_VENDEDOR,1)");
            $sql->execute(array('NOMBRE' => $nombre, 'RUT' => $rut, 'DIRECCION' => $direccion, 'CIUDAD' => $ciudad, 'TELEFONO' => $telefono, 'GIRO' => $giro, 'RAZON_SOCIAL' => $razonSocial, 'TASA' => $tasa, 'PRIMA_MIN' => $primaMin, 'ID_USUARIO_VENDEDOR' => $idVendedor));
            $id = $pdo->lastInsertId();

            if(!empty($id)) {

                //Agregar la relación corredora cliente
                $sql = $pdo->prepare("INSERT INTO `corredora_cliente`(`ID_CORREDORA`, `ID_CLIENTE`) VALUES (:ID_CORREDORA,:ID_CLIENTE)");
                $sql->execute(array('ID_CORREDORA' => $idCorredoraCreadora, 'ID_CLIENTE' => $id));
                if($idCorredoraCreadora != 1)
                {
                    $sql->execute(array('ID_CORREDORA' => 1, 'ID_CLIENTE' => $id));
                }

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
            $message = "Este corredora ya se encuentra registrado.";
        }
        
        $data = array(
            'status'  => $status,
            'message' => $message,
            'id' => $id
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

    public function editInsuranceBroker($idCorredora, $nombre, $rut, $direccion, $ciudad, $telefono, $giro, $razonSocial, $tasa, $primaMin){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE corredora set NOMBRE =:NOMBRE, RUT =:RUT, DIRECCION=:DIRECCION, CIUDAD =:CIUDAD, TELEFONO =:TELEFONO, GIRO =:GIRO, RAZON_SOCIAL =:RAZON_SOCIAL, TASA =:TASA, PRIMA_MIN =:PRIMA_MIN WHERE ID_CORREDORA=:ID_CORREDORA");

        if ($sql->execute(array('NOMBRE' => $nombre, 'RUT' => $rut, 'DIRECCION' => $direccion, 'CIUDAD' => $ciudad, 'TELEFONO' => $telefono, 'GIRO' => $giro, 'RAZON_SOCIAL' => $razonSocial, 'TASA' => $tasa, 'PRIMA_MIN' => $primaMin, 'ID_CORREDORA' => $idCorredora ))) {
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
            $message = "La corredora ha sido eliminada.";
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