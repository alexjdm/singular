<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Certificado_DAO {

    public function getCertificatesList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado WHERE ESTADO_SOLICITUD = 1 AND ESTADO_ANULACION != 1 AND HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getCertificatesWithIdPolicy(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado I ON certificado.ID_CERTIFICADO=certificado.ID_CERTIFICADO AND certificado.HABILITADO='1'");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getCertificates($usuarios){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $certificadosFinal = array();
        foreach ($usuarios as $usuario)
        {
            $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_USUARIO_SOLICITANTE = :ID_USUARIO_SOLICITANTE AND ESTADO_SOLICITUD = 1 AND HABILITADO=1");
            $sql->execute(array('ID_USUARIO_SOLICITANTE' => $usuario['ID_USUARIO']));

            $certificadoSolicitudes = $sql->fetchAll();
            if($certificadoSolicitudes != null)
            {
                foreach ($certificadoSolicitudes as $certificadoSolicitud)
                {
                    $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_CERTIFICADO = :ID_CERTIFICADO  AND ESTADO_ANULACION != 1  AND HABILITADO=1");
                    $sql->execute(array('ID_CERTIFICADO' => $certificadoSolicitud['ID_CERTIFICADO']));

                    $certificados = $sql->fetchAll();
                    if($certificados != null)
                    {
                        foreach ($certificados as $certificado)
                        {
                            array_push($certificadosFinal, $certificado);
                        }
                    }
                }
            }
        }

        return $certificadosFinal;
    }

    public function addCertificate($idCertificadoSolicitud, $numero, $formato, $ubicacion){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado WHERE NUMERO =:NUMERO");
        $sql->execute(array('NUMERO' => $numero));
        $resultado = $sql->fetch();

        if ($resultado == null) {

            date_default_timezone_set('America/Santiago');
            $fecha = date("Y-m-d H:i:s");

            $sql = $pdo->prepare("UPDATE certificado set NUMERO =:NUMERO, FORMATO =:FORMATO, UBICACION =:UBICACION, FECHA_INGRESO =:FECHA_INGRESO, ESTADO_SOLICITUD =:ESTADO_SOLICITUD WHERE ID_CERTIFICADO=:ID_CERTIFICADO");

            if($sql->execute(array('NUMERO' => $numero, 'FORMATO' => $formato, 'UBICACION' => $ubicacion, 'FECHA_INGRESO' => $fecha, 'ESTADO_SOLICITUD' => 1, 'ID_CERTIFICADO' => $idCertificadoSolicitud))) {
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
            $message = "Este certificado ya se encuentra registrado.";
        }
        
        $data = array(
            'status'  => $status,
            'message' => $message
        );

        echo json_encode($data);

        Database::disconnect();
    }

    public function changeCertificate($idCertificadoSolicitud, $numero, $formato, $ubicacion){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        date_default_timezone_set('America/Santiago');
        $fecha = date("Y-m-d H:i:s");

        $sql = $pdo->prepare("UPDATE certificado set NUMERO =:NUMERO, FORMATO =:FORMATO, UBICACION =:UBICACION, FECHA_INGRESO =:FECHA_INGRESO, ESTADO_SOLICITUD =:ESTADO_SOLICITUD WHERE ID_CERTIFICADO=:ID_CERTIFICADO");

        if($sql->execute(array('NUMERO' => $numero, 'FORMATO' => $formato, 'UBICACION' => $ubicacion, 'FECHA_INGRESO' => $fecha, 'ESTADO_SOLICITUD' => 1, 'ID_CERTIFICADO' => $idCertificadoSolicitud))) {
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

    public function getCertificate($idCertificado){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_CERTIFICADO=:ID_CERTIFICADO AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_CERTIFICADO' => $idCertificado, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function getLastNumber (){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT NUMERO FROM certificado ORDER BY NUMERO DESC");
        $sql->execute();

        $resultado = $sql->fetchAll()[0]['NUMERO'];
        $pdo = Database::disconnect();

        return $resultado;
    }

    public function editCertificate($idCertificado, $numero){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE certificado set NUMERO =:NUMERO WHERE ID_CERTIFICADO=:ID_CERTIFICADO");

        if ($sql->execute(array('NUMERO' => $numero, 'ID_CERTIFICADO' => $idCertificado ))) {
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

    public function deleteCertificate($idCertificado){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE certificado set HABILITADO =:HABILITADO WHERE ID_CERTIFICADO=:ID_CERTIFICADO");

        if ($sql->execute(array('HABILITADO' => false, 'ID_CERTIFICADO' => $idCertificado ))) {
            $status  = "success";
            $message = "El certificado ha sido eliminado";
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


    public function getCertificateRequestsList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado WHERE ESTADO_SOLICITUD = 0 AND HABILITADO='1'");
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
            $ids = '';
            $arrayIds = array();
            foreach ($idUsuarios as $idUsuario) {
                array_push($arrayIds, $idUsuario['ID_USUARIO']);
            }
            $ids = join("','",$arrayIds);

            $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_USUARIO_SOLICITANTE IN ('$ids') AND ESTADO_SOLICITUD = 0 AND HABILITADO = 1 ORDER BY ESTADO_SOLICITUD ASC");
            $sql->execute(array());
            $certificadoSolicitudes = $sql->fetchAll();
        }

        return $certificadoSolicitudes;
    }

    public function getCertificateRequestsByInsuredBrokerAndState($idCorredora, $state){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT ID_USUARIO FROM corredora_usuario WHERE ID_CORREDORA = :ID_CORREDORA");
        $sql->execute(array('ID_CORREDORA' => $idCorredora));
        $idUsuarios = $sql->fetchAll();

        $certificadoSolicitudes = array();
        if($idUsuarios != null)
        {
            $ids = '';
            $arrayIds = array();
            foreach ($idUsuarios as $idUsuario) {
                array_push($arrayIds, $idUsuario['ID_USUARIO']);
            }
            $ids = join("','",$arrayIds);

            $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_USUARIO_SOLICITANTE IN ('$ids') AND ESTADO_SOLICITUD =:ESTADO_SOLICITUD AND HABILITADO = 1 ORDER BY ESTADO_SOLICITUD ASC");
            $sql->execute(array('ESTADO_SOLICITUD' => $state));
            $certificadoSolicitudes = $sql->fetchAll();
        }

        return $certificadoSolicitudes;
    }

    public function getCertificateAnnulmentsByInsuredBrokerAndState($idCorredora, $state){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT ID_USUARIO FROM corredora_usuario WHERE ID_CORREDORA = :ID_CORREDORA");
        $sql->execute(array('ID_CORREDORA' => $idCorredora));
        $idUsuarios = $sql->fetchAll();

        $certificadoAnulaciones = array();
        if($idUsuarios != null)
        {
            $ids = '';
            $arrayIds = array();
            foreach ($idUsuarios as $idUsuario) {
                array_push($arrayIds, $idUsuario['ID_USUARIO']);
            }
            $ids = join("','",$arrayIds);

            $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_USUARIO_SOLICITANTE IN ('$ids') AND ESTADO_ANULACION =:ESTADO_ANULACION AND HABILITADO = 1 ORDER BY ESTADO_SOLICITUD ASC");
            $sql->execute(array('ESTADO_ANULACION' => $state));
            $certificadoAnulaciones = $sql->fetchAll();
        }

        return $certificadoAnulaciones;
    }

    public function getCertificateRequestsByState($state){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado WHERE ESTADO_SOLICITUD =:ESTADO_SOLICITUD AND HABILITADO = 1 ORDER BY ESTADO_SOLICITUD ASC");
        $sql->execute(array('ESTADO_SOLICITUD' => $state));
        $solicitudesCertificados = $sql->fetchAll();

        $certificadoSolicitudes = array();
        if($solicitudesCertificados != null)
        {
            foreach ($solicitudesCertificados as $solicitudCertificado)
            {
                array_push($certificadoSolicitudes, $solicitudCertificado);
            }
        }

        return $certificadoSolicitudes;
    }

    public function getCertificateAnnulmentsByState($state){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado WHERE ESTADO_ANULACION =:ESTADO_ANULACION AND HABILITADO = 1 ORDER BY ESTADO_ANULACION ASC");
        $sql->execute(array('ESTADO_ANULACION' => $state));
        $anulacionesCertificados = $sql->fetchAll();

        $certificadoAnulaciones = array();
        if($anulacionesCertificados != null)
        {
            foreach ($anulacionesCertificados as $anulacionCertificado)
            {
                array_push($certificadoAnulaciones, $anulacionCertificado);
            }
        }

        return $certificadoAnulaciones;
    }

    public function newCertificateRequest($idUsuarioSolicitante, $idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo, $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloAvion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada, $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones, $estado){

        date_default_timezone_set('America/Santiago');
        $fechaSolicitud = date("Y-m-d H:i:s");

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("INSERT INTO `certificado`(`ID_USUARIO_SOLICITANTE`, `ID_ASEGURADO`, `ID_TIPO_MERCADERIA`, `ID_POLIZA`, `A_FAVOR_DE`, `TIPO`, `ORIGEN`, `DESTINO`, `VIA`, `FECHA_EMBARQUE`, `TRANSPORTISTA`, `NAVE_VUELO_CAMION`, `BL_AWB_CRT`, `REFERENCIA_DESPACHO`, `ID_MATERIA_ASEGURADA`, `DETALLE_MERCADERIA`, `ID_EMBALAJE`, `MONTO_ASEGURADO_CIF`, `TASA`, `PRIMA_MIN`, `PRIMA_SEGURO`, `OBSERVACIONES`, `ESTADO_SOLICITUD`, `FECHA_SOLICITUD`, `ESTADO_ANULACION`, `HABILITADO`) VALUES (:ID_USUARIO_SOLICITANTE, :ID_ASEGURADO, :ID_TIPO_MERCADERIA, :ID_POLIZA, :A_FAVOR_DE, :TIPO,  :ORIGEN, :DESTINO, :VIA, :FECHA_EMBARQUE, :TRANSPORTISTA, :NAVE_VUELO_CAMION, :BL_AWB_CRT, :REFERENCIA_DESPACHO, :ID_MATERIA_ASEGURADA, :DETALLE_MERCADERIA, :ID_EMBALAJE, :MONTO_ASEGURADO_CIF, :TASA, :PRIMA_MIN, :PRIMA_SEGURO, :OBSERVACIONES, :ESTADO_SOLICITUD, :FECHA_SOLICITUD, -1, 1)");
        $sql->execute(array('ID_USUARIO_SOLICITANTE' => $idUsuarioSolicitante, 'ID_ASEGURADO' => $idAsegurado, 'ID_TIPO_MERCADERIA' => $idTipoMercaderia, 'ID_POLIZA' => $idPoliza, 'A_FAVOR_DE' => $aFavorDe, 'TIPO' => $tipo, 'ORIGEN' => $origen, 'DESTINO' => $destino, 'VIA' => $via, 'FECHA_EMBARQUE' => $fechaEmbarque, 'TRANSPORTISTA' => $transportista, 'NAVE_VUELO_CAMION' => $naveVueloAvion, 'BL_AWB_CRT' => $blAwbCrt, 'REFERENCIA_DESPACHO' => $referenciaDespacho, 'ID_MATERIA_ASEGURADA' => $idMateriaAsegurada, 'DETALLE_MERCADERIA' => $detalleMercaderia, 'ID_EMBALAJE' => $idEmbalaje, 'MONTO_ASEGURADO_CIF' => $montoAseguradoCIF, 'TASA' => $tasa, 'PRIMA_MIN' => $primaMin, 'PRIMA_SEGURO' => $primaSeguro, 'OBSERVACIONES' => $observaciones, 'ESTADO_SOLICITUD' => $estado, 'FECHA_SOLICITUD' => $fechaSolicitud));
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

        $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_CERTIFICADO=:ID_CERTIFICADO AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_CERTIFICADO' => $idCertificadoSolicitud, 'HABILITADO' => 1));

        return $sql->fetchAll()[0];
    }

    public function editCertificateRequest($idCertificadoSolicitud, $idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo, $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloAvion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada, $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE certificado set ID_ASEGURADO =:ID_ASEGURADO, `ID_TIPO_MERCADERIA` = :ID_TIPO_MERCADERIA, `ID_POLIZA` = :ID_POLIZA, `A_FAVOR_DE` = :A_FAVOR_DE, `TIPO` = :TIPO, `ORIGEN` = :ORIGEN, `DESTINO` = :DESTINO,`VIA` = :VIA, `FECHA_EMBARQUE` = :FECHA_EMBARQUE,`TRANSPORTISTA` = :TRANSPORTISTA, `NAVE_VUELO_CAMION` = :NAVE_VUELO_CAMION,`BL_AWB_CRT` = :BL_AWB_CRT,`REFERENCIA_DESPACHO` = :REFERENCIA_DESPACHO,`ID_MATERIA_ASEGURADA` = :ID_MATERIA_ASEGURADA,`DETALLE_MERCADERIA` = :DETALLE_MERCADERIA,`ID_EMBALAJE` = :ID_EMBALAJE,`MONTO_ASEGURADO_CIF` = :MONTO_ASEGURADO_CIF,`TASA` = :TASA, `PRIMA_MIN` = :PRIMA_MIN, `PRIMA_SEGURO` = :PRIMA_SEGURO, `OBSERVACIONES` = :OBSERVACIONES WHERE ID_CERTIFICADO=:ID_CERTIFICADO");

        if ($sql->execute(array('ID_ASEGURADO' => $idAsegurado, 'ID_TIPO_MERCADERIA' => $idTipoMercaderia, 'ID_POLIZA' => $idPoliza, 'A_FAVOR_DE' => $aFavorDe, 'TIPO' => $tipo, 'ORIGEN' => $origen, 'DESTINO' => $destino, 'VIA' => $via, 'FECHA_EMBARQUE' => $fechaEmbarque, 'TRANSPORTISTA' => $transportista, 'NAVE_VUELO_CAMION' => $naveVueloAvion, 'BL_AWB_CRT' => $blAwbCrt, 'REFERENCIA_DESPACHO' => $referenciaDespacho, 'ID_MATERIA_ASEGURADA' => $idMateriaAsegurada, 'DETALLE_MERCADERIA' => $detalleMercaderia, 'ID_EMBALAJE' => $idEmbalaje, 'MONTO_ASEGURADO_CIF' => $montoAseguradoCIF, 'TASA' => $tasa, 'PRIMA_MIN' => $primaMin, 'PRIMA_SEGURO' => $primaSeguro, 'OBSERVACIONES' => $observaciones, 'ID_CERTIFICADO' => $idCertificadoSolicitud))) {
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

    /*public function changeState($idCertificadoSolicitud, $estado){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE certificado set ESTADO_SOLICITUD =:ESTADO_SOLICITUD WHERE ID_CERTIFICADO=:ID_CERTIFICADO");

        if ($sql->execute(array('ESTADO_SOLICITUD' => $estado, 'ID_CERTIFICADO' => $idCertificadoSolicitud))) {
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

        //echo json_encode($data);

        Database::disconnect();
    }*/

    public function getCertificateAnnulmentsList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado WHERE ESTADO_ANULACION = 0 AND HABILITADO='1'");
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


            $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_USUARIO_SOLICITANTE in ('$ids') AND ESTADO_ANULACION ='0' AND HABILITADO = 1");
            $sql->execute(array());
            $certificadosAnulacion = $sql->fetchAll();
        }

        return $certificadosAnulacion;
    }

    public function newCertificateAnnulment($idCertificado, $motivo){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_CERTIFICADO = :ID_CERTIFICADO AND ESTADO_ANULACION >= 0");
        $sql->execute(array('ID_CERTIFICADO' => $idCertificado));
        $anulacion = $sql->fetchAll();

        if($anulacion == null)
        {
            date_default_timezone_set('America/Santiago');
            $fechaSolicitudAnulacion = date("Y-m-d H:i:s");

            $sql = $pdo->prepare("UPDATE `certificado` set `MOTIVO` = :MOTIVO, `ESTADO_ANULACION` = 0, `FECHA_SOLICITUD_ANULACION` = :FECHA_SOLICITUD_ANULACION WHERE ID_CERTIFICADO = :ID_CERTIFICADO");

            if($sql->execute(array('MOTIVO' => $motivo, 'FECHA_SOLICITUD_ANULACION' => $fechaSolicitudAnulacion, 'ID_CERTIFICADO' => $idCertificado))) {
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

        $sql = $pdo->prepare("SELECT * FROM certificado WHERE ID_CERTIFICADO=:ID_CERTIFICADO AND HABILITADO=:HABILITADO");
        $sql->execute(array('ID_CERTIFICADO' => $idCertificadoAnulacion, 'HABILITADO' => 1));

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

    public function setCertificateAnnulment($idCertificadoAnulacion, $estado){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        date_default_timezone_set('America/Santiago');
        $fecha = date("Y-m-d H:i:s");

        $sql = $pdo->prepare("UPDATE certificado set ESTADO_ANULACION = :ESTADO_ANULACION, FECHA_ANULACION = :FECHA_ANULACION WHERE ID_CERTIFICADO=:ID_CERTIFICADO");

        if($sql->execute(array('ESTADO_ANULACION' => $estado, 'FECHA_ANULACION' => $fecha, 'ID_CERTIFICADO' => $idCertificadoAnulacion))) {
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

    public function addReplaceCertificateNumber2db($idCertificadoAnulacion, $idCertificado){

        if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("UPDATE certificado set ID_CERTIFICADO_REEMPLAZO= :ID_CERTIFICADO_REEMPLAZO WHERE ID_CERTIFICADO=:ID_CERTIFICADO");

        if($sql->execute(array('ID_CERTIFICADO_REEMPLAZO' => $idCertificado, 'ID_CERTIFICADO' => $idCertificadoAnulacion))) {
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

}