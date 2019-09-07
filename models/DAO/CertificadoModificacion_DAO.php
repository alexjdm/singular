<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class CertificadoModificacion_DAO {

    public function getCertificateModifiesList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado_modificacion WHERE HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getCertificateModifiesByState($estado){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado_modificacion WHERE ESTADO = :ESTADO AND HABILITADO='1'");
        $sql->execute(array('ESTADO' => $estado));

        return $sql->fetchAll();
    }

    public function getCertificateModifies($idCorredora)
    {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //$sql = $pdo->prepare("SELECT ID_USUARIO FROM corredora_usuario WHERE ID_CORREDORA = :ID_CORREDORA");
        $sql = $pdo->prepare("SELECT ID_USUARIO FROM usuario WHERE ID_CORREDORA = :ID_CORREDORA");
        $sql->execute(array('ID_CORREDORA' => $idCorredora));
        $idUsuarios = $sql->fetchAll();

        $certificadosModificacion = array();
        if ($idUsuarios != null) {
            $ids = '';
            $arrayIds = array();
            foreach ($idUsuarios as $idUsuario) {
                array_push($arrayIds, $idUsuario['ID_USUARIO']);
            }
            $ids = join("','",$arrayIds);

            $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_USUARIO_SOLICITANTE IN ('$ids') AND HABILITADO = 1");
            $sql->execute(array());
            $certificados = $sql->fetchAll();

            $ids = '';
            $arrayIds = array();
            foreach ($certificados as $certificado) {
                array_push($arrayIds, $certificado['ID_CERTIFICADO']);
            }
            $ids = join("','",$arrayIds);

            $sql = $pdo->prepare("SELECT * FROM certificado_modificacion WHERE ID_CERTIFICADO IN ('$ids') AND HABILITADO = 1");
            $sql->execute(array());
            $certificadosModificacion = $sql->fetchAll();
        }

        return $certificadosModificacion;
    }

    public function getCertificateModifiesByUsers($usuarios)
    {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $certificadosModificacion = array();
        if ($usuarios != null) {
            $ids = '';
            $arrayIds = array();
            foreach ($usuarios as $usuario) {
                array_push($arrayIds, $usuario['ID_USUARIO']);
            }
            $ids = join("','",$arrayIds);

            $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_USUARIO_SOLICITANTE IN ('$ids') AND ESTADO_SOLICITUD = 1 AND ESTADO_ANULACION != 1 AND HABILITADO = 1");
            $sql->execute(array());
            $certificados = $sql->fetchAll();

            $ids = '';
            $arrayIds = array();
            foreach ($certificados as $certificado) {
                array_push($arrayIds, $certificado['ID_CERTIFICADO']);
            }
            $ids = join("','",$arrayIds);

            $sql = $pdo->prepare("SELECT * FROM certificado_modificacion WHERE ID_CERTIFICADO IN ('$ids') AND HABILITADO = 1");
            $sql->execute(array());
            $certificadosModificacion = $sql->fetchAll();
        }

        return $certificadosModificacion;
    }

    public function getCertificateModifiesByInsuredBrokerAndState($idCorredora, $estado){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT ID_USUARIO FROM corredora_usuario WHERE ID_CORREDORA = :ID_CORREDORA");
        $sql->execute(array('ID_CORREDORA' => $idCorredora));
        $idUsuarios = $sql->fetchAll();

        $certificadosModificacion = array();
        if($idUsuarios != null)
        {
            $ids = '';
            $arrayIds = array();
            foreach ($idUsuarios as $idUsuario) {
                array_push($arrayIds, $idUsuario['ID_USUARIO']);
            }
            $ids = join("','",$arrayIds);

            $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_USUARIO_SOLICITANTE in ('$ids') AND HABILITADO = 1");
            $sql->execute(array());
            $certificados = $sql->fetchAll();

            $ids = '';
            foreach ($certificados as $certificado)
            {
                $ids = $ids . $certificado['ID_CERTIFICADO'] . ',';
            }
            substr($ids, 0, -1);

            $sql = $pdo->prepare("SELECT * FROM certificado_modificacion WHERE ID_CERTIFICADO IN (:ID_CERTIFICADO) AND ESTADO = :ESTADO AND HABILITADO = 1");
            $sql->execute(array('ID_CERTIFICADO' => $ids, 'ESTADO' => $estado));
            $certificadosModificacion = $sql->fetchAll();
        }

        return $certificadosModificacion;
    }

    public function getCertificateModifiesByUsersAndState($usuarios, $estado){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $certificadosModificacion = array();
        if($usuarios != null)
        {
            $ids = '';
            $arrayIds = array();
            foreach ($usuarios as $usuario) {
                array_push($arrayIds, $usuario['ID_USUARIO']);
            }
            $ids = join("','",$arrayIds);

            $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_USUARIO_SOLICITANTE in ('$ids') AND ESTADO_SOLICITUD = 1 AND ESTADO_ANULACION != 1 AND HABILITADO = 1");
            $sql->execute(array());
            $certificados = $sql->fetchAll();

            $ids = '';
            foreach ($certificados as $certificado)
            {
                $ids = $ids . $certificado['ID_CERTIFICADO'] . ',';
            }
            substr($ids, 0, -1);

            $sql = $pdo->prepare("SELECT * FROM certificado_modificacion WHERE ID_CERTIFICADO IN (:ID_CERTIFICADO) AND ESTADO = :ESTADO AND HABILITADO = 1");
            $sql->execute(array('ID_CERTIFICADO' => $ids, 'ESTADO' => $estado));
            $certificadosModificacion = $sql->fetchAll();
        }

        return $certificadosModificacion;
    }

    public function newCertificateModify($idCertificado, $dondeDice, $debeDecir){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        date_default_timezone_set('America/Santiago');
        $fecha = date("Y-m-d H:i:s");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("INSERT INTO `certificado_modificacion`(`ID_CERTIFICADO`,`DONDE_DICE`, `DEBE_DECIR`, `FECHA_SOLICITUD_MODIFICACION`, `ESTADO`, `HABILITADO`) VALUES (:ID_CERTIFICADO, :DONDE_DICE, :DEBE_DECIR, :FECHA_SOLICITUD_MODIFICACION, 0, 1)");
        $sql->execute(array('ID_CERTIFICADO' => $idCertificado, 'DONDE_DICE' => $dondeDice, 'DEBE_DECIR' => $debeDecir, 'FECHA_SOLICITUD_MODIFICACION' => $fecha));
        $id = $pdo->lastInsertId();

        if(!empty($id)) {
            $status  = "success";
            $message = "Registro exitoso.";
        }
        else{
            $status  = "error";
            $message = "Error con la base de datos, por favor intente nuevamente.";
        }
        
        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function getCertificateModify($idCertificadoModificacion){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado_modificacion WHERE ID_CERTIFICADO_MODIFICACION=:ID_CERTIFICADO_MODIFICACION AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_CERTIFICADO_MODIFICACION' => $idCertificadoModificacion, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function editCertificateModify($idCertificadoModificacion, $idCertificado, $dondeDice, $debeDecir){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE certificado_modificacion set ID_CERTIFICADO =:ID_CERTIFICADO, DONDE_DICE =:DONDE_DICE, DEBE_DECIR =:DEBE_DECIR WHERE ID_CERTIFICADO_MODIFICACION=:ID_CERTIFICADO_MODIFICACION");

        if ($sql->execute(array('ID_CERTIFICADO' => $idCertificado, 'DONDE_DICE' => $dondeDice, 'DEBE_DECIR' => $debeDecir, 'ID_CERTIFICADO_MODIFICACION' => $idCertificadoModificacion ))) {
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

    public function setCertificateModify($idCertificadoModificacion, $estado){

        date_default_timezone_set('America/Santiago');
        $fecha = date("Y-m-d H:i:s");


        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE certificado_modificacion set ESTADO =:ESTADO, FECHA_MODIFICACION =:FECHA_MODIFICACION WHERE ID_CERTIFICADO_MODIFICACION=:ID_CERTIFICADO_MODIFICACION");

        if ($sql->execute(array('ESTADO' => $estado, 'FECHA_MODIFICACION' => $fecha, 'ID_CERTIFICADO_MODIFICACION' => $idCertificadoModificacion ))) {
            $status  = "success";
            $message = "La solicitud de modificación del certificado ha sido realizada.";
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

        //echo json_encode($data);

        Database::disconnect();
    }

    public function deleteCertificateModify($idCertificadoModificacion){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE certificado_modificacion set HABILITADO = 0 WHERE ID_CERTIFICADO_MODIFICACION=:ID_CERTIFICADO_MODIFICACION");

        if ($sql->execute(array('ID_CERTIFICADO_MODIFICACION' => $idCertificadoModificacion ))) {
            $status  = "success";
            $message = "La solicitud de modificación del certificado ha sido eliminada.";
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