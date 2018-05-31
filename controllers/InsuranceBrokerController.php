<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/Corredora_DAO.php");
include_once("models/DAO/Cargo_DAO.php");
include_once("models/DAO/Usuario_DAO.php");
require "lib/phpmailer/class.phpmailer.php";
require_once("businesslogic/InsuranceBroker.php");

class InsuranceBrokerController {

    public $model;
    public $modelC;
    public $modelU;

    public function __construct()
    {
        $this->model = new Corredora_DAO();
        $this->modelC = new Cargo_DAO();
        $this->modelU = new Usuario_DAO();
    }

    public function index() {

        $insuranceBrokerBusiness = new InsuranceBroker();
        $corredoras = $insuranceBrokerBusiness->getClientsForCurrentUser();

        require_once('views/insurancebroker/index.php');
    }

    public function myInsuranceBroker() {
        $currentUser = getCurrentUser();
        $corredora = $this->model->getInsuranceBroker($currentUser['idCorredora']);

        require_once('views/insurancebroker/myInsuranceBroker.php');
    }

    public function newInsuranceBroker() {
        $cargos = $this->modelC->getJobTitlesList();
        $vendedores = $this->modelU->getSellersList();

        require_once('views/insurancebroker/newInsuranceBroker.php');
    }

    public function createNewInsuranceBroker() {
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $rut = isset($_GET['rut']) ? $_GET['rut'] : null;
        $direccion = isset($_GET['direccion']) ? $_GET['direccion'] : null;
        $ciudad = isset($_GET['ciudad']) ? $_GET['ciudad'] : null;
        $telefono = isset($_GET['telefono']) ? $_GET['telefono'] : null;
        $giro = isset($_GET['giro']) ? $_GET['giro'] : null;
        $razonSocial = isset($_GET['razonSocial']) ? $_GET['razonSocial'] : null;
        $tasa = isset($_GET['tasa']) ? $_GET['tasa'] : null;
        $primaMin = isset($_GET['primaMin']) ? $_GET['primaMin'] : null;
        $idVendedor = isset($_GET['idVendedor']) ? $_GET['idVendedor'] : null;

        $insuranceBrokerBusiness = new InsuranceBroker();

        return $insuranceBrokerBusiness ->save($nombre, $rut, $direccion, $ciudad, $telefono, $giro, $razonSocial, $tasa, $primaMin, $idVendedor);

        //return $this->model->newInsuranceBroker($nombre, $rut, $direccion, $ciudad, $telefono, $giro, $razonSocial, $tasa, $primaMin);
    }

    public function insuranceBrokerEdit() {
        $idCorredora = isset($_GET['idCorredora']) ? $_GET['idCorredora'] : null;
        $corredora = $this->model->getInsuranceBroker($idCorredora);

        require_once('views/insurancebroker/insuranceBrokerEdit.php');
    }

    public function insuranceBrokerEdit2db() {
        $idCorredora = isset($_GET['idCorredora']) ? $_GET['idCorredora'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $rut = isset($_GET['rut']) ? $_GET['rut'] : null;
        $direccion = isset($_GET['direccion']) ? $_GET['direccion'] : null;
        $ciudad = isset($_GET['ciudad']) ? $_GET['ciudad'] : null;
        $telefono = isset($_GET['telefono']) ? $_GET['telefono'] : null;
        $giro = isset($_GET['giro']) ? $_GET['giro'] : null;
        $razonSocial = isset($_GET['razonSocial']) ? $_GET['razonSocial'] : null;
        $tasa = isset($_GET['tasa']) ? $_GET['tasa'] : null;
        $primaMin = isset($_GET['primaMin']) ? $_GET['primaMin'] : null;

        return $this->model->editInsuranceBroker($idCorredora, $nombre, $rut, $direccion, $ciudad, $telefono, $giro, $razonSocial, $tasa, $primaMin);
    }

    public function deleteInsuranceBroker() {
        $idCorredora = isset($_GET['idCorredora']) ? $_GET['idCorredora'] : null;

        return $this->model->deleteInsuranceBroker($idCorredora);
    }

    public function usersInsuranceBroker() {
        $idCorredora = isset($_GET['idCorredora']) ? $_GET['idCorredora'] : null;
        $usuarios = $this->modelU->getUsersByIdInsuranceBroker($idCorredora);

        require_once('views/insurancebroker/usersInsuranceBroker.php');
    }

    public function error() {
        require_once('views/error/error.php');
    }

}