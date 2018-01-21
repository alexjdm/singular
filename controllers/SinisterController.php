<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/Siniestro_DAO.php");
include_once("models/DAO/Seguro_DAO.php");
include_once("models/DAO/Asegurado_DAO.php");
include_once("models/DAO/Certificado_DAO.php");
require "lib/phpmailer/class.phpmailer.php";

class SinisterController {

    public $model;
    public $modelS;
    public $modelA;
    public $modelC;

    public function __construct()
    {
        $this->model = new Siniestro_DAO();
        $this->modelS = new Seguro_DAO();
        $this->modelA = new Asegurado_DAO();
        $this->modelC = new Certificado_DAO();
    }

    public function index() {

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $siniestros = $this->model->getSinistersList();
        }
        else
        {
            $currentUser = getCurrentUser();
            $idCorredora = $currentUser['idCorredora'];
            $siniestros = $this->model->getSinisters($idCorredora);
        }

        $seguros = $this->modelS->getInsurancesList();
        $asegurados = $this->modelA->getInsuredList();
        $certificados = $this->modelC->getCertificatesList();

        require_once('views/sinister/index.php');
    }

    public function newSinister() {
        require_once('views/sinister/newSinister.php');
    }

    public function createNewSinister() {
        $idSeguro = isset($_GET['idSeguro']) ? $_GET['idSeguro'] : null;
        $motivo = isset($_GET['motivo']) ? $_GET['motivo'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $cargo = isset($_GET['cargo']) ? $_GET['cargo'] : null;
        $telefono = isset($_GET['telefono']) ? $_GET['telefono'] : null;
        $correo = isset($_GET['correo']) ? $_GET['correo'] : null;

        return $this->model->newSinister($idSeguro, $motivo, $nombre, $cargo, $telefono, $correo);
    }

    public function sinisterEdit() {
        $idSiniestro = isset($_GET['idSiniestro']) ? $_GET['idSiniestro'] : null;
        $cargo = $this->model->getSinister($idSiniestro);

        require_once('views/sinister/sinisterEdit.php');
    }

    public function sinisterEdit2db() {
        $idSiniestro = isset($_GET['idSiniestro']) ? $_GET['idSiniestro'] : null;
        $idSeguro = isset($_GET['idSeguro']) ? $_GET['idSeguro'] : null;
        $motivo = isset($_GET['motivo']) ? $_GET['motivo'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $cargo = isset($_GET['cargo']) ? $_GET['cargo'] : null;
        $telefono = isset($_GET['telefono']) ? $_GET['telefono'] : null;
        $correo = isset($_GET['correo']) ? $_GET['correo'] : null;

        return $this->model->editSinister($idSiniestro, $idSeguro, $motivo, $nombre, $cargo, $telefono, $correo);
    }

    public function deleteSinister() {
        $idSiniestro = isset($_GET['idSiniestro']) ? $_GET['idSiniestro'] : null;

        return $this->model->deleteSinister($idSiniestro);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}