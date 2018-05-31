<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/Embalaje_DAO.php");
include_once("models/DAO/Poliza_DAO.php");
require "lib/phpmailer/class.phpmailer.php";

class PackingController {

    public $model;
    public $modelP;

    public function __construct()
    {
        $this->model = new Embalaje_DAO();
        $this->modelP = new Poliza_DAO();
    }

    public function index() {
        $polizas = $this->modelP->getPoliciesList();
        $embalajes = $this->model->getPackingsList();
        require_once('views/packing/index.php');
    }

    public function newPacking() {
        $polizas = $this->modelP->getPoliciesList();
        require_once('views/packing/newPacking.php');
    }

    public function createNewPacking() {
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;
        $embalaje = isset($_GET['embalaje']) ? $_GET['embalaje'] : null;

        return $this->model->newPacking($embalaje, $idPoliza);
    }

    public function packingEdit() {
        $idEmbalaje = isset($_GET['idEmbalaje']) ? $_GET['idEmbalaje'] : null;
        $embalaje = $this->model->getPacking($idEmbalaje);
        $polizas = $this->modelP->getPoliciesList();

        require_once('views/packing/packingEdit.php');
    }

    public function packingEdit2db() {
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;
        $idEmbalaje = isset($_GET['idEmbalaje']) ? $_GET['idEmbalaje'] : null;
        $embalaje = isset($_GET['embalaje']) ? $_GET['embalaje'] : null;

        return $this->model->editPacking($idEmbalaje, $embalaje, $idPoliza);
    }

    public function deletePacking() {
        $idEmbalaje = isset($_GET['idEmbalaje']) ? $_GET['idEmbalaje'] : null;

        return $this->model->deletePacking($idEmbalaje);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}