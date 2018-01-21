<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/Poliza_DAO.php");
include_once("models/DAO/Compania_DAO.php");
require "lib/phpmailer/class.phpmailer.php";

class PolicyController {

    public $model;
    public $modelC;

    public function __construct()
    {
        $this->model = new Poliza_DAO();
        $this->modelC = new Compania_DAO();
    }

    public function index() {
        $polizas = $this->model->getPoliciesList();
        $companias = $this->modelC->getCompaniesList();
        require_once('views/policy/index.php');
    }

    public function newPolicy() {
        $companias = $this->modelC->getCompaniesList();

        require_once('views/policy/newPolicy.php');
    }

    public function createNewPolicy() {
        $idCompania = isset($_GET['idCompania']) ? $_GET['idCompania'] : null;
        $tipoPoliza = isset($_GET['tipoPoliza']) ? $_GET['tipoPoliza'] : null;
        $numeroPoliza = isset($_GET['numeroPoliza']) ? $_GET['numeroPoliza'] : null;

        return $this->model->newPolicy($idCompania, $tipoPoliza, $numeroPoliza);
    }

    public function policyEdit() {
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;
        $poliza = $this->model->getPolicy($idPoliza);
        $companias = $this->modelC->getCompaniesList();

        require_once('views/policy/policyEdit.php');
    }

    public function policyEdit2db() {
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;
        $idCompania = isset($_GET['idCompania']) ? $_GET['idCompania'] : null;
        $tipoPoliza = isset($_GET['tipoPoliza']) ? $_GET['tipoPoliza'] : null;
        $numeroPoliza = isset($_GET['numeroPoliza']) ? $_GET['numeroPoliza'] : null;

        return $this->model->editPolicy($idPoliza, $idCompania, $tipoPoliza, $numeroPoliza);
    }

    public function deletePolicy() {
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;

        return $this->model->deletePolicy($idPoliza);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}