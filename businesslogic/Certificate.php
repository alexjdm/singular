<?php

require_once 'connections/db.php';
include_once("models/DAO/Certificado_DAO.php");
include_once("models/DAO/CertificadoModificacion_DAO.php");
include_once("businesslogic/Usuario.php");
include_once("businesslogic/MerchandiseType.php");
include_once("businesslogic/Policy.php");
include_once("businesslogic/InsuredMatter.php");
include_once("businesslogic/Packing.php");
include_once("businesslogic/InsuranceBroker.php");

class Certificate
{

    public function getNumberRequest()
    {
        $model = new Certificado_DAO();
        $solicitudesPendientes = array();
        if (isSuperAdmin() == true) {
            $solicitudesPendientes = $model->getCertificateRequestsByState(0); // 0: Pendiente
        } else {
            $currentUser = getCurrentUser();
            $usuarioBusiness = new Usuario();
            if ($currentUser['idPerfil'] == 3) // Es administrador
            {
                $idCorredora = $currentUser['idCorredora'];
                $usuarios = $usuarioBusiness->getUsers($idCorredora);
            } else {
                $usuarios = $usuarioBusiness->getUser($currentUser['idUsuario']);
            }

            $solicitudesPendientes = $model->getCertificateRequestsByUsersAndState($usuarios, 0); // 0: Pendiente
        }

        return count($solicitudesPendientes);
    }

    public function getNumberAnnulments()
    {
        $model = new Certificado_DAO();
        $corredora = getCurrentInsuranceBroker();
        $anulacionesPendientes = array();
        if (isSuperAdmin() == true) {
            $anulacionesPendientes = $model->getCertificateAnnulmentsByState(0); // 0: Pendiente
        } else {
            $currentUser = getCurrentUser();
            $usuarioBusiness = new Usuario();
            if ($currentUser['idPerfil'] == 3) // Es administrador
            {
                $idCorredora = $currentUser['idCorredora'];
                $usuarios = $usuarioBusiness->getUsers($idCorredora);
            } else {
                $usuarios = $usuarioBusiness->getUser($currentUser['idUsuario']);
            }
            $anulacionesPendientes = $model->getCertificateAnnulmentsByUsersAndState($usuarios, 0); // 0: Pendiente
        }

        return count($anulacionesPendientes);
    }

    public function getNumberModifies()
    {
        $model = new CertificadoModificacion_DAO();
        $corredora = getCurrentInsuranceBroker();
        if (isSuperAdmin() == true) {
            $modificacionesPendientes = $model->getCertificateModifiesByState(0); // 0: Pendiente
        } else {
            $currentUser = getCurrentUser();
            $usuarioBusiness = new Usuario();
            if ($currentUser['idPerfil'] == 3) // Es administrador
            {
                $idCorredora = $currentUser['idCorredora'];
                $usuarios = $usuarioBusiness->getUsers($idCorredora);
            } else {
                $usuarios = $usuarioBusiness->getUser($currentUser['idUsuario']);
            }
            $modificacionesPendientes = $model->getCertificateModifiesByUsersAndState($usuarios, 0); // 0: Pendiente
        }

        return count($modificacionesPendientes);
    }

    public function getPolicyNumber($idCertificado)
    {
        $model = new Certificado_DAO();
        $certificado = $model->getCertificate($idCertificado);

        $polizaDAO = new Poliza_DAO();
        $poliza = $polizaDAO -> getPolicy($certificado['ID_POLIZA']);

        return $poliza['NUMERO'];
    }

    public function getAllCertificates()
    {
        $model = new Certificado_DAO();
        $certificados = $model->getCertificatesList();

        return $certificados;
    }

    public function getCertificatesList()
    {
        $model = new Certificado_DAO();
        $isSuperAdmin = isSuperAdmin();
        if ($isSuperAdmin) {
            $certificados = $model->getCertificatesList();
        } else {
            $currentUser = getCurrentUser();
            $usuarioBusiness = new Usuario();
            if ($currentUser['idPerfil'] == 3) // Es administrador
            {
                $idCorredora = $currentUser['idCorredora'];
                $usuarios = $usuarioBusiness->getUsers($idCorredora);
            } else {
                $usuarios = $usuarioBusiness->getUser($currentUser['idUsuario']);
            }

            $certificados = $model->getCertificatesByUsers($usuarios);
        }

        return $certificados;
    }

    public function getCertificatesByDates($fechaInicio, $fechaFin)
    {
        $model = new Certificado_DAO();
        $certificado = $model->getCertificatesByDates($fechaInicio, $fechaFin);

        return $certificado;
    }

    public function getCertificatesByUsers($usuarios)
    {
        $model = new Certificado_DAO();
        $certificado = $model->getCertificatesByUsers($usuarios);

        return $certificado;
    }

    public function getCertificate($idCertificado)
    {
        $model = new Certificado_DAO();
        $certificado = $model->getCertificate($idCertificado);

        return $certificado;
    }

    public function getClientTransportStadistic($fechaInicio, $fechaFin)
    {
        $precision = 2; //decimales
        $usuarioBusiness = new Usuario();
        $polizaBusiness = new Policy();
        $aseguradoBusiness = new Insured();
        $tipoMercaderiaBusiness = new MerchandiseType();
        $insuranceBrokerBusiness = new InsuranceBroker();

        $polizas = $polizaBusiness->getPoliciesList();
        $asegurados = $aseguradoBusiness->getAllInsured();
        $tipoMercaderias = $tipoMercaderiaBusiness->getMerchandiseTypesList();

        $isSuperAdmin = isSuperAdmin();
        if ($isSuperAdmin) {
            $certificados = $this->getCertificatesByDates($fechaInicio, $fechaFin);
        } else {
            $currentUser = getCurrentUser();
            $usuarioBusiness = new Usuario();
            if ($currentUser['idPerfil'] == 3) // Es administrador
            {
                $idCorredora = $currentUser['idCorredora'];
                $usuarios = $usuarioBusiness->getUsers($idCorredora);
            } else {
                $usuarios = $usuarioBusiness->getUser($currentUser['idUsuario']);
            }

            $certificados = $this->getCertificatesByUsers($usuarios);
        }

        $montoAsegurado = 0;
        $primaSeguro = 0;
        $primaCliente = 0;
        $difCliente = 0;
        $transportesVM = Array();
        foreach ($certificados as $certificado) {
            $transporteVM = Array();
            $transporteVM['ID_CERTIFICADO'] = $certificado['ID_CERTIFICADO'];

            $idAsegurado = $certificado['ID_ASEGURADO'];
            $asegurado = getAsegurado($asegurados, $idAsegurado);
            if (isset($asegurado)) {
                $transporteVM['ASEGURADO'] = $asegurado['NOMBRE'];
            }

            $transporteVM['MES'] = getMes($certificado['FECHA_SOLICITUD']);
            $transporteVM['FECHA_SOLICITUD'] = $certificado['FECHA_SOLICITUD'];
            $transporteVM['MONTO_ASEGURADO'] = round($certificado['MONTO_ASEGURADO_CIF'], $precision);
            $transporteVM['PRIMA_SEGURO'] = round($certificado['PRIMA_SEGURO'], $precision);

            $cliente = getCliente($certificado['ID_USUARIO_SOLICITANTE']);
            if (isset($cliente)) {
                if ($transporteVM['MONTO_ASEGURADO'] == 0) {
                    $transporteVM['PRIMA_CLIENTE'] = 0;
                } else {
                    $var1 = $transporteVM['MONTO_ASEGURADO'] * $cliente['TASA'];
                    $var2 = $cliente['PRIMA_MIN'];
                    $transporteVM['PRIMA_CLIENTE'] = round($var1 < $var2 ? $var2 : $var1 / 100, $precision);
                }

                $transporteVM['PROFIT_CLIENTE'] = round($transporteVM['PRIMA_SEGURO'] - $transporteVM['PRIMA_CLIENTE'], $precision);
            }

            $poliza = getPoliza($polizas, $certificado['ID_POLIZA']);
            if (isset($poliza)) {
                $transporteVM['MEDIO'] = utf8_encode($poliza['TIPO_POLIZA']);
                $transporteVM['POLIZA'] = $poliza['NUMERO'];
            }

            $transporteVM['NUMERO_CERTIFICADO'] = $certificado['NUMERO'];
            $transporteVM['TRANSBORDO'] = "Sin Info.";

            $tipoMercaderia = getTipoMercaderia($tipoMercaderias, $certificado['ID_TIPO_MERCADERIA']);
            if (isset($poliza)) {
                $transporteVM['TIPO_MERCADERIA'] = $tipoMercaderia['TIPO_MERCADERIA'];
            }

            $idUsuarioSolicitante = $certificado['ID_USUARIO_SOLICITANTE'];
            $corredora = $insuranceBrokerBusiness->getInsuranceBrokerByIdUser($idUsuarioSolicitante);
            $idUsuarioVendedor = $corredora['ID_USUARIO_VENDEDOR'];
            $usuarioVendedor = $usuarioBusiness->getUser($idUsuarioVendedor);

            $transporteVM['EJECUTIVO'] = $usuarioVendedor['NOMBRE'] . " " . $usuarioVendedor['APELLIDO'];
            $transporteVM['CERTIFICADO'] = "<a href='" . $certificado['UBICACION'] . "'>" . $certificado['FORMATO'] . "</a>";
            $transporteVM['FORMATO'] = $certificado['FORMATO'];
            $transporteVM['FACTURA'] = "Sin Info.";

            $montoAsegurado = $montoAsegurado + $certificado['MONTO_ASEGURADO_CIF'];
            $primaSeguro = $primaSeguro + $certificado['PRIMA_SEGURO'];
            $primaCliente = $primaCliente + $transporteVM['PRIMA_CLIENTE'];
            $difCliente = $difCliente + $transporteVM['PROFIT_CLIENTE'];

            array_push($transportesVM, $transporteVM);
        }

        $numeroCertificados = count($certificados);

        $salida = array($transportesVM, $numeroCertificados, round($montoAsegurado, $precision), round($primaSeguro, $precision), round($primaCliente, $precision), round($difCliente, $precision));

        return $salida;
    }

    function getSellerTransportStadistic($fechaInicio, $fechaFin)
    {
        $precision = 2;
        $usuarioBusiness = new Usuario();
        $polizaBusiness = new Policy();
        $aseguradoBusiness = new Insured();
        $certificadoBusiness = new Certificate();
        $tipoMercaderiaBusiness = new MerchandiseType();
        $companyBusiness = new Company();
        $insuranceBrokerBusiness = new InsuranceBroker();

        $polizas = $polizaBusiness->getPoliciesList();
        $asegurados = $aseguradoBusiness->getInsuredList();
        $tipoMercaderias = $tipoMercaderiaBusiness->getMerchandiseTypesList();
        $companias = $companyBusiness->getCompaniesList();

        $isSuperAdmin = isSuperAdmin();
        if ($isSuperAdmin) {
            $certificados = $certificadoBusiness->getCertificatesByDates($fechaInicio, $fechaFin);
        } else {
            $currentUser = getCurrentUser();
            $idCorredora = $currentUser['idCorredora'];
            $usuarios = $usuarioBusiness->getUsers($idCorredora);
            $certificados = $certificadoBusiness->getCertificates($usuarios);
        }

        $montoAsegurado = 0;
        $primaSeguro = 0;
        $primaCliente = 0;
        $primaCia = 0;
        $difCliente = 0;
        $comisionCorredor = 0;
        $difEqual = 0;
        $ingresoEqual = 0;
        $comisionVendedor = 0;

        $transportesVM = Array();
        foreach ($certificados as $certificado) {
            $transporteVM = Array();
            $transporteVM['ID_CERTIFICADO'] = $certificado['ID_CERTIFICADO'];

            $idAsegurado = $certificado['ID_ASEGURADO'];
            $asegurado = getAsegurado($asegurados, $idAsegurado);
            if (isset($asegurado)) {
                $transporteVM['ASEGURADO'] = $asegurado['NOMBRE'];
            }

            $transporteVM['MES'] = getMes($certificado['FECHA_SOLICITUD']);
            $transporteVM['FECHA_SOLICITUD'] = $certificado['FECHA_SOLICITUD'];
            $transporteVM['MONTO_ASEGURADO'] = round($certificado['MONTO_ASEGURADO_CIF'], $precision);
            $transporteVM['PRIMA_SEGURO'] = round($certificado['PRIMA_MIN'], $precision);

            $comision = 0;
            $cliente = getCliente($certificado['ID_USUARIO_SOLICITANTE']);
            if (isset($cliente)) {
                if ($transporteVM['MONTO_ASEGURADO'] == 0) {
                    $transporteVM['PRIMA_CLIENTE'] = 0;
                } else {
                    $var1 = $transporteVM['MONTO_ASEGURADO'] * $cliente['TASA'] / 100;
                    $var2 = $cliente['PRIMA_MIN'];
                    $transporteVM['PRIMA_CLIENTE'] = round($var1 < $var2 ? $var2 : $var1, $precision);
                }

                $transporteVM['PROFIT_CLIENTE'] = round($transporteVM['PRIMA_SEGURO'] - $transporteVM['PRIMA_CLIENTE'], $precision);
                $transporteVM['CLIENTE'] = $cliente['NOMBRE'];
                $comision = $cliente['COMISION'];
            }

            $poliza = getPoliza($polizas, $certificado['ID_POLIZA']);
            if (isset($poliza)) {
                $idCompania = $poliza['ID_COMPANIA'];
                $compania = getCompany($companias, $poliza['ID_COMPANIA']);

                if ($transporteVM['MONTO_ASEGURADO'] == 0) {
                    $transporteVM['PRIMA_CIA'] = 0;
                } else {
                    $var1 = $transporteVM['MONTO_ASEGURADO'] * ($compania['TASA'] > 0 ? $compania['TASA'] : 0) / 100;
                    $var2 = $compania['PRIMA_MINIMA'] > 0 ? $compania['PRIMA_MINIMA'] : 0;

                    if ($var1 < $var2) {
                        $transporteVM['PRIMA_CIA'] = round($compania['PRIMA_MINIMA'] > 0 ? $compania['PRIMA_MINIMA'] : 0, $precision);
                    } else {
                        $transporteVM['PRIMA_CIA'] = round($compania['TASA'] > 0 ? $transporteVM['MONTO_ASEGURADO'] * $compania['TASA'] / 100 : 0, $precision);
                    }
                }

                $transporteVM['MEDIO'] = utf8_encode($poliza['TIPO_POLIZA']);
                $transporteVM['POLIZA'] = $poliza['NUMERO'];
                $transporteVM['COMISION_CORREDOR'] = round($transporteVM['PRIMA_CIA'] * $compania['COMISION'] / 100, $precision);
            } else {
                $transporteVM['COMISION_CORREDOR'] = $transporteVM['PRIMA_CIA'] * 0;
            }

            $transporteVM['DIFERENCIA_EQUAL'] = round($transporteVM['PRIMA_CLIENTE'] - $transporteVM['PRIMA_CIA'], $precision);
            $transporteVM['INGRESO_EQUAL'] = round($transporteVM['DIFERENCIA_EQUAL'] + $transporteVM['COMISION_CORREDOR'], $precision);
            $transporteVM['COMISION_VENDEDOR'] = round($transporteVM['INGRESO_EQUAL'] * $comision / 100, $precision);

            $transporteVM['NUMERO_CERTIFICADO'] = $certificado['NUMERO'];
            $transporteVM['TRANSBORDO'] = "Sin Info.";

            $tipoMercaderia = getTipoMercaderia($tipoMercaderias, $certificado['ID_TIPO_MERCADERIA']);
            if (isset($poliza)) {
                $transporteVM['TIPO_MERCADERIA'] = $tipoMercaderia['TIPO_MERCADERIA'];
            }

            $idUsuarioSolicitante = $certificado['ID_USUARIO_SOLICITANTE'];
            $corredora = $insuranceBrokerBusiness->getInsuranceBrokerByIdUser($idUsuarioSolicitante);
            $idUsuarioVendedor = $corredora['ID_USUARIO_VENDEDOR'];
            $usuarioVendedor = $usuarioBusiness->getUser($idUsuarioVendedor);

            $transporteVM['EJECUTIVO'] = $usuarioVendedor['NOMBRE'] . " " . $usuarioVendedor['APELLIDO'];

            $transporteVM['CERTIFICADO'] = "<a href='" . $certificado['UBICACION'] . "'>" . $certificado['FORMATO'] . "</a>";
            $transporteVM['FORMATO'] = $certificado['FORMATO'];
            $transporteVM['FACTURA'] = "Sin Info.";

            $montoAsegurado = $montoAsegurado + $certificado['MONTO_ASEGURADO_CIF'];
            $primaSeguro = $primaSeguro + $certificado['PRIMA_MIN'];
            $primaCliente = $primaCliente + $transporteVM['PRIMA_CLIENTE'];
            $primaCia = $primaCia + $transporteVM['PRIMA_CIA'];
            $difCliente = $difCliente + $transporteVM['PROFIT_CLIENTE'];
            $comisionCorredor = $comisionCorredor + $transporteVM['COMISION_CORREDOR'];
            $difEqual = $difEqual + $transporteVM['DIFERENCIA_EQUAL'];
            $ingresoEqual = $ingresoEqual + $transporteVM['INGRESO_EQUAL'];
            $comisionVendedor = $comisionVendedor + $transporteVM['COMISION_VENDEDOR'];

            array_push($transportesVM, $transporteVM);
        }

        $numeroCertificados = count($certificados);

        $salida = array($transportesVM, $numeroCertificados, round($montoAsegurado, $precision), round($primaSeguro, $precision), round($primaCliente, $precision), round($primaCia, $precision), round($difCliente, $precision), round($comisionCorredor, $precision), round($difEqual, $precision), round($ingresoEqual, $precision), round($comisionVendedor, $precision));

        return $salida;
    }

    function getCompanyTransportStadistic($fechaInicio, $fechaFin)
    {
        $precision = 2;
        $companyBusiness = new Company();
        $usuarioBusiness = new Usuario();
        $polizaBusiness = new Policy();
        $aseguradoBusiness = new Insured();
        $certificadoBusiness = new Certificate();
        $tipoMercaderiaBusiness = new MerchandiseType();

        $companias = $companyBusiness->getCompaniesList();
        $polizas = $polizaBusiness->getPoliciesList();
        $asegurados = $aseguradoBusiness->getInsuredList();
        $tipoMercaderias = $tipoMercaderiaBusiness->getMerchandiseTypesList();

        $isSuperAdmin = isSuperAdmin();
        if ($isSuperAdmin) {
            $certificados = $certificadoBusiness->getCertificatesByDates($fechaInicio, $fechaFin);
        } else {
            $currentUser = getCurrentUser();
            $idCorredora = $currentUser['idCorredora'];
            $usuarios = $usuarioBusiness->getUsers($idCorredora);
            $certificados = $certificadoBusiness->getCertificates($usuarios);
        }

        $montoAsegurado = 0;
        $primaSeguro = 0;
        $primaCia = 0;
        $comisionCorredor = 0;

        $transportesVM = Array();
        foreach ($certificados as $certificado) {
            $transporteVM = Array();
            $transporteVM['ID_CERTIFICADO'] = $certificado['ID_CERTIFICADO'];

            $idAsegurado = $certificado['ID_ASEGURADO'];
            $asegurado = getAsegurado($asegurados, $idAsegurado);
            if (isset($asegurado)) {
                $transporteVM['ASEGURADO'] = $asegurado['NOMBRE'];
            }

            $transporteVM['MES'] = getMes($certificado['FECHA_SOLICITUD']);
            $transporteVM['FECHA_SOLICITUD'] = $certificado['FECHA_SOLICITUD'];
            $transporteVM['MONTO_ASEGURADO'] = round($certificado['MONTO_ASEGURADO_CIF'], $precision);
            $transporteVM['PRIMA_SEGURO'] = round($certificado['PRIMA_MIN'], $precision);

            $poliza = getPoliza($polizas, $certificado['ID_POLIZA']);
            if (isset($poliza)) {
                $idCompania = $poliza['ID_COMPANIA'];
                $compania = getCompany($companias, $poliza['ID_COMPANIA']);

                if ($transporteVM['MONTO_ASEGURADO'] == 0) {
                    $transporteVM['PRIMA_CIA'] = 0;
                } else {
                    $var1 = $transporteVM['MONTO_ASEGURADO'] * ($compania['TASA'] > 0 ? $compania['TASA'] : 0) / 100;
                    $var2 = $compania['PRIMA_MINIMA'] > 0 ? $compania['PRIMA_MINIMA'] : 0;

                    if ($var1 < $var2) {
                        $transporteVM['PRIMA_CIA'] = round($compania['PRIMA_MINIMA'] > 0 ? $compania['PRIMA_MINIMA'] : 0, $precision);
                    } else {
                        $transporteVM['PRIMA_CIA'] = round($compania['TASA'] > 0 ? $transporteVM['MONTO_ASEGURADO'] * $compania['TASA'] / 100 : 0, $precision);
                    }
                }

                $transporteVM['MEDIO'] = utf8_encode($poliza['TIPO_POLIZA']);
                $transporteVM['POLIZA'] = $poliza['NUMERO'];
                $transporteVM['COMISION_CORREDOR'] = round($transporteVM['PRIMA_CIA'] * $compania['COMISION'] / 100, $precision);
            } else {
                $transporteVM['COMISION_CORREDOR'] = $transporteVM['PRIMA_CIA'] * 0;
            }

            $transporteVM['NUMERO_CERTIFICADO'] = $certificado['NUMERO'];
            $transporteVM['TRANSBORDO'] = "Sin Info.";

            $tipoMercaderia = getTipoMercaderia($tipoMercaderias, $certificado['ID_TIPO_MERCADERIA']);
            if (isset($tipoMercaderia)) {
                $transporteVM['TIPO_MERCADERIA'] = $tipoMercaderia['TIPO_MERCADERIA'];
            }

            $montoAsegurado = $montoAsegurado + $certificado['MONTO_ASEGURADO_CIF'];
            $primaSeguro = $primaSeguro + $certificado['PRIMA_MIN'];
            $primaCia = $primaCia + $transporteVM['PRIMA_CIA'];
            $comisionCorredor = $comisionCorredor + $transporteVM['COMISION_CORREDOR'];

            array_push($transportesVM, $transporteVM);
        }

        $numeroCertificados = count($certificados);

        $salida = array($transportesVM, $numeroCertificados, round($montoAsegurado, $precision), round($primaSeguro, $precision), round($primaCia, $precision), round($comisionCorredor, $precision));

        return $salida;
    }

    public function getCertificateRequestsList()
    {
        $certificadoDAO = new Certificado_DAO();

        if (isSuperAdmin() == true) {
            $solicitudesPendientes = $certificadoDAO->getCertificateRequestsList();
        } else {
            $currentUser = getCurrentUser();
            $usuarioBusiness = new Usuario();
            if ($currentUser['idPerfil'] == 3) // Es administrador
            {
                $idCorredora = $currentUser['idCorredora'];
                $usuarios = $usuarioBusiness->getUsers($idCorredora);
            } else {
                $usuarios = $usuarioBusiness->getUser($currentUser['idUsuario']);
            }

            $solicitudesPendientes = $certificadoDAO->getCertificateRequestsByUsersAndState($usuarios, 0); // 0: Pendiente
        }

        return $solicitudesPendientes;
    }

    public function getCertificateRequests($idCorredora)
    {
        $certificadoDAO = new Certificado_DAO();
        return $certificadoDAO->getCertificateRequests($idCorredora);
    }

    public function getCertificateRequestsByUsers($usuarios)
    {
        $certificadoDAO = new Certificado_DAO();
        return $certificadoDAO->getCertificateRequestsByUsers($usuarios);
    }

    public function getRequestList()
    {
        $requestsVM = Array();

        $isSuperAdmin = isSuperAdmin();
        if ($isSuperAdmin) {
            $certificadoSolicitudes = $this->getCertificateRequestsList();

            $usuarioBusiness = new Usuario();
            $usuarios = $usuarioBusiness->getUsersList();
        } else {
            $currentUser = getCurrentUser();
            $usuarioBusiness = new Usuario();
            if ($currentUser['idPerfil'] == 3) // Es administrador
            {
                $idCorredora = $currentUser['idCorredora'];
                $usuarios = $usuarioBusiness->getUsers($idCorredora);
            } else {
                $usuarios = $usuarioBusiness->getUser($currentUser['idUsuario']);
            }

            $certificadoSolicitudes = $this->getCertificateRequestsByUsers($usuarios);
        }

        $mercaderiaBusiness = new MerchandiseType();
        $tipoMercaderias = $mercaderiaBusiness->getMerchandiseTypesList();

        $polizaBusiness = new Policy();
        $polizas = $polizaBusiness->getAllPolicies();

        $materiaBusiness = new InsuredMatter();
        $materiasAseguradas = $materiaBusiness->getInsuredMattersList();

        $embalajeBusiness = new Packing();
        $embalajes = $embalajeBusiness->getPackingsList();

        $aseguradoBusiness = new Insured();
        $asegurados = $aseguradoBusiness->getInsuredList();

        foreach ($certificadoSolicitudes as $certificado) {
            $requestVM = Array();
            $requestVM['ID_CERTIFICADO'] = $certificado['ID_CERTIFICADO'];
            $requestVM['FECHA_SOLICITUD'] = FormatearFechaCompletaSpa($certificado['FECHA_SOLICITUD']);
            $cliente = getCliente($certificado['ID_USUARIO_SOLICITANTE']);
            if (isset($cliente))
                $requestVM['CLIENTE'] = $cliente['NOMBRE'];
            else
                $requestVM['CLIENTE'] = "--";

            $asegurado = getAsegurado($asegurados, $certificado['ID_ASEGURADO']);
            if (isset($asegurado))
                $requestVM['ASEGURADO'] = $asegurado['NOMBRE'];
            else
                $requestVM['ASEGURADO'] = "--";

            $poliza = getPoliza($polizas, $certificado['ID_POLIZA']);
            if (isset($poliza))
                $requestVM['POLIZA'] = $poliza['TIPO_POLIZA'] . " (" . $poliza['NUMERO'] . ")";
            else
                $requestVM['POLIZA'] = "--";

            $requestVM['TIPO'] = $certificado['TIPO'];

            if ($certificado['ESTADO_SOLICITUD'] == 0)
                $requestVM['ESTADO_SOLICITUD'] = "Pendiente";
            else if ($certificado['ESTADO_SOLICITUD'] == 1)
                $requestVM['ESTADO_SOLICITUD'] = "Listo";
            else
                $requestVM['ESTADO_SOLICITUD'] = "--";

            if ($isSuperAdmin) {
                $usuario = getUsuarioSolicitante($certificado['ID_USUARIO_SOLICITANTE']);
                if (isset($usuario))
                    $requestVM['USUARIO_SOLICITANTE'] = $usuario['NOMBRE'] . ' ' . $usuario['APELLIDO'];
                else
                    $requestVM['USUARIO_SOLICITANTE'] = "--";
            }

            array_push($requestsVM, $requestVM);
        }

        return $requestsVM;
    }

    public function getCertificatesListVM()
    {

        $usuarioBusiness = new Usuario();
        $aseguradoBusiness = new Insured();
        $polizaBusiness = new Policy();

        $isSuperAdmin = isSuperAdmin();
        if ($isSuperAdmin) {
            $certificados = $this->getCertificatesList();
        } else {
            $currentUser = getCurrentUser();
            $usuarioBusiness = new Usuario();
            if ($currentUser['idPerfil'] == 3) // Es administrador
            {
                $idCorredora = $currentUser['idCorredora'];
                $usuarios = $usuarioBusiness->getUsers($idCorredora);
            } else {
                $usuarios = $usuarioBusiness->getUser($currentUser['idUsuario']);
            }

            $certificados = $this->getCertificatesByUsers($usuarios);
        }

        $asegurados = $aseguradoBusiness->getAllInsured();
        $usuarios = $usuarioBusiness->getUsersList();
        $polizas = $polizaBusiness->getAllPolicies();

        $certificadosVM = Array();
        foreach ($certificados as $certificado) {
            $certificadoVM = Array();
            $certificadoVM['ID_CERTIFICADO'] = $certificado['ID_CERTIFICADO'];
            $certificadoVM['FECHA_SOLICITUD'] = $certificado['FECHA_SOLICITUD'];

            $usuario = getUsuarioSolicitante($certificado['ID_USUARIO_SOLICITANTE']);
            if (isset($usuario))
                $certificadoVM['NOMBRE_USUARIO'] = $usuario['NOMBRE'] . ' ' . $usuario['APELLIDO'];
            else
                $certificadoVM['NOMBRE_USUARIO'] = "--";

            $asegurado = getAsegurado($asegurados, $certificado['ID_ASEGURADO']);
            if (isset($asegurado))
                $certificadoVM['NOMBRE_ASEGURADO'] = $asegurado['NOMBRE'];
            else
                $certificadoVM['NOMBRE_ASEGURADO'] = "--";

            $poliza = getPoliza($polizas, $certificado['ID_POLIZA']);
            if (isset($asegurado))
                $certificadoVM['POLIZA'] = $poliza['TIPO_POLIZA'] . " (" . $poliza['NUMERO'] . ")";
            else
                $certificadoVM['POLIZA'] = "--";

            $certificadoVM['NUMERO'] = $certificado['NUMERO'];
            $certificadoVM['FORMATO'] = $certificado['FORMATO'];
            $certificadoVM['UBICACION'] = $certificado['UBICACION'];

            array_push($certificadosVM, $certificadoVM);
        }

        return $certificadosVM;
    }

    public function getCertificateAnnulledList()
    {

        $certificadoDAO = new Certificado_DAO();
        return $certificadoDAO->getCertificateAnnulledList();

    }

    public function getCertificateAnnulled($idCorredora)
    {

        $certificadoDAO = new Certificado_DAO();
        return $certificadoDAO->getCertificateAnnulled($idCorredora);

    }

    public function getCertificateAnnulledByUsers($usuarios)
    {

        $certificadoDAO = new Certificado_DAO();
        return $certificadoDAO->getCertificateAnnulledByUsers($usuarios);

    }

    public function getAnnulmentsVM()
    {

        $aseguradoBusiness = new Insured();
        $polizaBusiness = new Policy();

        $isSuperAdmin = isSuperAdmin();
        if ($isSuperAdmin) {
            $certificadoAnulados = $this->getCertificateAnnulledList();
        } else {
            $currentUser = getCurrentUser();
            $usuarioBusiness = new Usuario();
            if ($currentUser['idPerfil'] == 3) // Es administrador
            {
                $idCorredora = $currentUser['idCorredora'];
                $usuarios = $usuarioBusiness->getUsers($idCorredora);
            } else {
                $usuarios = $usuarioBusiness->getUser($currentUser['idUsuario']);
            }

            $certificadoAnulados = $this->getCertificateAnnulledByUsers($usuarios);
        }

        $polizas = $polizaBusiness->getAllPolicies();
        $asegurados = $aseguradoBusiness->getAllInsured();

        $certificadosVM = Array();
        foreach ($certificadoAnulados as $certificado) {
            $certificadoVM = Array();
            $certificadoVM['ID_CERTIFICADO'] = $certificado['ID_CERTIFICADO'];
            $certificadoVM['FORMATO'] = $certificado['FORMATO'];
            $certificadoVM['NUMERO'] = $certificado['NUMERO'];

            $poliza = getPoliza($polizas, $certificado['ID_POLIZA']);
            if (isset($poliza))
                $certificadoVM['POLIZA'] = $poliza['TIPO_POLIZA'] . " (" . $poliza['NUMERO'] . ")";
            else
                $certificadoVM['POLIZA'] = "--";

            $cliente = getCliente($certificado['ID_USUARIO_SOLICITANTE']);
            if (isset($cliente))
                $certificadoVM['CLIENTE'] = $cliente['NOMBRE'];
            else
                $certificadoVM['CLIENTE'] = "--";

            $asegurado = getAsegurado($asegurados, $certificado['ID_ASEGURADO']);
            if (isset($asegurado))
                $certificadoVM['NOMBRE_ASEGURADO'] = $asegurado['NOMBRE'];
            else
                $certificadoVM['NOMBRE_ASEGURADO'] = "--";

            $certificadoVM['MOTIVO'] = $certificado['MOTIVO'];
            $certificadoVM['ID_CERTIFICADO_REEMPLAZO'] = $certificado['ID_CERTIFICADO_REEMPLAZO'];

            $certificadoReemplazo = $this->getCertificate($certificado['ID_CERTIFICADO_REEMPLAZO']);
            if (isset($certificadoReemplazo)) {
                $certificadoVM['FORMATO_REEMPLAZO'] = $certificadoReemplazo['FORMATO'];
                $certificadoVM['NUMERO_REEMPLAZO'] = $certificadoReemplazo['NUMERO'];
            } else {
                $certificadoVM['FORMATO_REEMPLAZO'] = "--";
                $certificadoVM['NUMERO_REEMPLAZO'] = "--";
            }

            if ($certificado['ESTADO_ANULACION'] == 0)
                $certificadoVM['ESTADO_ANULACION'] = "Pendiente";
            else if ($certificado['ESTADO_ANULACION'] == 1)
                $certificadoVM['ESTADO_ANULACION'] = "Listo";
            else
                $certificadoVM['ESTADO_ANULACION'] = "--";

            array_push($certificadosVM, $certificadoVM);

        }

        return $certificadosVM;
    }


    public function getCertificateModifies($idCorredora)
    {
        $certificadoModificacionDAO = new CertificadoModificacion_DAO();
        return $certificadoModificacionDAO->getCertificateModifies($idCorredora);
    }

    public function getCertificateModifiesByUsers($usuarios)
    {
        $certificadoModificacionDAO = new CertificadoModificacion_DAO();
        return $certificadoModificacionDAO->getCertificateModifiesByUsers($usuarios);
    }

    public function getCertificateModifiesList()
    {
        $certificadoModificacionDAO = new CertificadoModificacion_DAO();
        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $certificadoModificaciones = $certificadoModificacionDAO->getCertificateModifiesList();
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

            $certificadoModificaciones = $certificadoModificacionDAO->getCertificateModifiesByUsers($usuarios);
        }


        return $certificadoModificaciones;
    }

    public function getCertificateModifiesVM()
    {
        $aseguradoBusiness = new Insured();
        $polizaBusiness = new Policy();

        $isSuperAdmin = isSuperAdmin();
        if ($isSuperAdmin) {
            $certificadoModificaciones = $this->getCertificateModifiesList();
        } else {
            $currentUser = getCurrentUser();
            $usuarioBusiness = new Usuario();
            if ($currentUser['idPerfil'] == 3) // Es administrador
            {
                $idCorredora = $currentUser['idCorredora'];
                $usuarios = $usuarioBusiness->getUsers($idCorredora);
            } else {
                $usuarios = $usuarioBusiness->getUser($currentUser['idUsuario']);
            }

            $certificadoModificaciones = $this->getCertificateModifiesByUsers($usuarios);
        }

        $polizas = $polizaBusiness->getAllPolicies();
        $asegurados = $aseguradoBusiness->getInsuredList();

        $certificadosVM = $this->ToCertificadoVM($certificadoModificaciones, $polizas, $asegurados);

        return $certificadosVM;
    }

    public function searchCertificate($idPoliza, $numero)
    {

        $model = new Certificado_DAO();
        $usuarioBusiness = new Usuario();
        if (isSuperAdmin() == true) {
            $usuarios = $usuarioBusiness->getUsersList();
        } else {
            $currentUser = getCurrentUser();

            if ($currentUser['idPerfil'] == 3) // Es administrador
            {
                $idCorredora = $currentUser['idCorredora'];
                $usuarios = $usuarioBusiness->getUsers($idCorredora);
            } else {
                $usuarios = $usuarioBusiness->getUser($currentUser['idUsuario']);
            }
        }

        $certificado = $model->searchCertificate($idPoliza, $numero, $usuarios);
        return $certificado;
    }

    public function getCertificateRequest($idCertificadoSolicitud)
    {
        $model = new Certificado_DAO();
        return $model->getCertificateRequest($idCertificadoSolicitud);
    }

    public function addCertificate($idCertificadoSolicitud, $numeroCertificado, $formato, $ubicacion)
    {
        $model = new Certificado_DAO();
        $model->addCertificate($idCertificadoSolicitud, $numeroCertificado, $formato, $ubicacion);
    }

    public function getCertificateModify($idCertificadoModificacion)
    {
        $model = new CertificadoModificacion_DAO();
        return $model->getCertificateModify($idCertificadoModificacion);
    }

    public function setCertificateModify($idCertificadoModificacion, $estado)
    {
        $model = new CertificadoModificacion_DAO();
        $model->setCertificateModify($idCertificadoModificacion, $estado);
    }

    public function changeCertificate($idCertificado, $numeroCertificado, $formato, $ubicacion)
    {
        $model = new Certificado_DAO();
        $model->changeCertificate($idCertificado, $numeroCertificado, $formato, $ubicacion);
    }

    public function editCertificate($idCertificado, $idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo, $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloCamion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada, $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones)
    {
        /*$model = new Certificado_DAO();
        $model->editCertificate($idCertificado, $idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo, $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloCamion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada, $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones);*/
    }

    public function deleteCertificate($idCertificado)
    {
        $model = new Certificado_DAO();
        $model->deleteCertificate($idCertificado);
    }

    public function newCertificateRequest($idUsuarioSolicitante, $idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo,
                                          $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloCamion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada,
                                          $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones, $estadoSolicitud, $estadoAnulacion, $habilitado)
    {
        $model = new Certificado_DAO();
        $model->newCertificateRequest($idUsuarioSolicitante, $idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo,
            $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloCamion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada,
            $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones, $estadoSolicitud, $estadoAnulacion, $habilitado);
    }

    public function editCertificateRequest($idCertificadoSolicitud, $idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo, $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloCamion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada, $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones)
    {
        $model = new Certificado_DAO();
        $model->editCertificateRequest($idCertificadoSolicitud, $idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo, $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloCamion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada, $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones);
    }

    public function getCertificateAnnulmentsList()
    {
        $model = new Certificado_DAO();

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $certificadoAnulaciones = $model->getCertificateAnnulmentsList();
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

            $certificadoAnulaciones = $model->getCertificateAnnulmentsByUsers($usuarios);
        }

        return $certificadoAnulaciones;
    }

    public function newCertificateAnnulment($idCertificado, $motivo)
    {
        $model = new Certificado_DAO();
        $model -> newCertificateAnnulment($idCertificado, $motivo);
    }

    public function editCertificateAnnulment($idCertificado, $motivo)
    {
        $model = new Certificado_DAO();
        $model -> editCertificateAnnulment($idCertificado, $motivo);
    }

    public function getCertificateAnnulment($idCertificadoAnulacion)
    {
        $model = new Certificado_DAO();
        return $model -> getCertificateAnnulment($idCertificadoAnulacion);
    }

    public function addReplaceCertificateNumber2db($idCertificadoAnulacion, $idCertificado)
    {
        $model = new Certificado_DAO();
        $model -> addReplaceCertificateNumber2db($idCertificadoAnulacion, $idCertificado);
    }

    public function setCertificateAnnulment($idCertificadoAnulacion, $estado)
    {
        $model = new Certificado_DAO();
        $model -> setCertificateAnnulment($idCertificadoAnulacion, $estado);
    }

    public function newCertificateModify($idCertificado, $dondeDice, $debeDecir)
    {
        $model = new CertificadoModificacion_DAO();
        $model -> newCertificateModify($idCertificado, $dondeDice, $debeDecir);
    }

    public function editCertificateModify($idCertificadoModificacion, $idCertificado, $dondeDice, $debeDecir)
    {
        $model = new CertificadoModificacion_DAO();
        $model->editCertificateModify($idCertificadoModificacion, $idCertificado, $dondeDice, $debeDecir);
    }

    public function deleteCertificateModify($idCertificadoModificacion)
    {
        $model = new CertificadoModificacion_DAO();
        $model->deleteCertificateModify($idCertificadoModificacion);
    }




    public function ToCertificadoVM($certificadoModificaciones, $polizas, $asegurados)
    {
        $certificadosVM = array();
        foreach ($certificadoModificaciones as $modificacion) {
            $certificadoVM = array();
            $certificadoVM['ID_CERTIFICADO_MODIFICACION'] = $modificacion['ID_CERTIFICADO_MODIFICACION'];

            $certificadoMoficado = $this->getCertificate($modificacion['ID_CERTIFICADO']);
            if (isset($certificadoMoficado)) {
                $poliza = getPoliza($polizas, $certificadoMoficado['ID_POLIZA']);
                if (isset($poliza))
                    $certificadoVM['POLIZA'] = $poliza['TIPO_POLIZA'] . " (" . $poliza['NUMERO'] . ")";
                else
                    $certificadoVM['POLIZA'] = "--";

                $certificadoVM['FORMATO'] = $certificadoMoficado['FORMATO'];
                $certificadoVM['NUMERO'] = $certificadoMoficado['NUMERO'];

                $cliente = getCliente($certificadoMoficado['ID_USUARIO_SOLICITANTE']);
                if (isset($cliente))
                    $certificadoVM['CLIENTE'] = $cliente['NOMBRE'];
                else
                    $certificadoVM['CLIENTE'] = "--";

                $asegurado = getAsegurado($asegurados, $certificadoMoficado['ID_ASEGURADO']);
                if (isset($asegurado))
                    $certificadoVM['NOMBRE_ASEGURADO'] = $asegurado['NOMBRE'];
                else
                    $certificadoVM['NOMBRE_ASEGURADO'] = "--";

            } else {
                $certificadoVM['POLIZA'] = "--";
                $certificadoVM['FORMATO_REEMPLAZO'] = "--";
                $certificadoVM['NUMERO_REEMPLAZO'] = "--";
                $certificadoVM['CLIENTE'] = "--";
                $certificadoVM['NOMBRE_ASEGURADO'] = "--";
            }

            $certificadoVM['DONDE_DICE'] = $modificacion['DONDE_DICE'];
            $certificadoVM['DEBE_DECIR'] = $modificacion['DEBE_DECIR'];

            if ($modificacion['ESTADO'] == 0)
                $certificadoVM['ESTADO'] = "Pendiente";
            else if ($modificacion['ESTADO'] == 1)
                $certificadoVM['ESTADO'] = "Listo";
            else
                $certificadoVM['ESTADO'] = "--";

            array_push($certificadosVM, $certificadoVM);
        }

        return $certificadosVM;
    }

}