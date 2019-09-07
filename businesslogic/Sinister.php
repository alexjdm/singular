<?php

require_once 'connections/db.php';
include_once("models/DAO/Siniestro_DAO.php");
include_once("helpers/CommonHelper.php");
include_once("businesslogic/Company.php");
include_once("businesslogic/Sinister.php");
include_once("businesslogic/Policy.php");
include_once("businesslogic/Insured.php");
include_once("businesslogic/Certificate.php");

class Sinister
{

    public function getNumberRequest()
    {
        $model = new Siniestro_DAO();

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $siniestros = $model -> getSinistersByState(0); // 0: No Ingresado a la compañia
        }
        else
        {
            $currentUser = getCurrentUser();
            $usuarioBusiness = new Usuario();
            if($currentUser['idPerfil'] == 3) // Es administrador
            {
                $idCorredora = $currentUser['idCorredora'];
                $usuarios = $usuarioBusiness->getUsers($idCorredora);
            }
            else
            {
                $usuarios = $usuarioBusiness->getUser($currentUser['idUsuario']);
            }

            $siniestros = $model->getSinistersByUsersByState($usuarios, 0);
        }

        return count($siniestros);
    }

    public function getSinistersList()
    {
        $model = new Siniestro_DAO();

        $siniestros = $model->getSinistersList();

        return $siniestros;
    }

    public function getSinistersByDates($fechaInicio, $fechaFin)
    {
        $model = new Siniestro_DAO();

        $siniestros = $model->getSinistersByDates($fechaInicio, $fechaFin);

        return $siniestros;
    }

    public function getSinisters($idCorredora)
    {
        $model = new Siniestro_DAO();

        $siniestros = $model->getSinisters($idCorredora);

        return $siniestros;
    }

    public function getSinister($idSiniestro)
    {
        $model = new Siniestro_DAO();
        return $model->getSinister($idSiniestro);
    }

    public function editSinister($idSiniestro, $idCertificado, $motivo, $nombre, $telefono, $correo, $numero)
    {
        $model = new Siniestro_DAO();
        $model->editSinister($idSiniestro, $idCertificado, $motivo, $nombre, $telefono, $correo, $numero);
    }

    public function editSinisterFromStadistic($idSiniestro, $siniestro, $montoProvision, $indemnizacion)
    {
        $model = new Siniestro_DAO();
        $model->editSinisterFromStadistic($idSiniestro, $siniestro, $montoProvision, $indemnizacion);
    }


    public function getSinisterStadistic($fechaInicio, $fechaFin)
    {
        $usuarioBusiness = new Usuario();
        $insuranceBrokerBusiness = new InsuranceBroker();
        $polizaBusiness = new Policy();
        $aseguradoBusiness = new Insured();
        $certificadoBusiness = new Certificate();

        $polizas = $polizaBusiness->getAllPolicies();
        $asegurados = $aseguradoBusiness->getInsuredList();
        $certificados = $certificadoBusiness->getCertificatesList();

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $siniestros = $this->getSinistersByDates($fechaInicio, $fechaFin);
        }
        else
        {
            $currentUser = getCurrentUser();
            $idCorredora = $currentUser['idCorredora'];
            $siniestros = $this->getSinisters($idCorredora);
        }

        $montoAsegurado = 0;
        $primaSeguro = 0;
        $montoProvision = 0;
        $indemnizacion = 0;
        $siniestrosVM = Array();
        foreach ($siniestros as $siniestro)
        {
            $siniestroVM = Array();
            $siniestroVM['ID_SINIESTRO'] = $siniestro['ID_SINIESTRO'];
            $siniestroVM['FECHA_SOLICITUD'] = $siniestro['FECHA_SOLICITUD'];
            $certificado = getCertificado($certificados, $siniestro['ID_CERTIFICADO']);
            if(isset($certificado))
            {
                $idCertificado = $certificado['ID_CERTIFICADO'];
                $idAsegurado = $certificado['ID_ASEGURADO'];

                $cliente = getCliente($certificado['ID_USUARIO_SOLICITANTE']);
                if(isset($cliente))
                {
                    $siniestroVM['CLIENTE'] = $cliente['NOMBRE'];
                }

                $asegurado = getAsegurado($asegurados, $idAsegurado);
                if(isset($asegurado))
                {
                    $siniestroVM['ASEGURADO'] = $asegurado['NOMBRE'];
                }

                $siniestroVM['FECHA_SOLICITUD'] = $certificado['FECHA_SOLICITUD'];
                $siniestroVM['MONTO_ASEGURADO'] = $certificado['MONTO_ASEGURADO_CIF'];
                $siniestroVM['PRIMA'] = $certificado['PRIMA_MIN'];
                $poliza = getPoliza($polizas, $certificado['ID_POLIZA']);

                if(isset($poliza))
                {
                    $siniestroVM['POLIZA'] = utf8_encode($poliza['TIPO_POLIZA'] . " (" . $poliza['NUMERO'] . ")");
                }

                $siniestroVM['NUMERO_CERTIFICADO'] = $certificado['NUMERO'];

                $idUsuarioSolicitante = $certificado['ID_USUARIO_SOLICITANTE'];
                //$usuarioSolicitante = $usuarioBusiness->getUser($idUsuarioSolicitante);
                $corredora = $insuranceBrokerBusiness->getInsuranceBrokerByIdUser($idUsuarioSolicitante);
                $idUsuarioVendedor = $corredora['ID_USUARIO_VENDEDOR'];
                $usuarioVendedor = $usuarioBusiness->getUser($idUsuarioVendedor);

                $siniestroVM['EJECUTIVO'] = $usuarioVendedor['NOMBRE'] . " " . $usuarioVendedor['APELLIDO'];

                $montoAsegurado = $montoAsegurado + $certificado['MONTO_ASEGURADO_CIF'];
                $primaSeguro = $primaSeguro + $certificado['PRIMA_MIN'];

            }
            else
                continue;

            $siniestroVM['MES'] = getMes($siniestro['FECHA_SOLICITUD']);
            $siniestroVM['SINIESTRO'] = $siniestro['SINIESTRO'];
            $siniestroVM['MOTIVO'] = $siniestro['MOTIVO'];
            $siniestroVM['MONTO_PROVISION'] = $siniestro['MONTO_PROVISION'];
            $siniestroVM['FECHA_DENUNCIA'] = $siniestro['FECHA_SOLICITUD'];
            $siniestroVM['INDEMNIZACION'] = $siniestro['INDEMNIZACION'];

            $montoProvision = $montoProvision + $siniestroVM['MONTO_PROVISION'];
            $indemnizacion = $indemnizacion + $siniestroVM['INDEMNIZACION'];

            array_push($siniestrosVM, $siniestroVM);
        }

        $numeroCertificados = count($siniestros);

        $salida = array($siniestrosVM, $numeroCertificados, $montoAsegurado, $primaSeguro, $montoProvision, $indemnizacion);

        return $salida;
    }

    public function newSinister($idCertificado, $motivo, $nombre, $telefono, $correo)
    {
        $model = new Siniestro_DAO();
        $model->newSinister($idCertificado, $motivo, $nombre, $telefono, $correo);
    }

    public function sendEmail($currentUser, $motivo, $nombre, $telefono, $correo)
    {
        try
        {
            $send_to = 'equevedo@singularseguros.cl';
            $subject = 'Certificado listo';

            $headers = 'From: Singular <' . $send_to . '>' . "\r\n";
            $headers .= 'Reply-To: ' . $send_to . "\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $message = file_get_contents('templates/denuncia-siniestro.html');
            $message = str_replace('%username%', $currentUser['nombre'] .' ' . $currentUser['apellido'], $message);
            $message = str_replace('%motivo%', $motivo, $message);
            $message = str_replace('%nombre%', $nombre, $message);
            $message = str_replace('%telefono%', $telefono, $message);
            $message = str_replace('%correo%', $correo, $message);

            mail($send_to, $subject, $message, $headers);
        }
        catch (Exception $e)
        {

        }
    }

    public function deleteSinister($idSiniestro)
    {
        $model = new Siniestro_DAO();
        $model->deleteSinister($idSiniestro);
    }

    public function getSinistersReport()
    {
        $polizaBusiness = new Policy();
        $aseguradoBusiness = new Insured();
        $certificadoBusiness = new Certificate();

        $polizas = $polizaBusiness->getAllPolicies();
        $asegurados = $aseguradoBusiness->getInsuredList();
        $certificados = $certificadoBusiness->getCertificatesList();

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $siniestros = $this->getSinistersList();
        }
        else
        {
            $currentUser = getCurrentUser();
            $usuarioBusiness = new Usuario();
            if($currentUser['idPerfil'] == 3) // Es administrador
            {
                $idCorredora = $currentUser['idCorredora'];
                $usuarios = $usuarioBusiness->getUsers($idCorredora);
            }
            else
            {
                $usuarios = $usuarioBusiness->getUser($currentUser['idUsuario']);
            }

            $siniestros = $this->getSinistersByUsers($usuarios);
        }

        $siniestrosVM = $this -> ToSiniestroVM($siniestros, $certificados, $polizas, $asegurados);

        return $siniestrosVM;
    }

    public function getSinistersByUsers($usuarios)
    {
        $model = new Siniestro_DAO();

        $siniestros = $model->getSinistersByUsers($usuarios);

        return $siniestros;
    }

    public function getSinisterVM($idSiniestro)
    {
        $polizaBusiness = new Policy();
        $aseguradoBusiness = new Insured();
        $certificadoBusiness = new Certificate();

        $model = new Siniestro_DAO();
        $siniestro = $model->getSinister($idSiniestro);

        $siniestroVM = Array();
        $siniestroVM['ID_SINIESTRO'] = $siniestro['ID_SINIESTRO'];

        $certificado = $certificadoBusiness->getCertificate($siniestro['ID_CERTIFICADO']);
        if(isset($certificado)) {
            $idCertificado = $certificado['ID_CERTIFICADO'];
            $idAsegurado = $certificado['ID_ASEGURADO'];

            $poliza = $polizaBusiness->getPolicy($certificado['ID_POLIZA']);

            if (isset($poliza)) {
                $siniestroVM['POLIZA'] = utf8_encode($poliza['TIPO_POLIZA'] . " (" . $poliza['NUMERO'] . ")");
            }

            $siniestroVM['NUMERO_CERTIFICADO'] = $certificado['NUMERO'];

            $cliente = getCliente($certificado['ID_USUARIO_SOLICITANTE']);
            if (isset($cliente)) {
                $siniestroVM['CLIENTE'] = $cliente['NOMBRE'];
            }

            $asegurado = $aseguradoBusiness->getInsured($idAsegurado);
            if (isset($asegurado)) {
                $siniestroVM['ASEGURADO'] = $asegurado['NOMBRE'];
            }

            $siniestroVM['MOTIVO'] = $siniestro['MOTIVO'];
            $siniestroVM['NOMBRE'] = $siniestro['NOMBRE'];
            $siniestroVM['TELEFONO'] = $siniestro['TELEFONO'];
            $siniestroVM['CORREO'] = $siniestro['CORREO'];
            $siniestroVM['UBICACION'] = $siniestro['UBICACION'];

            if($siniestro['ESTADO'] == 0)
            {
                $siniestroVM['ESTADO'] = "Pendiente";
            }
            else if($siniestro['ESTADO'] == 1)
            {
                $siniestroVM['ESTADO'] = "Listo";
            }
            else
            {
                $siniestroVM['ESTADO'] = "--";
            }

        }

        return $siniestroVM;
    }

    public function addSinisterDoc($idSiniestro, $ubicacion)
    {
        $model = new Siniestro_DAO();
        $model->addSinisterDoc($idSiniestro, $ubicacion);
    }



    public function ToSiniestroVM($siniestros, $certificados, $polizas, $asegurados)
    {
        $siniestrosVM = Array();
        foreach ($siniestros as $siniestro) {
            $siniestroVM = Array();
            $siniestroVM['ID_SINIESTRO'] = $siniestro['ID_SINIESTRO'];

            $certificado = getCertificado($certificados, $siniestro['ID_CERTIFICADO']);
            if(isset($certificado)) {
                $idCertificado = $certificado['ID_CERTIFICADO'];
                $idAsegurado = $certificado['ID_ASEGURADO'];

                $poliza = getPoliza($polizas, $certificado['ID_POLIZA']);

                if (isset($poliza)) {
                    $siniestroVM['POLIZA'] = utf8_encode($poliza['TIPO_POLIZA'] . " (" . $poliza['NUMERO'] . ")");
                }

                $siniestroVM['NUMERO_CERTIFICADO'] = $certificado['NUMERO'];

                $cliente = getCliente($certificado['ID_USUARIO_SOLICITANTE']);
                if (isset($cliente)) {
                    $siniestroVM['CLIENTE'] = $cliente['NOMBRE'];
                }

                $asegurado = getAsegurado($asegurados, $idAsegurado);
                if (isset($asegurado)) {
                    $siniestroVM['ASEGURADO'] = $asegurado['NOMBRE'];
                }

                $siniestroVM['MOTIVO'] = $siniestro['MOTIVO'];
                $siniestroVM['NOMBRE'] = $siniestro['NOMBRE'];
                $siniestroVM['TELEFONO'] = $siniestro['TELEFONO'];
                $siniestroVM['CORREO'] = $siniestro['CORREO'];
                $siniestroVM['UBICACION'] = $siniestro['UBICACION'];

                if($siniestro['ESTADO'] == 0)
                {
                    $siniestroVM['ESTADO'] = "Pendiente";
                }
                else if($siniestro['ESTADO'] == 1)
                {
                    $siniestroVM['ESTADO'] = "Listo";
                }
                else
                {
                    $siniestroVM['ESTADO'] = "--";
                }

                array_push($siniestrosVM, $siniestroVM);
            }
        }

        return $siniestrosVM;
    }


}