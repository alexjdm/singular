<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("businesslogic/Policy.php");
include_once("businesslogic/Company.php");
require "lib/phpmailer/class.phpmailer.php";

class PolicyController {

    public function __construct()
    {
    }

    public function index() {

        $polizaBusiness = new Policy();
        $polizas = $polizaBusiness -> getPolicies();

        require_once('views/policy/index.php');
    }

    public function newPolicy() {
        $companyBusiness = new Company();
        $companias = $companyBusiness->getCompaniesList();

        require_once('views/policy/newPolicy.php');
    }

    public function createNewPolicy() {
        $idCompania = isset($_GET['idCompania']) ? $_GET['idCompania'] : null;
        $tipoPoliza = isset($_GET['tipoPoliza']) ? $_GET['tipoPoliza'] : null;
        $numeroPoliza = isset($_GET['numeroPoliza']) ? $_GET['numeroPoliza'] : null;

        $polizaBusiness = new Policy();
        $polizaBusiness->newPolicy($idCompania, $tipoPoliza, $numeroPoliza);
    }

    public function policyEdit() {
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;

        $polizaBusiness = new Policy();
        $companyBusiness = new Company();

        $poliza = $polizaBusiness->getPolicy($idPoliza);
        $companias = $companyBusiness->getCompaniesList();

        require_once('views/policy/policyEdit.php');
    }

    public function policyEdit2db() {
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;
        $idCompania = isset($_GET['idCompania']) ? $_GET['idCompania'] : null;
        $tipoPoliza = isset($_GET['tipoPoliza']) ? $_GET['tipoPoliza'] : null;
        $numeroPoliza = isset($_GET['numeroPoliza']) ? $_GET['numeroPoliza'] : null;

        $polizaBusiness = new Policy();
        $polizaBusiness->editPolicy($idPoliza, $idCompania, $tipoPoliza, $numeroPoliza);
    }

    public function deletePolicy() {
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;

        $polizaBusiness = new Policy();
        $polizaBusiness->deletePolicy($idPoliza);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}