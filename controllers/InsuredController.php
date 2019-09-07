<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("helpers/SessionHelper.php");
include_once("businesslogic/Notification.php");
include_once("businesslogic/Insured.php");

require "lib/phpmailer/class.phpmailer.php";

class InsuredController {

    public function __construct()
    {
    }

    public function index() {

        $insuredBusiness = new Insured();
        $aseguradosVM = $insuredBusiness->getInsuredList();

        require_once('views/insured/index.php');
    }

    public function newInsured() {

        $regionBusiness = new Region();
        $comunaBusiness = new Comuna();

        $regiones = $regionBusiness->getRegionList();
        $comunas = $comunaBusiness->getComunaList();

        require_once('views/insured/newInsured.php');
    }

    public function createNewInsured() {
        $rut = isset($_GET['rut']) ? $_GET['rut'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $giro = isset($_GET['giro']) ? $_GET['giro'] : null;
        $idRegion = isset($_GET['idRegion']) ? $_GET['idRegion'] : null;
        $idComuna = isset($_GET['idComuna']) ? $_GET['idComuna'] : null;
        $direccion = isset($_GET['direccion']) ? $_GET['direccion'] : null;

        // Si es SuperAdmin queda validado sino queda a la espera de validacion
        $estado = 0;
        $currentUser = getCurrentUser();
        $idUsuario = $currentUser['id'];
        if($currentUser['idPerfil'] == -1)
        {
            $estado = 1;
        }
        else
        {
            Notification::NotificarAsegurado($currentUser, $nombre, $giro, $idRegion, $idComuna, $direccion);
        }

        $insuredBusiness = new Insured();
        $insuredBusiness->newInsured($idUsuario, $rut, $nombre, $giro, $idRegion, $idComuna, $direccion, $estado);
    }

    public function insuredEdit() {
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;

        $insuredBusiness = new Insured();
        $regionBusiness = new Region();
        $comunaBusiness = new Comuna();

        $asegurado = $insuredBusiness->getInsured($idAsegurado);
        $regiones = $regionBusiness->getRegionList();
        $comunas = $comunaBusiness->getComunaList();

        require_once('views/insured/insuredEdit.php');
    }

    public function insuredEdit2db() {
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;
        $rut = isset($_GET['rut']) ? $_GET['rut'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $giro = isset($_GET['giro']) ? $_GET['giro'] : null;
        $idRegion = isset($_GET['idRegion']) ? $_GET['idRegion'] : null;
        $idComuna = isset($_GET['idComuna']) ? $_GET['idComuna'] : null;
        $direccion = isset($_GET['direccion']) ? $_GET['direccion'] : null;

        $insuredBusiness = new Insured();
        $insuredBusiness->editInsured($idAsegurado, $rut, $nombre, $giro, $idRegion, $idComuna, $direccion);
    }

    public function deleteInsured() {
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;

        $insuredBusiness = new Insured();
        $insuredBusiness->deleteInsured($idAsegurado);
    }

    public function validateInsured() {
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;

        $insuredBusiness = new Insured();
        $insuredBusiness->validateInsured($idAsegurado);
    }

    public function invalidateInsured() {
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;

        $insuredBusiness = new Insured();
        $insuredBusiness->invalidateInsured($idAsegurado);
    }

    public function approveAllInsured() {

        $insuredBusiness = new Insured();
        $insuredBusiness->approveAllInsured();
    }

    public function error() {
        require_once('views/error/error.php');
    }

}