<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("businesslogic/Packing.php");
include_once("businesslogic/Policy.php");
require "lib/phpmailer/class.phpmailer.php";

class PackingController {

    public function __construct()
    {
    }

    public function index() {

        $polizaBusiness = new Policy();
        $packingBusiness = new Packing();

        $polizas = $polizaBusiness->getPoliciesList();
        $embalajes = $packingBusiness->getPackingsList();

        require_once('views/packing/index.php');
    }

    public function newPacking() {
        $polizaBusiness = new Policy();
        $polizas = $polizaBusiness->getPoliciesList();
        require_once('views/packing/newPacking.php');
    }

    public function createNewPacking() {
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;
        $embalaje = isset($_GET['Packing']) ? $_GET['Packing'] : null;

        $packingBusiness = new Packing();
        $packingBusiness->newPacking($embalaje, $idPoliza);
    }

    public function packingEdit() {
        $idEmbalaje = isset($_GET['idEmbalaje']) ? $_GET['idEmbalaje'] : null;

        $packingBusiness = new Packing();
        $polizaBusiness = new Policy();

        $embalaje = $packingBusiness->getPacking($idEmbalaje);
        $polizas = $polizaBusiness->getPoliciesList();

        require_once('views/packing/packingEdit.php');
    }

    public function packingEdit2db() {
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;
        $idEmbalaje = isset($_GET['idEmbalaje']) ? $_GET['idEmbalaje'] : null;
        $embalaje = isset($_GET['Packing']) ? $_GET['Packing'] : null;

        $packingBusiness = new Packing();
        $packingBusiness->editPacking($idEmbalaje, $embalaje, $idPoliza);
    }

    public function deletePacking() {
        $idEmbalaje = isset($_GET['idEmbalaje']) ? $_GET['idEmbalaje'] : null;

        $packingBusiness = new Packing();
        $packingBusiness->deletePacking($idEmbalaje);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}