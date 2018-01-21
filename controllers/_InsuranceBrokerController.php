<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/Corredora_DAO.php");
require "lib/phpmailer/class.phpmailer.php";

class _InsuranceBrokerController {

    public $model;

    public function __construct()
    {
        $this->model = new Corredora_DAO();
    }

    public function index() {
        $corredoras = $this->model->getInsuranceBrokersList();
        require_once('views/insurancebroker/index.php');
    }

    public function newInsuranceBroker() {
        require_once('views/insurancebroker/newInsuranceBroker.php');
    }

    public function createNewInsuranceBroker() {
        $rut = isset($_GET['rut']) ? $_GET['rut'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;

        return $this->model->newInsuranceBroker($rut, $nombre);
    }

    public function insuranceBrokerEdit() {
        $idCorredora = isset($_GET['idCorredora']) ? $_GET['idCorredora'] : null;
        $corredora = $this->model->getInsuranceBroker($idCorredora);

        require_once('views/insurancebroker/insuranceBrokerEdit.php');
    }

    public function insuranceBrokerEdit2db() {
        $idCorredora = isset($_GET['idCorredora']) ? $_GET['idCorredora'] : null;
        $rut = isset($_GET['rut']) ? $_GET['rut'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;

        return $this->model->editInsuranceBroker($idCorredora, $rut, $nombre);
    }

    public function deleteInsuranceBroker() {
        $idCorredora = isset($_GET['idCorredora']) ? $_GET['idCorredora'] : null;

        return $this->model->deleteInsuranceBroker($idCorredora);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}