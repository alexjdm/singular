<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/PolizaGarantia_DAO.php");
include_once("models/DAO/Asegurado_DAO.php");
include_once("models/DAO/Embalaje_DAO.php");
include_once("models/DAO/TipoMercaderia_DAO.php");
require "lib/phpmailer/class.phpmailer.php";

class GuaranteePolicyController {

    public $model;
    public $modelC;
    public $modelTM;
    public $modelA;
    public $modelE;

    public function __construct()
    {
        $this->model = new PolizaGarantia_DAO();
        $this->modelTM = new TipoMercaderia_DAO();
        $this->modelA = new Asegurado_DAO();
        $this->modelE = new Embalaje_DAO();
    }

    public function index() {

        $garantias = $this->model->getGuaranteePoliciesList();

        $asegurados = $this->modelA->getInsuredList();

        $tipoMercaderias = $this->modelTM->getMerchandiseTypesList();
        $embalajes = $this->modelE->getPackingsList();

        require_once('views/guaranteepolicy/index.php');
    }

    public function newGuaranteePolicy() {
        $asegurados = $this->modelA->getInsuredList();
        $tipoMercaderias = $this->modelTM->getMerchandiseTypesList();
        $embalajes = $this->modelE->getPackingsList();

        require_once('views/guaranteepolicy/newGuaranteePolicy.php');
    }

    public function createNewGuaranteePolicy() {

        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;
        $tipoGarantia = isset($_GET['tipoGarantia']) ? $_GET['tipoGarantia'] : null;
        $tipoMercaderia = isset($_GET['tipoMercaderia']) ? $_GET['tipoMercaderia'] : null;
        $embalaje = isset($_GET['embalaje']) ? $_GET['embalaje'] : null;
        $direccion = isset($_GET['direccion']) ? $_GET['direccion'] : null;
        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
        $fechaInicio = date("Y-m-d", strtotime($fechaInicio));
        $plazo = isset($_GET['plazo']) ? $_GET['plazo'] : null;
        $montoCIF = isset($_GET['montoCIF']) ? $_GET['montoCIF'] : null;
        $derechos = isset($_GET['derechos']) ? $_GET['derechos'] : null;

        return $this->model->newGuaranteePolicy($idAsegurado, $tipoGarantia, $tipoMercaderia, $embalaje, $direccion, $fechaInicio, $plazo, $montoCIF, $derechos);
    }

    public function guaranteePolicyEdit() {
        $idGarantia = isset($_GET['idGarantia']) ? $_GET['idGarantia'] : null;
        $solicitudGarantia = $this->model->getGuaranteePolicy($idGarantia);

        $asegurados = $this->modelA->getInsuredList();
        $tipoMercaderias = $this->modelTM->getMerchandiseTypesList();
        $embalajes = $this->modelE->getPackingsList();
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
        $embalaje = isset($_GET['embalaje']) ? $_GET['embalaje'] : null;
        $direccion = isset($_GET['direccion']) ? $_GET['direccion'] : null;
        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : null;
        $fechaInicio = date("Y-m-d", strtotime($fechaInicio));
        $plazo = isset($_GET['plazo']) ? $_GET['plazo'] : null;
        $montoCIF = isset($_GET['montoCIF']) ? $_GET['montoCIF'] : null;
        $derechos = isset($_GET['derechos']) ? $_GET['derechos'] : null;

        return $this->model->editGuaranteePolicy($idGarantia, $idAsegurado, $tipoGarantia, $tipoMercaderia, $embalaje, $direccion, $fechaInicio, $plazo, $montoCIF, $derechos);
    }

    public function deleteGuaranteePolicy() {
        $idGarantia = isset($_GET['idGarantia']) ? $_GET['idGarantia'] : null;

        return $this->model->deleteGuaranteePolicy($idGarantia);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}