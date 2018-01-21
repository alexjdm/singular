<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/CertificadoAnulacion_DAO.php");
include_once("models/DAO/Seguro_DAO.php");
include_once("models/DAO/Asegurado_DAO.php");
include_once("models/DAO/Certificado_DAO.php");
include_once("models/DAO/Poliza_DAO.php");
require "lib/phpmailer/class.phpmailer.php";

class CertificateAnnulmentController {

    public $model;
    public $modelS;
    public $modelA;
    public $modelC;
    public $modelP;

    public function __construct()
    {
        $this->model = new CertificadoAnulacion_DAO();
        $this->modelS = new Seguro_DAO();
        $this->modelA = new Asegurado_DAO();
        $this->modelC = new Certificado_DAO();
        $this->modelP = new Poliza_DAO();
    }

    public function index() {

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $certificadoAnulaciones = $this->model->getCertificateAnnulmentsList();
        }
        else
        {
            $currentUser = getCurrentUser();
            $idCorredora = $currentUser['idCorredora'];
            $certificadoAnulaciones = $this->model->getCertificateAnnulments($idCorredora);
        }

        $polizas = $this->modelP->getPoliciesList();
        $asegurados = $this->modelA->getInsuredList();
        $certificados = $this->modelC->getCertificatesList();

        require_once('views/certificateannulment/index.php');
    }

    public function newCertificateAnnulment() {
        $polizas = $this->modelP->getPoliciesList();
        //$seguros = $this->modelS->getInsurancesList();
        //$asegurados = $this->modelA->getInsuredList();
        $certificados = $this->modelC->getCertificatesList();

        require_once('views/certificateannulment/newCertificateAnnulment.php');
    }

    public function createNewCertificateAnnulment() {
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $motivo = isset($_GET['motivo']) ? $_GET['motivo'] : null;

        return $this->model->newCertificateAnnulment($idCertificado, $motivo);
    }

    public function certificateAnnulmentEdit() {
        $idCertificadoAnulacion = isset($_GET['idCertificadoAnulacion']) ? $_GET['idCertificadoAnulacion'] : null;
        $certificadoAnulacion = $this->model->getCertificateAnnulment($idCertificadoAnulacion);
        $certificadoAnular = $this->modelC->getCertificate($certificadoAnulacion['ID_CERTIFICADO']);
        $polizas = $this->modelP->getPoliciesList();
        $certificados = $this->modelC->getCertificatesList();

        require_once('views/certificateannulment/certificateAnnulmentEdit.php');
    }

    public function certificateAnnulmentEdit2db() {
        $idCertificadoAnulacion = isset($_GET['idCertificadoAnulacion']) ? $_GET['idCertificadoAnulacion'] : null;
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $motivo = isset($_GET['motivo']) ? $_GET['motivo'] : null;
        //$idCertificadoReemplazo = isset($_GET['idCertificadoReemplazo']) ? $_GET['idCertificadoReemplazo'] : null;
        //$estado = isset($_GET['estado']) ? $_GET['estado'] : null;

        return $this->model->editCertificateAnnulment($idCertificadoAnulacion, $idCertificado, $motivo);
    }

    public function addReplaceCertificateNumber() {
        $idCertificadoAnulacion = isset($_GET['idCertificadoAnulacion']) ? $_GET['idCertificadoAnulacion'] : null;
        $certificadoAnulacion = $this->model->getCertificateAnnulment($idCertificadoAnulacion);
        $certificadoAnular = $this->modelC->getCertificate($certificadoAnulacion['ID_CERTIFICADO']);

        require_once('views/certificateannulment/addReplaceCertificateNumber.php');
    }

    public function deleteCertificateAnnulment() {
        $idCertificadoAnulacion = isset($_GET['idCertificadoAnulacion']) ? $_GET['idCertificadoAnulacion'] : null;

        return $this->model->deleteCertificateAnnulment($idCertificadoAnulacion);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}