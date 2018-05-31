<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/TipoMedio_DAO.php");
require "lib/phpmailer/class.phpmailer.php";

class MedioTypeController {

    public $model;

    public function __construct()
    {
        $this->model = new TipoMedio_DAO();
    }

    public function index() {
        $tipoMedios = $this->model->getMedioTypesList();
        require_once('views/mediotype/index.php');
    }

    public function newMedioType() {
        require_once('views/mediotype/newMedioType.php');
    }

    public function createNewMedioType() {
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;

        return $this->model->newMedioType($nombre);
    }

    public function medioTypeEdit() {
        $idMedioType = isset($_GET['idMedioType']) ? $_GET['idMedioType'] : null;
        $medioType = $this->model->getMedioType($idMedioType);

        require_once('views/mediotype/medioTypeEdit.php');
    }

    public function medioTypeEdit2db() {
        $idMedioType = isset($_GET['idMedioType']) ? $_GET['idMedioType'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;

        return $this->model->editMedioType($idMedioType, $nombre);
    }

    public function deleteMedioType() {
        $idMedioType = isset($_GET['idMedioType']) ? $_GET['idMedioType'] : null;

        return $this->model->deleteMedioType($idMedioType);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}