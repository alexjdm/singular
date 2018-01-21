<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/Cargo_DAO.php");
require "lib/phpmailer/class.phpmailer.php";

class JobTitleController {

    public $model;

    public function __construct()
    {
        $this->model = new Cargo_DAO();
    }

    public function index() {
        $cargos = $this->model->getJobTitlesList();
        require_once('views/jobtitle/index.php');
    }

    public function newJobTitle() {
        require_once('views/jobtitle/newJobTitle.php');
    }

    public function createNewJobTitle() {
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;

        return $this->model->newJobTitle($nombre);
    }

    public function jobTitleEdit() {
        $idCargo = isset($_GET['idCargo']) ? $_GET['idCargo'] : null;
        $cargo = $this->model->getJobTitle($idCargo);

        require_once('views/jobtitle/jobTitleEdit.php');
    }

    public function jobTitleEdit2db() {
        $idCargo = isset($_GET['idCargo']) ? $_GET['idCargo'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;

        return $this->model->editJobTitle($idCargo, $nombre);
    }

    public function deleteJobTitle() {
        $idCargo = isset($_GET['idCargo']) ? $_GET['idCargo'] : null;

        return $this->model->deleteJobTitle($idCargo);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}