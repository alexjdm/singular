<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/SessionHelper.php';
require_once 'helpers/CommonHelper.php';
include_once("businesslogic/Policy.php");
include_once("businesslogic/Insured.php");
include_once("businesslogic/Packing.php");
include_once("businesslogic/MerchandiseType.php");
include_once("businesslogic/Guarantee.php");
require "lib/phpmailer/class.phpmailer.php";

class GuaranteePolicyController {

    public function __construct()
    {
    }

    public function index() {

        $garantiaBusiness = new Guarantee();
        $garantiasVM = $garantiaBusiness -> getGuaranteePoliciesVM();

        require_once('views/guaranteepolicy/index.php');
    }

    public function newGuaranteePolicy() {

        $aseguradoBusiness = new Insured();
        $tipoMercaderiaBusiness = new MerchandiseType();
        $packingBusiness = new Packing();

        $asegurados = $aseguradoBusiness->getAllInsured();
        //$asegurados = $aseguradoBusiness->getInsuredList();
        $tipoMercaderias = $tipoMercaderiaBusiness->getMerchandiseTypesList();
        $embalajes = $packingBusiness->getPackingsList();

        require_once('views/guaranteepolicy/newGuaranteePolicy.php');
    }

    public function createNewGuaranteePolicy() {

        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;
        $tipoGarantia = isset($_GET['tipoGarantia']) ? $_GET['tipoGarantia'] : null;
        $tipoMercaderia = isset($_GET['tipoMercaderia']) ? $_GET['tipoMercaderia'] : null;
        $embalaje = isset($_GET['Packing']) ? $_GET['Packing'] : null;
        $direccion = isset($_GET['direccion']) ? $_GET['direccion'] : null;
        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
        $fechaInicio = date("Y-m-d", strtotime($fechaInicio));
        $plazo = isset($_GET['plazo']) ? $_GET['plazo'] : null;
        $montoCIF = isset($_GET['montoCIF']) ? $_GET['montoCIF'] : null;
        $derechos = isset($_GET['derechos']) ? $_GET['derechos'] : null;
        $currentUser = getCurrentUser();
        $idUsuarioSolicitante = $currentUser['id'];

        $garantiaBusiness = new Guarantee();
        $garantiaBusiness->newGuaranteePolicy($idAsegurado, $tipoGarantia, $tipoMercaderia, $embalaje, $direccion, $fechaInicio, $plazo, $montoCIF, $derechos, $idUsuarioSolicitante);
    }

    public function guaranteePolicyEdit() {
        $idGarantia = isset($_GET['idGarantia']) ? $_GET['idGarantia'] : null;

        $garantiaBusiness = new Guarantee();
        $aseguradoBusiness = new Insured();
        $tipoMercaderiaBusiness = new MerchandiseType();
        $packingBusiness = new Packing();

        $solicitudGarantia = $garantiaBusiness->getGuaranteePolicy($idGarantia);

        $asegurados = $aseguradoBusiness->getInsuredList();
        $tipoMercaderias = $tipoMercaderiaBusiness->getMerchandiseTypesList();
        $embalajes = $packingBusiness->getPackingsList();
        $aseguradoSel = array();
        foreach ($asegurados as $asegurado):
            if($asegurado['ID_ASEGURADO'] == $solicitudGarantia['ID_ASEGURADO']):
                $aseguradoSel = $asegurado;
            endif;
        endforeach;

        require_once('views/guaranteepolicy/guaranteePolicyEdit.php');
    }

    public function guaranteePolicyEdit2db() {

        $idGarantia = isset($_GET['idGarantia']) ? $_GET['idGarantia'] : null;
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;
        $tipoGarantia = isset($_GET['tipoGarantia']) ? $_GET['tipoGarantia'] : null;
        $tipoMercaderia = isset($_GET['tipoMercaderia']) ? $_GET['tipoMercaderia'] : null;
        $embalaje = isset($_GET['Packing']) ? $_GET['Packing'] : null;
        $direccion = isset($_GET['direccion']) ? $_GET['direccion'] : null;
        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
        $fechaInicio = date("Y-m-d", strtotime($fechaInicio));
        $plazo = isset($_GET['plazo']) ? $_GET['plazo'] : null;
        $montoCIF = isset($_GET['montoCIF']) ? $_GET['montoCIF'] : null;
        $derechos = isset($_GET['derechos']) ? $_GET['derechos'] : null;

        $garantiaBusiness = new Guarantee();
        $garantiaBusiness->editGuaranteePolicy($idGarantia, $idAsegurado, $tipoGarantia, $tipoMercaderia, $embalaje, $direccion, $fechaInicio, $plazo, $montoCIF, $derechos);
    }

    public function deleteGuaranteePolicy() {
        $idGarantia = isset($_GET['idGarantia']) ? $_GET['idGarantia'] : null;

        $garantiaBusiness = new Guarantee();
        $garantiaBusiness ->deleteGuaranteePolicy($idGarantia);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}