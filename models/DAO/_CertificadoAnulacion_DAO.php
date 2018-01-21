<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class CertificadoAnulacion_DAO {

    public function getCertificateAnnulmentsList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado_anulacion WHERE HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getCertificateAnnulments($idCorredora){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT ID_USUARIO FROM corredora_usuario WHERE ID_CORREDORA = :ID_CORREDORA");
        $sql->execute(array('ID_CORREDORA' => $idCorredora));
        $idUsuarios = $sql->fetchAll();

        $certificadosAnulacion = array();
        if($idUsuarios != null)
        {
            $ids = '';
            $arrayIds = array();
            foreach ($idUsuarios as $idUsuario) {
                array_push($arrayIds, $idUsuario['ID_USUARIO']);
            }
            $ids = join("','",$arrayIds);

            $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_USUARIO_SOLICITANTE in ('$ids') AND ESTADO ='0' AND HABILITADO = 1");
            $sql->execute(array());
            $certificados = $sql->fetchAll();

            if($certificados != null)
            {
                foreach ($certificados as $certificado)
                {
                    $sql = $pdo->prepare("SELECT * FROM certificado_anulacion WHERE ID_CERTIFICADO = :ID_CERTIFICADO AND HABILITADO = 1");
                    $sql->execute(array('ID_CERTIFICADO' => $certificado['ID_CERTIFICADO']));
                    $anulacionCertificados = $sql->fetchAll();

                    if($anulacionCertificados != null)
                    {
                        foreach ($anulacionCertificados as $anulacionCertificado)
                        {
                            array_push($certificadosAnulacion, $anulacionCertificado);
                        }
                    }
                }
            }
        }

        return $certificadosAnulacion;
    }

    public function newCertificateAnnulment($idCertificado, $motivo){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado_anulacion WHERE ID_CERTIFICADO = :ID_CERTIFICADO AND ESTADO = 0");
        $sql->execute(array('ID_CERTIFICADO' => $idCertificado));
        $anulacion = $sql->fetchAll();

        if($anulacion != null)
        {
            $sql = $pdo->prepare("INSERT INTO `certificado_anulacion`(`ID_CERTIFICADO`, `MOTIVO`, `ESTADO`, `HABILITADO`) VALUES (:ID_CERTIFICADO, :MOTIVO, :ESTADO, 1)");
            $sql->execute(array('ID_CERTIFICADO' => $idCertificado, 'MOTIVO' => $motivo, 'ESTADO' => 0));
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
        else
        {
            $status  = "error";
            $message = "Ya existe una solicitud de anulación sin procesar para este certificado.";
        }
        
        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function getCertificateAnnulment($idCertificadoAnulacion){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado_anulacion WHERE ID_CERTIFICADO_ANULACION=:ID_CERTIFICADO_ANULACION AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_CERTIFICADO_ANULACION' => $idCertificadoAnulacion, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function editCertificateAnnulment($idCertificadoAnulacion, $idCertificado, $motivo){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE certificado_anulacion set ID_CERTIFICADO =:ID_CERTIFICADO, MOTIVO =:MOTIVO WHERE ID_CERTIFICADO_ANULACION=:ID_CERTIFICADO_ANULACION");

        if ($sql->execute(array('ID_CERTIFICADO' => $idCertificado, 'MOTIVO' => $motivo, 'ID_CERTIFICADO_ANULACION' => $idCertificadoAnulacion ))) {
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

    public function deleteCertificateAnnulment($idCertificadoAnulacion){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE certificado_anulacion set HABILITADO =:HABILITADO WHERE ID_CERTIFICADO_ANULACION=:ID_CERTIFICADO_ANULACION");

        if ($sql->execute(array('HABILITADO' => 0, 'ID_CERTIFICADO_ANULACION' => $idCertificadoAnulacion ))) {
            $status  = "success";
            $message = "La solicitud de anulación del certificado ha sido eliminada";
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