<?php

include_once("models/DAO/Usuario_DAO.php");
include_once("models/DAO/Asegurado_DAO.php");
include_once("models/DAO/TipoMercaderia_DAO.php");
include_once("models/DAO/Poliza_DAO.php");

class Notification
{

    public function NotificarCertificadoSolicitud($currentUser, $idAsegurado, $idTipoMercaderia, $idPoliza)
    {
        $modelU = new Usuario_DAO();
        $modelA = new Asegurado_DAO();
        $modelTM = new TipoMercaderia_DAO();
        $modelP = new Poliza_DAO();

        $asegurado = $modelA->getInsured($idAsegurado);
        $tipoMercaderia = $modelTM->getMerchandiseType($idTipoMercaderia);
        $poliza = $modelP->getPolicy($idPoliza);

        $usuariosSuperAdmin = $modelU->getSuperAdminsList();
        foreach ($usuariosSuperAdmin as $usuarioSuperAdmin)
        {
            $send_to = $usuarioSuperAdmin['CORREO_ELECTRONICO'];
            $subject = 'Solicitud de Certificado';

            //$correo = $usuarioSuperAdmin['CORREO_ELECTRONICO'];

            try
            {
                $headers = 'From: Singular' . '<' . $send_to . '>' . "\r\n";
                $headers .= 'Reply-To: ' . $currentUser['correo'] . "\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                $message = file_get_contents('templates/certificado-solicitud.html');
                $message = str_replace('%user%', $currentUser['nombre'] . ' ' . $currentUser['apellido'] , $message);
                $message = str_replace('%insuredId%', $asegurado['IDENTIFICADOR'], $message);
                $message = str_replace('%insured%', $asegurado['NOMBRE'], $message);
                $message = str_replace('%policy%', $poliza['TIPO_POLIZA'], $message);
                $message = str_replace('%merchandiseType%', $tipoMercaderia['TIPO_MERCADERIA'], $message);

                mail($send_to, $subject, $message, $headers);
            }
            catch (Exception $e) {}
        }

    }

    public function NotificarAsegurado($currentUser, $nombre, $giro, $idRegion, $idComuna, $direccion)
    {
        $modelU = new Usuario_DAO();
        $modelR = new Region_DAO();
        $modelC = new Comuna_DAO();

        $region = $modelR->getRegion($idRegion);
        $comuna = $modelC->getComuna($idComuna);

        $usuariosSuperAdmin = $modelU->getSuperAdminsList();
        foreach ($usuariosSuperAdmin as $usuarioSuperAdmin)
        {
            try
            {
                $send_to = $usuarioSuperAdmin['CORREO_ELECTRONICO'];
                $subject = 'Creación de Asegurado';

                //$correo = $usuarioSuperAdmin['CORREO_ELECTRONICO'];

                $headers = 'From: Singular' . '<' . $send_to . '>' . "\r\n";
                $headers .= 'Reply-To: ' . $currentUser['correo'] . "\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                $message = file_get_contents('templates/asegurado-creacion.html');
                $message = str_replace('%user%', $currentUser['nombre'] . ' ' . $currentUser['apellido'] , $message);
                $message = str_replace('%name%', $nombre, $message);
                $message = str_replace('%giro%', $giro, $message);
                $message = str_replace('%region%', $region['NOMBRE'], $message);
                $message = str_replace('%comuna%', $comuna['NOMBRE'], $message);
                $message = str_replace('%direccion%', $direccion, $message);

                mail($send_to, $subject, $message, $headers);
            }
            catch (Exception $e)
            {

            }
        }

    }

    public function NotificarCertificado($currentUser, $idCertificadoSolicitud)
    {
        $modelC = new Certificado_DAO();
        $modelU = new Usuario_DAO();

        $certificadoSolicitud = $modelC->getCertificateRequest($idCertificadoSolicitud);
        $usuarioSolicitante = $modelU->getUser($certificadoSolicitud['ID_USUARIO_SOLICITANTE']);

        if($usuarioSolicitante['ID_USUARIO'] != $currentUser['id'])
        {
            try
            {
                $send_to = $usuarioSolicitante['CORREO_ELECTRONICO'];
                $subject = 'Certificado listo';

                $headers = 'From: Singular <' . $currentUser['correo'] . '>' . "\r\n";
                $headers .= 'Reply-To: ' . $currentUser['correo'] . "\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                $message = file_get_contents('templates/certificado-cargado.html');
                $message = str_replace('%username%', $usuarioSolicitante['NOMBRE'] .' ' . $usuarioSolicitante['APELLIDO'], $message);
                $message = str_replace('%origen%', $certificadoSolicitud['ORIGEN'], $message);
                $message = str_replace('%destino%', $certificadoSolicitud['DESTINO'], $message);
                $message = str_replace('%fecha%', $certificadoSolicitud['FECHA_EMBARQUE'], $message);

                mail($send_to, $subject, $message, $headers);
            }
            catch (Exception $e)
            {

            }
        }

    }

}