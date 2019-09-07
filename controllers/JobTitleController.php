<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("businesslogic/JobTitle.php");
require "lib/phpmailer/class.phpmailer.php";

class JobTitleController {

    public function __construct()
    {
    }

    public function index() {

        $corredora = getCurrentInsuranceBroker();
        $cargoBusiness = new JobTitle();
        $cargos = $cargoBusiness->getJobTitlesByInsuranceBrokerId($corredora['id']);

        require_once('views/jobtitle/index.php');
    }

    public function newJobTitle() {
        require_once('views/jobtitle/newJobTitle.php');
    }

    public function createNewJobTitle() {
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;

        $cargoBusiness = new JobTitle();
        $cargoBusiness->newJobTitle($nombre);
    }

    public function jobTitleEdit() {
        $idCargo = isset($_GET['idCargo']) ? $_GET['idCargo'] : null;

        $cargoBusiness = new JobTitle();
        $cargo = $cargoBusiness ->getJobTitle($idCargo);

        require_once('views/jobtitle/jobTitleEdit.php');
    }

    public function jobTitleEdit2db() {
        $idCargo = isset($_GET['idCargo']) ? $_GET['idCargo'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;

        $cargoBusiness = new JobTitle();
        $cargoBusiness->editJobTitle($idCargo, $nombre);
    }

    public function deleteJobTitle() {
        $idCargo = isset($_GET['idCargo']) ? $_GET['idCargo'] : null;

        $cargoBusiness = new JobTitle();
        $cargoBusiness->deleteJobTitle($idCargo);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}