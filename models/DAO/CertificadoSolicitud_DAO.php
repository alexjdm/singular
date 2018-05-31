<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class CertificadoSolicitud_DAO {

    public function getCertificateRequestsList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado_solicitud WHERE HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getCertificateRequests($idCorredora){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT ID_USUARIO FROM corredora_usuario WHERE ID_CORREDORA = :ID_CORREDORA");
        $sql->execute(array('ID_CORREDORA' => $idCorredora));
        $idUsuarios = $sql->fetchAll();

        $certificadoSolicitudes = array();
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
                        array_push($certificadoSolicitudes, $solicitudCertificado);
                    }
                }
            }
        }

        return $certificadoSolicitudes;
    }

    public function newCertificateRequest($idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo, $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloAvion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada, $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones, $estado){

        date_default_timezone_set('America/Santiago');
        $fechaSolicitud = date("Y-m-d H:i:s");

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("INSERT INTO `certificado_solicitud`(`ID_ASEGURADO`, `ID_TIPO_MERCADERIA`, `ID_POLIZA`, `A_FAVOR_DE`, `TIPO`, `ORIGEN`, `DESTINO`, `VIA`, `FECHA_EMBARQUE`, `TRANSPORTISTA`, `NAVE_VUELO_CAMION`, `BL_AWB_CRT`, `REFERENCIA_DESPACHO`, `ID_MATERIA_ASEGURADA`, `DETALLE_MERCADERIA`, `ID_EMBALAJE`, `MONTO_ASEGURADO_CIF`, `TASA`, `PRIMA_MIN`, `PRIMA_SEGURO`, `OBSERVACIONES`, `ESTADO`, `FECHA_SOLICITUD`, `HABILITADO`) VALUES (:ID_ASEGURADO, :ID_TIPO_MERCADERIA, :ID_POLIZA, :A_FAVOR_DE, :TIPO,  :ORIGEN, :DESTINO, :VIA, :FECHA_EMBARQUE, :TRANSPORTISTA, :NAVE_VUELO_CAMION, :BL_AWB_CRT, :REFERENCIA_DESPACHO, :ID_MATERIA_ASEGURADA, :DETALLE_MERCADERIA, :ID_EMBALAJE, :MONTO_ASEGURADO_CIF, :TASA, :PRIMA_MIN, :PRIMA_SEGURO, :OBSERVACIONES, :ESTADO, :FECHA_SOLICITUD, 1)");
        $sql->execute(array('ID_ASEGURADO' => $idAsegurado, 'ID_TIPO_MERCADERIA' => $idTipoMercaderia, 'ID_POLIZA' => $idPoliza, 'A_FAVOR_DE' => $aFavorDe, 'TIPO' => $tipo, 'ORIGEN' => $origen, 'DESTINO' => $destino, 'VIA' => $via, 'FECHA_EMBARQUE' => $fechaEmbarque, 'TRANSPORTISTA' => $transportista, 'NAVE_VUELO_CAMION' => $naveVueloAvion, 'BL_AWB_CRT' => $blAwbCrt, 'REFERENCIA_DESPACHO' => $referenciaDespacho, 'ID_MATERIA_ASEGURADA' => $idMateriaAsegurada, 'DETALLE_MERCADERIA' => $detalleMercaderia, 'ID_EMBALAJE' => $idEmbalaje, 'MONTO_ASEGURADO_CIF' => $montoAseguradoCIF, 'TASA' => $tasa, 'PRIMA_MIN' => $primaMin, 'PRIMA_SEGURO' => $primaSeguro, 'OBSERVACIONES' => $observaciones, 'ESTADO' => $estado, 'FECHA_SOLICITUD' => $fechaSolicitud));
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

    public function getCertificateRequest($idCertificadoSolicitud){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado_solicitud WHERE ID_CERTIFICADO_SOLICITUD=:ID_CERTIFICADO_SOLICITUD AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_CERTIFICADO_SOLICITUD' => $idCertificadoSolicitud, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function editCertificateRequest($idCertificadoSolicitud, $idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo, $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloAvion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada, $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE certificado_solicitud set ID_ASEGURADO =:ID_ASEGURADO, `ID_TIPO_MERCADERIA` = :ID_TIPO_MERCADERIA, `ID_POLIZA` = :ID_POLIZA, `A_FAVOR_DE` = :A_FAVOR_DE, `TIPO` = :TIPO, `ORIGEN` = :ORIGEN, `DESTINO` = :DESTINO,`VIA` = :VIA, `FECHA_EMBARQUE` = :FECHA_EMBARQUE,`TRANSPORTISTA` = :TRANSPORTISTA, `NAVE_VUELO_CAMION` = :NAVE_VUELO_CAMION,`BL_AWB_CRT` = :BL_AWB_CRT,`REFERENCIA_DESPACHO` = :REFERENCIA_DESPACHO,`ID_MATERIA_ASEGURADA` = :ID_MATERIA_ASEGURADA,`DETALLE_MERCADERIA` = :DETALLE_MERCADERIA,`ID_EMBALAJE` = :ID_EMBALAJE,`MONTO_ASEGURADO_CIF` = :MONTO_ASEGURADO_CIF,`TASA` = :TASA, `PRIMA_MIN` = :PRIMA_MIN, `PRIMA_SEGURO` = :PRIMA_SEGURO, `OBSERVACIONES` = :OBSERVACIONES WHERE ID_CERTIFICADO_SOLICITUD=:ID_CERTIFICADO_SOLICITUD");

        if ($sql->execute(array('ID_ASEGURADO' => $idAsegurado, 'ID_TIPO_MERCADERIA' => $idTipoMercaderia, 'ID_POLIZA' => $idPoliza, 'A_FAVOR_DE' => $aFavorDe, 'TIPO' => $tipo, 'ORIGEN' => $origen, 'DESTINO' => $destino, 'VIA' => $via, 'FECHA_EMBARQUE' => $fechaEmbarque, 'TRANSPORTISTA' => $transportista, 'NAVE_VUELO_CAMION' => $naveVueloAvion, 'BL_AWB_CRT' => $blAwbCrt, 'REFERENCIA_DESPACHO' => $referenciaDespacho, 'ID_MATERIA_ASEGURADA' => $idMateriaAsegurada, 'DETALLE_MERCADERIA' => $detalleMercaderia, 'ID_EMBALAJE' => $idEmbalaje, 'MONTO_ASEGURADO_CIF' => $montoAseguradoCIF, 'TASA' => $tasa, 'PRIMA_MIN' => $primaMin, 'PRIMA_SEGURO' => $primaSeguro, 'OBSERVACIONES' => $observaciones, 'ID_CERTIFICADO_SOLICITUD' => $idCertificadoSolicitud))) {
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

    public function deleteCertificateRequest($idCertificadoSolicitud){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE certificado_solicitud set HABILITADO =:HABILITADO WHERE ID_CERTIFICADO_SOLICITUD=:ID_CERTIFICADO_SOLICITUD");

        if ($sql->execute(array('HABILITADO' => 0, 'ID_CERTIFICADO_SOLICITUD' => $idCertificadoSolicitud ))) {
            $status  = "success";
            $message = "La solicitud de certificado ha sido eliminada.";
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