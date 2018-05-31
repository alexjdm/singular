<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class PolizaGarantia_DAO {

    public function getGuaranteePoliciesList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM poliza_garantia WHERE HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getGuaranteePolicyByState($state){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM poliza_garantia WHERE ESTADO=:ESTADO AND HABILITADO=:HABILITADO");
        $sql->execute(array('ESTADO' => $state, 'HABILITADO' => 1));

        return $sql->fetchAll();
    }


    public function newGuaranteePolicy($idAsegurado, $idTipoMercaderia, $idCorredora, $idEmbalaje, $direccion, $fechaInicio, $plazo, $montoCIF, $derechos){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM poliza_garantia WHERE ID_TIPO_MERCADERIA =:ID_TIPO_MERCADERIA");
        $sql->execute(array('ID_TIPO_MERCADERIA' => $idTipoMercaderia));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            $sql = $pdo->prepare("INSERT INTO `poliza_garantia`(`ID_ASEGURADO`, `ID_TIPO_MERCADERIA`, `ID_CORREDORA`, `ID_EMBALAJE`, `DIRECCION`, `FECHA_INICIO`, `PLAZO`, `MONTO_CIF`, `DERECHOS`, `HABILITADO`) VALUES (:ID_ASEGURADO, :ID_TIPO_MERCADERIA, :ID_CORREDORA, :ID_EMBALAJE, :DIRECCION, :FECHA_INICIO, :PLAZO, :MONTO_CIF, :DERECHOS, 1)");
            $sql->execute(array('ID_ASEGURADO' => $idAsegurado, 'ID_TIPO_MERCADERIA' => $idTipoMercaderia, 'ID_CORREDORA' => $idCorredora, 'ID_EMBALAJE' => $idEmbalaje, 'DIRECCION' => $direccion, 'FECHA_INICIO' => $fechaInicio, 'PLAZO' => $plazo, 'MONTO_CIF' => $montoCIF, 'DERECHOS' => $derechos));
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
            $message = "Este garantía ya se encuentra registrado.";
        }
        
        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function getGuaranteePolicy($idGarantia){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM poliza_garantia WHERE ID_GARANTIA=:ID_GARANTIA AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_GARANTIA' => $idGarantia, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function editGuaranteePolicy($idGarantia, $idAsegurado, $idTipoMercaderia, $idCorredora, $idEmbalaje, $direccion, $fechaInicio, $plazo, $montoCIF, $derechos){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE poliza_garantia set ID_ASEGURADO =:ID_ASEGURADO, ID_TIPO_MERCADERIA =:ID_TIPO_MERCADERIA, ID_CORREDORA =:ID_CORREDORA, ID_EMBALAJE = :ID_EMBALAJE, DIRECCION = :DIRECCION, FECHA_INICIO = :FECHA_INICIO, PLAZO = :PLAZO, MONTO_CIF = :MONTO_CIF, DERECHOS = :DERECHOS WHERE ID_GARANTIA=:ID_GARANTIA");

        if ($sql->execute(array('ID_ASEGURADO' => $idAsegurado, 'ID_TIPO_MERCADERIA' => $idTipoMercaderia, 'ID_CORREDORA' => $idCorredora, 'ID_EMBALAJE' => $idEmbalaje, 'DIRECCION' => $direccion, 'FECHA_INICIO' => $fechaInicio, 'PLAZO' => $plazo, 'MONTO_CIF' => $montoCIF, 'DERECHOS' => $derechos, 'ID_GARANTIA' => $idGarantia))) {
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

    public function deleteGuaranteePolicy($idGarantia){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE poliza_garantia set HABILITADO =:HABILITADO WHERE ID_GARANTIA=:ID_GARANTIA");

        if ($sql->execute(array('HABILITADO' => 0, 'ID_GARANTIA' => $idGarantia ))) {
            $status  = "success";
            $message = "La garantía ha sido eliminado";
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