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

    public function getSinistersByUsers($usuarios){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM siniestro WHERE HABILITADO='1'");
        $sql->execute();
        $siniestros = $sql->fetchAll();
        $ids = array();
        foreach($siniestros as $siniestro)
        {
            array_push($ids, $siniestro['ID_CERTIFICADO']);
        }

        $idsCertificados = implode(",", $ids);

        $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_CERTIFICADO in ($idsCertificados) AND ESTADO_SOLICITUD = 1 AND ESTADO_ANULACION != 1 AND HABILITADO='1'");
        $sql->execute();
        $certificados = $sql->fetchAll();
        $certificadosFinal = array();
        foreach ($usuarios as $usuario) {
            foreach ($certificados as $certificado)
            {
                if($certificado['ID_USUARIO_SOLICITANTE'] == $usuario['ID_USUARIO'])
                    array_push($certificadosFinal, $certificado);
            }
        }

        $siniestroFinal = array();
        if(isset($certificadosFinal) && count($certificadosFinal) > 0)
        {
            foreach ($siniestros as $siniestro)
            {
                foreach ($certificadosFinal as $certificado)
                {
                    if($certificado['ID_CERTIFICADO'] == $siniestro['ID_CERTIFICADO'])
                        array_push($siniestroFinal, $siniestro);
                }
            }
        }

        return $siniestroFinal;
    }

    public function getSinistersByUsersByState($usuarios, $state){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM siniestro WHERE ESTADO = '$state' AND HABILITADO='1'");
        $sql->execute();
        $siniestros = $sql->fetchAll();
        $ids = array();
        foreach($siniestros as $siniestro)
        {
            array_push($ids, $siniestro['ID_CERTIFICADO']);
        }

        $idsCertificados = implode(",", $ids);

        $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_CERTIFICADO in ($idsCertificados) AND ESTADO_SOLICITUD = 1 AND ESTADO_ANULACION != 1 AND HABILITADO='1'");
        $sql->execute();
        $certificados = $sql->fetchAll();
        $certificadosFinal = array();
        foreach ($usuarios as $usuario) {
            foreach ($certificados as $certificado)
            {
                if($certificado['ID_USUARIO_SOLICITANTE'] == $usuario['ID_USUARIO'])
                    array_push($certificadosFinal, $certificado);
            }
        }

        $siniestroFinal = array();
        if(isset($certificadosFinal) && count($certificadosFinal) > 0)
        {
            foreach ($siniestros as $siniestro)
            {
                foreach ($certificadosFinal as $certificado)
                {
                    if($certificado['ID_CERTIFICADO'] == $siniestro['ID_CERTIFICADO'])
                        array_push($siniestroFinal, $siniestro);
                }
            }
        }

        return $siniestroFinal;
    }

    public function getSinistersByDates($fechaInicio, $fechaFin){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM siniestro WHERE '$fechaInicio' <= FECHA_SOLICITUD and FECHA_SOLICITUD <= '$fechaFin' and HABILITADO='1'");
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

    public function newSinister($idCertificado, $motivo, $nombre, $telefono, $correo){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        date_default_timezone_set('America/Santiago');
        $fecha = date("Y-m-d H:i:s");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM siniestro WHERE ID_CERTIFICADO =:ID_CERTIFICADO");
        $sql->execute(array('ID_CERTIFICADO' => $idCertificado));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            $sql = $pdo->prepare("INSERT INTO `siniestro`(`ID_CERTIFICADO`, `MOTIVO`, `NOMBRE`, `TELEFONO`, `CORREO`, `FECHA_SOLICITUD`, `HABILITADO`) VALUES (:ID_CERTIFICADO, :MOTIVO, :NOMBRE, :TELEFONO, :CORREO, :FECHA_SOLICITUD, 1)");
            $sql->execute(array('ID_CERTIFICADO' => $idCertificado, 'MOTIVO' => $motivo, 'NOMBRE' => $nombre, 'TELEFONO' => $telefono, 'CORREO' => $correo, 'FECHA_SOLICITUD' => $fecha));
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

    public function editSinister($idSiniestro, $idCertificado, $motivo, $nombre, $telefono, $correo, $numero){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE siniestro set ID_CERTIFICADO =:ID_CERTIFICADO, MOTIVO =:MOTIVO, NOMBRE =:NOMBRE, TELEFONO =:TELEFONO, CORREO =:CORREO, NUMERO =:NUMERO WHERE ID_SINIESTRO=:ID_SINIESTRO");

        if ($sql->execute(array('ID_CERTIFICADO' => $idCertificado, 'MOTIVO' => $motivo, 'NOMBRE' => $nombre, 'TELEFONO' => $telefono, 'CORREO' => $correo, 'NUMERO' => $numero, 'ID_SINIESTRO' => $idSiniestro ))) {
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

    public function editSinisterFromStadistic($idSiniestro, $siniestro, $montoProvision, $indemnizacion) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE siniestro set SINIESTRO =:SINIESTRO, MONTO_PROVISION =:MONTO_PROVISION, INDEMNIZACION =:INDEMNIZACION WHERE ID_SINIESTRO=:ID_SINIESTRO");

        if ($sql->execute(array('SINIESTRO' => $siniestro, 'MONTO_PROVISION' => $montoProvision, 'INDEMNIZACION' => $indemnizacion, 'ID_SINIESTRO' => $idSiniestro ))) {
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

    public function addSinisterDoc($idSiniestro, $ubicacion){

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE siniestro set UBICACION =:UBICACION, ESTADO = 1 WHERE ID_SINIESTRO=:ID_SINIESTRO");

        if ($sql->execute(array('UBICACION' => $ubicacion, 'ID_SINIESTRO' => $idSiniestro ))) {
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

}