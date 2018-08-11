<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/Siniestro_DAO.php");
include_once("models/DAO/Seguro_DAO.php");
include_once("models/DAO/Asegurado_DAO.php");
include_once("models/DAO/Certificado_DAO.php");
include_once("models/DAO/Poliza_DAO.php");
require "lib/phpmailer/class.phpmailer.php";

class SinisterController {

    public $model;
    public $modelS;
    public $modelA;
    public $modelC;
    public $modelP;

    public function __construct()
    {
        $this->model = new Siniestro_DAO();
        $this->modelS = new Seguro_DAO();
        $this->modelA = new Asegurado_DAO();
        $this->modelC = new Certificado_DAO();
        $this->modelP = new Poliza_DAO();
    }

    public function index() {

        $polizas = $this->modelP->getPoliciesList();
        $asegurados = $this->modelA->getInsuredList();
        $certificados = $this->modelC->getCertificatesList();

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

        require_once('views/sinister/index.php');
    }

    public function newSinister() {
        $polizas = $this->modelP->getPoliciesList();
        $asegurados = $this->modelA->getInsuredList();
        $certificados = $this->modelC->getCertificatesList();

        require_once('views/sinister/newSinister.php');
    }

    public function createNewSinister() {
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $motivo = isset($_GET['motivo']) ? $_GET['motivo'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $telefono = isset($_GET['telefono']) ? $_GET['telefono'] : null;
        $correo = isset($_GET['correo']) ? $_GET['correo'] : null;

        $this->model->newSinister($idCertificado, $motivo, $nombre, $telefono, $correo);
    }

    public function sinisterEdit() {
        $idSiniestro = isset($_GET['idSiniestro']) ? $_GET['idSiniestro'] : null;
        $siniestro = $this->model->getSinister($idSiniestro);

        $certificado = $this->modelC->getCertificate($siniestro['ID_CERTIFICADO']);
        $numeroCertificado = $certificado['NUMERO'];

        $polizas = $this->modelP->getPoliciesList();

        require_once('views/sinister/sinisterEdit.php');
    }

    public function sinisterEdit2db() {
        $idSiniestro = isset($_GET['idSiniestro']) ? $_GET['idSiniestro'] : null;
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $motivo = isset($_GET['motivo']) ? $_GET['motivo'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $telefono = isset($_GET['telefono']) ? $_GET['telefono'] : null;
        $correo = isset($_GET['correo']) ? $_GET['correo'] : null;

        $this->model->editSinister($idSiniestro, $idCertificado, $motivo, $nombre, $telefono, $correo);
    }

    public function deleteSinister() {
        $idSiniestro = isset($_GET['idSiniestro']) ? $_GET['idSiniestro'] : null;

        $this->model->deleteSinister($idSiniestro);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}