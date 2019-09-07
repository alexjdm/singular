<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("businesslogic/MediaType.php");
require "lib/phpmailer/class.phpmailer.php";

class MedioTypeController {

    public function __construct()
    {
    }

    public function index() {

        $tipoMedioBusiness = new MediaType();
        $tipoMedios = $tipoMedioBusiness->getMedioTypesList();

        require_once('views/mediotype/index.php');
    }

    public function newMedioType() {
        require_once('views/mediotype/newMedioType.php');
    }

    public function createNewMedioType() {
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;

        $tipoMedioBusiness = new MediaType();
        $tipoMedioBusiness->newMedioType($nombre);
    }

    public function medioTypeEdit() {
        $idMedioType = isset($_GET['idMedioType']) ? $_GET['idMedioType'] : null;

        $tipoMedioBusiness = new MediaType();
        $medioType = $tipoMedioBusiness->getMedioType($idMedioType);

        require_once('views/mediotype/medioTypeEdit.php');
    }

    public function medioTypeEdit2db() {
        $idMedioType = isset($_GET['idMedioType']) ? $_GET['idMedioType'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;

        $tipoMedioBusiness = new MediaType();
        $tipoMedioBusiness->editMedioType($idMedioType, $nombre);
    }

    public function deleteMedioType() {
        $idMedioType = isset($_GET['idMedioType']) ? $_GET['idMedioType'] : null;

        $tipoMedioBusiness = new MediaType();
        $tipoMedioBusiness->deleteMedioType($idMedioType);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}