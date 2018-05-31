<?php
/**
 * Created by PhpStorm.
 * Insured: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Asegurado_DAO {

    public function getInsuredList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM asegurado WHERE HABILITADO='1' ORDER BY NOMBRE ASC");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getInsured($idAsegurado){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM asegurado WHERE ID_ASEGURADO=:ID_ASEGURADO AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_ASEGURADO' => $idAsegurado, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function getInsuredByState($state, $idsUsuariosCorredora){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM asegurado WHERE ESTADO=:ESTADO AND HABILITADO=:HABILITADO");
        $sql->execute(array('ESTADO' => $state, 'HABILITADO' => 1));

        $asegurados = $sql->fetchAll();
        $aseguradosCorredora = array();
        foreach ($asegurados as $asegurado)
        {
            foreach ($idsUsuariosCorredora as $id)
                if($asegurado['ID_USUARIO_CREADOR'] == $id)
                    array_push($aseguradosCorredora, $asegurado);
        }

        return $aseguradosCorredora;
    }

    public function getInsuredByInsuranceBrokerId($idsUsuariosCorredora){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM asegurado WHERE ID_USUARIO_CREADOR IN ('$idsUsuariosCorredora') AND HABILITADO = 1");
        $sql->execute();

        $aseguradosCorredora = $sql->fetchAll();

        return $aseguradosCorredora;
    }

    public function editInsured($idAsegurado, $rut, $nombre, $giro, $idRegion, $idComuna, $direccion, $estado){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        date_default_timezone_set('America/Santiago');
        $fechaModificacion = date("Y-m-d H:i:s");

        $sql = $pdo->prepare("UPDATE asegurado set IDENTIFICADOR =:IDENTIFICADOR, NOMBRE =:NOMBRE, GIRO =:GIRO, ID_REGION =:ID_REGION, ID_COMUNA =:ID_COMUNA, DIRECCION =:DIRECCION, ESTADO =:ESTADO, FECHA_MODIFICACION =:FECHA_MODIFICACION WHERE ID_ASEGURADO=:ID_ASEGURADO");

        if ($sql->execute(array('IDENTIFICADOR' => $rut, 'NOMBRE' => $nombre, 'GIRO' => $giro, 'ID_REGION' => $idRegion, 'ID_COMUNA' => $idComuna, 'DIRECCION' => $direccion, 'ESTADO' => $estado, 'FECHA_MODIFICACION' => $fechaModificacion, 'ID_ASEGURADO' => $idAsegurado))) {
            $status  = "success";
            $message = "Los datos han sido actualizados.";
        }
        else
        {
            $status  = "error";
            $message = "Ha ocurrido un problema con la actualización de tu contraseña.";
        }

        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function deleteInsured($idAsegurado){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE asegurado set HABILITADO =:HABILITADO WHERE ID_ASEGURADO=:ID_ASEGURADO");

        if ($sql->execute(array('HABILITADO' => 0, 'ID_ASEGURADO' => $idAsegurado ))) {
            $status  = "success";
            $message = "El asegurado ha sido eliminado";
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

    public function validateInsured($idAsegurado){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE asegurado set ESTADO =:ESTADO WHERE ID_ASEGURADO=:ID_ASEGURADO");

        if ($sql->execute(array('ESTADO' => 1, 'ID_ASEGURADO' => $idAsegurado ))) {
            $status  = "success";
            $message = "El asegurado ha sido marcado como ingresado.";
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

    public function invalidateInsured($idAsegurado){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE asegurado set ESTADO =:ESTADO WHERE ID_ASEGURADO=:ID_ASEGURADO");

        if ($sql->execute(array('ESTADO' => 0, 'ID_ASEGURADO' => $idAsegurado ))) {
            $status  = "success";
            $message = "El asegurado ha sido marcado como no ingresado.";
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

    public function newInsured($idUsuario, $rut, $nombre, $giro, $idRegion, $idComuna, $direccion, $estado){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        date_default_timezone_set('America/Santiago');
        $fechaCreacion = date("Y-m-d H:i:s");

        $sql = $pdo->prepare("SELECT * FROM asegurado WHERE IDENTIFICADOR=:IDENTIFICADOR");
        $sql->execute(array('IDENTIFICADOR' => $rut));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            $sql = $pdo->prepare("INSERT INTO `asegurado`(`ID_USUARIO_CREADOR`, `IDENTIFICADOR`, `NOMBRE`, `GIRO`, `ID_REGION`, `ID_COMUNA`, `DIRECCION`, `FECHA_CREACION`, `ESTADO`, `HABILITADO`, `FECHA_MODIFICACION`) VALUES (:ID_USUARIO_CREADOR, :IDENTIFICADOR,:NOMBRE,:GIRO,:ID_REGION,:ID_COMUNA,:DIRECCION,:FECHA_CREACION,:ESTADO, 1, :FECHA_MODIFICACION)");
            $sql->execute(array('ID_USUARIO_CREADOR' => $idUsuario, 'IDENTIFICADOR' => $rut, 'NOMBRE' => $nombre, 'GIRO' => $giro, 'ID_REGION' => $idRegion, 'ID_COMUNA' => $idComuna, 'DIRECCION' => $direccion, 'FECHA_CREACION' => $fechaCreacion, 'ESTADO' => $estado, 'FECHA_MODIFICACION' => $fechaCreacion ));
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

        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }


}