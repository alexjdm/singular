<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';

include_once("businesslogic/Sinister.php");
include_once("businesslogic/Usuario.php");
include_once("businesslogic/InsuranceBroker.php");
include_once("businesslogic/Company.php");
include_once("businesslogic/MerchandiseType.php");
include_once("businesslogic/Policy.php");
include_once("businesslogic/Certificate.php");
include_once("businesslogic/Insured.php");
include_once("businesslogic/Insurance.php");



class StadisticController {


    public function __construct()
    {
    }

    public function sinister() {

        $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;
        //$fecha = '14-11-2018 al 21-11-2018';
        if($fecha == null)
        {
            $fechaInicio = date('Y-m-d', strtotime(date('Y-m-d'). ' - 7 days'));
            $fechaFin = date('Y-m-d');
        }
        else
        {
            $splitStr = explode(" ",$fecha);
            $fechaInicio = FormatearFechaEn($splitStr[0]);
            $fechaFin = FormatearFechaEn($splitStr[2]);
        }

        $siniestroBusiness = new Sinister();
        $salida = $siniestroBusiness -> getSinisterStadistic($fechaInicio, $fechaFin);

        if(isset($salida))
        {
            $siniestrosVM = $salida[0];
            $numeroCertificados = $salida[1];
            $montoAsegurado = $salida[2];
            $primaSeguro = $salida[3];
            $montoProvision = $salida[4];
            $indemnizacion = $salida[5];
        }

        require_once('views/stadistic/sinister.php');
    }

    public function sinisterContent() {

        $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;
        //$fecha = '14-11-2018 al 21-11-2018';
        if($fecha == null)
        {
            $fechaInicio = date('Y-m-d', strtotime(date('Y-m-d'). ' - 7 days'));
            $fechaFin = date('Y-m-d');
        }
        else
        {
            $splitStr = explode(" ",$fecha);
            $fechaInicio = FormatearFechaEn($splitStr[0]);
            $fechaFin = FormatearFechaEn($splitStr[2]);

        }

        $siniestroBusiness = new Sinister();
        $salida = $siniestroBusiness -> getSinisterStadistic($fechaInicio, $fechaFin);

        if(isset($salida))
        {
            $siniestrosVM = $salida[0];
            $numeroCertificados = $salida[1];
            $montoAsegurado = $salida[2];
            $primaSeguro = $salida[3];
            $montoProvision = $salida[4];
            $indemnizacion = $salida[5];
        }

        require_once('views/stadistic/sinisterContent.php');
    }

    public function sinisterEdit() {
        $idSiniestro = isset($_GET['idSiniestro']) ? $_GET['idSiniestro'] : null;

        $siniestroBusiness = new Sinister();
        $certificadoBusiness = new Certificate();
        $polizaBusiness = new Policy();

        $siniestro = $siniestroBusiness->getSinister($idSiniestro);
        $certificado = $certificadoBusiness->getCertificate($siniestro['ID_CERTIFICADO']);
        $numeroCertificado = $certificado['NUMERO'];

        $polizas = $polizaBusiness->getPoliciesList();

        require_once('views/stadistic/sinisterEdit.php');
    }

    public function sinisterEdit2db() {
        $idSiniestro = isset($_GET['idSiniestro']) ? $_GET['idSiniestro'] : null;
        $siniestro = isset($_GET['siniestro']) ? $_GET['siniestro'] : null;
        $montoProvision = isset($_GET['montoProvision']) ? $_GET['montoProvision'] : null;
        $indemnizacion = isset($_GET['indemnizacion']) ? $_GET['indemnizacion'] : null;

        $siniestroBusiness = new Sinister();

        $siniestroBusiness->editSinisterFromStadistic($idSiniestro, $siniestro, $montoProvision, $indemnizacion);
    }



    public function clienttransport() {

        $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;
        //$fecha = '14-11-2018 al 21-11-2018';
        if($fecha == null)
        {
            $fechaInicio = date('Y-m-d', strtotime(date('Y-m-d'). ' - 7 days'));
            $fechaFin = date('Y-m-d');
        }
        else
        {
            $splitStr = explode(" ",$fecha);
            $fechaInicio = FormatearFechaEn($splitStr[0]);
            $fechaFin = FormatearFechaEn($splitStr[2]);

        }

        $certificadoBusiness = new Certificate();
        $salida = $certificadoBusiness -> getClientTransportStadistic($fechaInicio, $fechaFin);


        if(isset($salida))
        {
            $transportesVM = $salida[0];
            $numeroCertificados = $salida[1];
            $montoAsegurado = $salida[2];
            $primaSeguro = $salida[3];
            $primaCliente = $salida[4];
            $difCliente = $salida[5];
        }

        require_once('views/stadistic/clienttransport.php');
    }

    public function clienttransportContent() {

        $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;
        //$fecha = '14-11-2018 al 21-11-2018';
        if($fecha == null)
        {
            $fechaInicio = date('Y-m-d', strtotime(date('Y-m-d'). ' - 7 days'));
            $fechaFin = date('Y-m-d');
        }
        else
        {
            $splitStr = explode(" ",$fecha);
            $fechaInicio = FormatearFechaEn($splitStr[0]);
            $fechaFin = FormatearFechaEn($splitStr[2]);

        }

        $certificadoBusiness = new Certificate();
        $salida = $certificadoBusiness -> getClientTransportStadistic($fechaInicio, $fechaFin);

        if(isset($salida))
        {
            $transportesVM = $salida[0];
            $numeroCertificados = $salida[1];
            $montoAsegurado = $salida[2];
            $primaSeguro = $salida[3];
            $primaCliente = $salida[4];
            $difCliente = $salida[5];
        }

        require_once('views/stadistic/clienttransportContent.php');
    }

    public function clienttransportEdit() {
        $idSiniestro = isset($_GET['idSiniestro']) ? $_GET['idSiniestro'] : null;

        $siniestroBusiness = new Sinister();
        $certificadoBusiness = new Certificate();
        $polizaBusiness = new Policy();

        $siniestro = $siniestroBusiness->getSinister($idSiniestro);
        $certificado = $certificadoBusiness->getCertificate($siniestro['ID_CERTIFICADO']);
        $numeroCertificado = $certificado['NUMERO'];

        $polizas = $polizaBusiness->getPoliciesList();

        require_once('views/stadistic/sinisterEdit.php');
    }

    public function clienttransportEdit2db() {
        $idSiniestro = isset($_GET['idSiniestro']) ? $_GET['idSiniestro'] : null;
        $siniestro = isset($_GET['siniestro']) ? $_GET['siniestro'] : null;
        $montoProvision = isset($_GET['montoProvision']) ? $_GET['montoProvision'] : null;
        $indemnizacion = isset($_GET['indemnizacion']) ? $_GET['indemnizacion'] : null;

        $siniestroBusiness = new Sinister();

        $siniestroBusiness->editSinisterFromStadistic($idSiniestro, $siniestro, $montoProvision, $indemnizacion);
    }


    public function sellertransport() {

        $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;
        //$fecha = '14-11-2018 al 21-11-2018';
        if($fecha == null)
        {
            $fechaInicio = date('Y-m-d', strtotime(date('Y-m-d'). ' - 7 days'));
            $fechaFin = date('Y-m-d');
        }
        else
        {
            $splitStr = explode(" ",$fecha);
            $fechaInicio = FormatearFechaEn($splitStr[0]);
            $fechaFin = FormatearFechaEn($splitStr[2]);

        }

        $certificadoBusiness = new Certificate();
        $salida = $certificadoBusiness -> getSellerTransportStadistic($fechaInicio, $fechaFin);

        if(isset($salida))
        {
            $transportesVM = $salida[0];
            $numeroCertificados = $salida[1];
            $montoAsegurado = $salida[2];
            $primaSeguro = $salida[3];
            $primaCliente = $salida[4];
            $primaCia = $salida[5];
            $difCliente = $salida[6];
            $comisionCorredor = $salida[7];
            $difEqual = $salida[8];
            $ingresoEqual = $salida[9];
            $comisionVendedor = $salida[10];
        }

        require_once('views/stadistic/sellertransport.php');
    }

    public function sellertransportContent() {

        $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;
        //$fecha = '14-11-2018 al 21-11-2018';
        if($fecha == null)
        {
            $fechaInicio = date('Y-m-d', strtotime(date('Y-m-d'). ' - 7 days'));
            $fechaFin = date('Y-m-d');
        }
        else
        {
            $splitStr = explode(" ",$fecha);
            $fechaInicio = FormatearFechaEn($splitStr[0]);
            $fechaFin = FormatearFechaEn($splitStr[2]);

        }

        $certificadoBusiness = new Certificate();
        $salida = $certificadoBusiness -> getSellerTransportStadistic($fechaInicio, $fechaFin);

        if(isset($salida))
        {
            $transportesVM = $salida[0];
            $numeroCertificados = $salida[1];
            $montoAsegurado = $salida[2];
            $primaSeguro = $salida[3];
            $primaCliente = $salida[4];
            $primaCia = $salida[5];
            $difCliente = $salida[6];
            $comisionCorredor = $salida[7];
            $difEqual = $salida[8];
            $ingresoEqual = $salida[9];
            $comisionVendedor = $salida[10];
        }

        require_once('views/stadistic/sellertransportContent.php');
    }


    public function companytransport() {

        $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;
        //$fecha = '14-11-2018 al 21-11-2018';
        if($fecha == null)
        {
            $fechaInicio = date('Y-m-d', strtotime(date('Y-m-d'). ' - 7 days'));
            $fechaFin = date('Y-m-d');
        }
        else
        {
            $splitStr = explode(" ",$fecha);
            $fechaInicio = FormatearFechaEn($splitStr[0]);
            $fechaFin = FormatearFechaEn($splitStr[2]);
        }

        $certificadoBusiness = new Certificate();
        $salida = $certificadoBusiness -> getCompanyTransportStadistic($fechaInicio, $fechaFin);

        if(isset($salida))
        {
            $transportesVM = $salida[0];
            $numeroCertificados = $salida[1];
            $montoAsegurado = $salida[2];
            $primaSeguro = $salida[3];
            $primaCia = $salida[4];
            $comisionCorredor = $salida[5];
        }

        require_once('views/stadistic/companytransport.php');
    }

    public function companytransportContent() {

        $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;
        //$fecha = '14-11-2018 al 21-11-2018';
        if($fecha == null)
        {
            $fechaInicio = date('Y-m-d', strtotime(date('Y-m-d'). ' - 7 days'));
            $fechaFin = date('Y-m-d');
        }
        else
        {
            $splitStr = explode(" ",$fecha);
            $fechaInicio = FormatearFechaEn($splitStr[0]);
            $fechaFin = FormatearFechaEn($splitStr[2]);
        }

        $certificadoBusiness = new Certificate();
        $salida = $certificadoBusiness -> getCompanyTransportStadistic($fechaInicio, $fechaFin);

        if(isset($salida))
        {
            $transportesVM = $salida[0];
            $numeroCertificados = $salida[1];
            $montoAsegurado = $salida[2];
            $primaSeguro = $salida[3];
            $primaCia = $salida[4];
            $comisionCorredor = $salida[5];
        }


        require_once('views/stadistic/companytransportContent.php');
    }


    public function singulartransport() {

        $usuarioBusiness = new Usuario();
        $polizaBusiness = new Policy();
        $aseguradoBusiness = new Insured();
        $certificadoBusiness = new Certificate();
        $tipoMercaderiaBusiness = new MerchandiseType();

        $polizas = $polizaBusiness->getPoliciesList();
        $asegurados = $aseguradoBusiness->getInsuredList();
        $tipoMercaderias = $tipoMercaderiaBusiness->getMerchandiseTypesList();

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $certificados = $certificadoBusiness->getCertificatesList();
        }
        else
        {
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
        foreach ($certificados as $certificado)
        {
            $transporteVM = Array();
            $transporteVM['ID_CERTIFICADO'] = $certificado['ID_CERTIFICADO'];

            $idAsegurado = $certificado['ID_ASEGURADO'];
            $asegurado = getAsegurado($asegurados, $idAsegurado);
            if(isset($asegurado))
            {
                $transporteVM['ASEGURADO'] = $asegurado['NOMBRE'];
            }

            $transporteVM['MES'] = getMes($certificado['FECHA_SOLICITUD']);
            $transporteVM['FECHA_SOLICITUD'] = $certificado['FECHA_SOLICITUD'];
            $transporteVM['MONTO_ASEGURADO'] = $certificado['MONTO_ASEGURADO_CIF'];
            $transporteVM['PRIMA_SEGURO'] = $certificado['PRIMA_MIN'];

            $cliente = getCliente($certificado['ID_USUARIO_SOLICITANTE']);
            if(isset($cliente))
            {
                $transporteVM['PRIMA_CLIENTE'] = $cliente['PRIMA_MIN'];
                $transporteVM['PROFIT_CLIENTE'] = $transporteVM['PRIMA_SEGURO'] - $transporteVM['PRIMA_CLIENTE'];
            }

            $poliza = getPoliza($polizas, $certificado['ID_POLIZA']);
            if(isset($poliza))
            {
                $transporteVM['MEDIO'] = utf8_encode($poliza['TIPO_POLIZA']);
                $transporteVM['POLIZA'] = $poliza['NUMERO'];
            }

            $transporteVM['NUMERO_CERTIFICADO'] = $certificado['NUMERO'];
            $transporteVM['TRANSBORDO'] = "Sin Info.";

            $tipoMercaderia = getTipoMercaderia($tipoMercaderias, $certificado['ID_TIPO_MERCADERIA']);
            if(isset($poliza))
            {
                $transporteVM['TIPO_MERCADERIA'] = $tipoMercaderia['TIPO_MERCADERIA'];
            }

            $transporteVM['EJECUTIVO'] = "";
            $transporteVM['CERTIFICADO'] = "<a href='" . $certificado['UBICACION'] .  "'>" . $certificado['FORMATO'] . "</a>";
            $transporteVM['FACTURA'] = "Sin Info.";


            $montoAsegurado = $montoAsegurado + $certificado['MONTO_ASEGURADO_CIF'];
            $primaSeguro = $primaSeguro + $certificado['PRIMA_MIN'];
            $primaCliente = $primaCliente + $transporteVM['PRIMA_CLIENTE'];
            $difCliente = $difCliente + $transporteVM['PROFIT_CLIENTE'];

            array_push($transportesVM, $transporteVM);
        }

        $numeroCertificados = count($certificados);

        require_once('views/stadistic/singulartransport.php');
    }




    public function error() {
        require_once('views/error/error.php');
    }

}