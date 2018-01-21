<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/Seguro_DAO.php");
include_once("models/DAO/Asegurado_DAO.php");
include_once("models/DAO/Region_DAO.php");
include_once("models/DAO/Comuna_DAO.php");
include_once("models/DAO/Corredora_DAO.php");
include_once("models/DAO/Poliza_DAO.php");
include_once("models/DAO/TipoMercaderia_DAO.php");
include_once("models/DAO/Usuario_DAO.php");
require "lib/phpmailer/class.phpmailer.php";

class InsuranceController {

    public $modelS;
    public $modelA;
    public $modelR;
    public $modelC;
    public $modelCl;
    public $modelTM;
    public $modelTMe;
    public $modelU;

    public function __construct()
    {
        $this->modelS = new Seguro_DAO();
        $this->modelA = new Asegurado_DAO();
        $this->modelR = new Region_DAO();
        $this->modelC = new Comuna_DAO();
        $this->modelCl = new Corredora_DAO();
        $this->modelTM = new Poliza_DAO();
        $this->modelTMe = new TipoMercaderia_DAO();
        $this->modelU = new Usuario_DAO();
    }

    public function index() {

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $seguros = $this->modelS->getInsurancesList();
        }
        else
        {
            $currentUser = getCurrentUser();
            $idCorredora = $currentUser['idCorredora'];
            $seguros = $this->modelS->getInsurances($idCorredora);
        }

        $asegurados = $this->modelA->getInsuredList();
        $corredoras = $this->modelCl->getInsuranceBrokersList();
        $regiones = $this->modelR->getRegionList();
        $comunas = $this->modelC->getComunaList();;
        $tipoPolizas = $this->modelTM->getPoliciesList();
        $vendedores = $this->modelU->getSellersList();

        require_once('views/insurance/index.php');
    }

    public function newInsurance() {
        require_once('views/user/newInsurance.php');
    }

    public function createNewInsurance() {
        $rut = isset($_GET['rut']) ? $_GET['rut'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $apellido = isset($_GET['apellido']) ? $_GET['apellido'] : null;
        $giro = isset($_GET['giro']) ? $_GET['giro'] : null;
        $idRegion = isset($_GET['region']) ? $_GET['region'] : null;
        $idComuna = isset($_GET['comuna']) ? $_GET['comuna'] : null;

        $idPerfil = 1; // Perfil Vendedor ??

        return $this->modelS->newInsurance($nombre, $rut, $apellido, $giro, $idCargo, $idPerfil);
    }

    public function insuranceEdit() {
        $idSeguro = isset($_GET['idSeguro']) ? $_GET['idSeguro'] : null;
        $seguro = $this->modelS->getInsurance($idSeguro);

        require_once('views/user/sellerEdit.php');
    }

    public function insuranceEdit2db() {
        $idUsuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $rut = isset($_GET['rut']) ? $_GET['rut'] : null;
        $apellido = isset($_GET['apellido']) ? $_GET['apellido'] : null;
        $giro = isset($_GET['$giro']) ? $_GET['$giro'] : null;
        $idCargo = isset($_GET['cargo']) ? $_GET['cargo'] : null;

        return $this->model->editUser($idUsuario, $nombre, $rut, $apellido, $giro, $idCargo);
    }

    public function deleteUser() {
        $idUsuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : null;

        return $this->modelS->deleteUser($idUsuario);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}