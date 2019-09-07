<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("businesslogic/Company.php");
require "lib/phpmailer/class.phpmailer.php";

class CompanyController {

    public function __construct()
    {
    }

    public function index() {

        $companyBusiness = new Company();
        $companias = $companyBusiness->getCompaniesList();
        require_once('views/company/index.php');
    }

    public function newCompany() {
        require_once('views/company/newCompany.php');
    }

    public function createNewCompany() {
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $tasa = isset($_GET['tasa']) ? $_GET['tasa'] : null;
        $prima_minima = isset($_GET['prima_minima']) ? $_GET['prima_minima'] : null;
        $limite_embarque = isset($_GET['limite_embarque']) ? $_GET['limite_embarque'] : null;
        $tipo_cuenta = isset($_GET['tipo_cuenta']) ? $_GET['tipo_cuenta'] : null;
        $comision = isset($_GET['comision']) ? $_GET['comision'] : null;

        $companyBusiness = new Company();
        $companyBusiness->newCompany($nombre, $tasa, $prima_minima, $limite_embarque, $tipo_cuenta, $comision);
    }

    public function companyEdit() {
        $idCompania = isset($_GET['idCompania']) ? $_GET['idCompania'] : null;

        $companyBusiness = new Company();
        $compania = $companyBusiness->getCompany($idCompania);

        require_once('views/company/companyEdit.php');
    }

    public function companyEdit2db() {
        $idCompania = isset($_GET['idCompania']) ? $_GET['idCompania'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $tasa = isset($_GET['tasa']) ? $_GET['tasa'] : null;
        $prima_minima = isset($_GET['prima_minima']) ? $_GET['prima_minima'] : null;
        $limite_embarque = isset($_GET['limite_embarque']) ? $_GET['limite_embarque'] : null;
        $tipo_cuenta = isset($_GET['tipo_cuenta']) ? $_GET['tipo_cuenta'] : null;
        $comision = isset($_GET['comision']) ? $_GET['comision'] : null;

        $companyBusiness = new Company();
        $companyBusiness->editCompany($idCompania, $nombre, $tasa, $prima_minima, $limite_embarque, $tipo_cuenta, $comision);
    }

    public function deleteCompany() {
        $idCompania = isset($_GET['idCompania']) ? $_GET['idCompania'] : null;

        $companyBusiness = new Company();
        $companyBusiness->deleteCompany($idCompania);
    }


    public function error() {
        require_once('views/error/error.php');
    }

}