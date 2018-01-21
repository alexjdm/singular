<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/Embalaje_DAO.php");
require "lib/phpmailer/class.phpmailer.php";

class PackingController {

    public $model;

    public function __construct()
    {
        $this->model = new Embalaje_DAO();
    }

    public function index() {
        $embalajes = $this->model->getPackingsList();
        require_once('views/packing/index.php');
    }

    public function newPacking() {
        require_once('views/packing/newPacking.php');
    }

    public function createNewPacking() {
        $embalaje = isset($_GET['embalaje']) ? $_GET['embalaje'] : null;

        return $this->model->newPacking($embalaje);
    }

    public function packingEdit() {
        $idEmbalaje = isset($_GET['idEmbalaje']) ? $_GET['idEmbalaje'] : null;
        $embalaje = $this->model->getPacking($idEmbalaje);

        require_once('views/packing/packingEdit.php');
    }

    public function packingEdit2db() {
        $idEmbalaje = isset($_GET['idEmbalaje']) ? $_GET['idEmbalaje'] : null;
        $embalaje = isset($_GET['embalaje']) ? $_GET['embalaje'] : null;

        return $this->model->editPacking($idEmbalaje, $embalaje);
    }

    public function deletePacking() {
        $idEmbalaje = isset($_GET['idEmbalaje']) ? $_GET['idEmbalaje'] : null;

        return $this->model->deletePacking($idEmbalaje);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}