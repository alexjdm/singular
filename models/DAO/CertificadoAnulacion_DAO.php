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
            foreach ($idUsuarios as $idUsuario)
            {
                $sql = $pdo->prepare("SELECT * FROM certificado_solicitud WHERE ID_USUARIO_SOLICITANTE = :ID_USUARIO_SOLICITANTE AND HABILITADO = 1");
                $sql->execute(array('ID_USUARIO_SOLICITANTE' => $idUsuario['ID_USUARIO']));
                $solicitudesCertificados = $sql->fetchAll();

                if($solicitudesCertificados != null)
                {
                    foreach ($solicitudesCertificados as $solicitudCertificado)
                    {
                        $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_CERTIFICADO_SOLICITUD = :ID_CERTIFICADO_SOLICITUD AND HABILITADO = 1");
                        $sql->execute(array('ID_CERTIFICADO_SOLICITUD' => $solicitudCertificado['ID_CERTIFICADO_SOLICITUD']));
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
                }
            }
        }

        return $certificadosAnulacion;
    }

    public function newCertificateAnnulment($idCertificado, $idAsegurado, $motivo, $estado){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("INSERT INTO `certificado_anulacion`(`ID_CERTIFICADO`, `ID_ASEGURADO`,`MOTIVO`, `ESTADO`, `HABILITADO`) VALUES (:ID_CERTIFICADO, :ID_ASEGURADO, :MOTIVO, :ESTADO, 1)");
        $sql->execute(array('ID_CERTIFICADO' => $idCertificado, 'ID_ASEGURADO' => $idAsegurado, 'MOTIVO' => $motivo, 'ESTADO' => $estado));
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

    public function getCertificateAnnulment($idCertificadoAnulacion){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado_anulacion WHERE ID_CERTIFICADO_ANULACION=:ID_CERTIFICADO_ANULACION AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_CERTIFICADO_ANULACION' => $idCertificadoAnulacion, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function editCertificateAnnulment($idCertificadoAnulacion, $idCertificado, $idAsegurado, $motivo, $idCertificadoReemplazo, $estado){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE certificado_anulacion set ID_CERTIFICADO =:ID_CERTIFICADO, ID_ASEGURADO =:ID_ASEGURADO, MOTIVO =:MOTIVO, ID_CERTIFICADO_REEMPLAZO =:ID_CERTIFICADO_REEMPLAZO, ESTADO =:ESTADO WHERE ID_CERTIFICADO_ANULACION=:ID_CERTIFICADO_ANULACION");

        if ($sql->execute(array('ID_CERTIFICADO' => $idCertificado, 'ID_ASEGURADO' => $idAsegurado, 'MOTIVO' => $motivo, 'ID_CERTIFICADO_REEMPLAZO' => $idCertificadoReemplazo, 'ESTADO' => $estado, 'ID_CERTIFICADO_ANULACION' => $idCertificadoAnulacion ))) {
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