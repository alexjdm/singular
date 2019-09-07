<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/CertificadoAnulacion_DAO.php");
include_once("models/DAO/Seguro_DAO.php");
include_once("models/DAO/Asegurado_DAO.php");
include_once("models/DAO/Certificado_DAO.php");
require "lib/phpmailer/class.phpmailer.php";

class CertificateAnnulmentControllerDeprecado {

    public $model;
    public $modelS;
    public $modelA;
    public $modelC;

    public function __construct()
    {
        $this->model = new CertificadoAnulacion_DAO();
        $this->modelS = new Seguro_DAO();
        $this->modelA = new Asegurado_DAO();
        $this->modelC = new Certificado_DAO();
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

        $seguros = $this->modelS->getInsurancesList();
        $asegurados = $this->modelA->getInsuredList();
        $certificados = $this->modelC->getCertificatesList();

        require_once('views/certificateannulment_deprecado/index.php');
    }

    public function newCertificateAnnulment() {
        $seguros = $this->modelS->getInsurancesList();
        $asegurados = $this->modelA->getInsuredList();
        $certificados = $this->modelC->getCertificatesList();

        require_once('views/certificateannulment_deprecado/newCertificateAnnulment.php');
    }

    public function createNewCertificateAnnulment() {
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;
        $motivo = isset($_GET['motivo']) ? $_GET['motivo'] : null;
        $estado = isset($_GET['estado']) ? $_GET['estado'] : null;

        return $this->model->newCertificateAnnulment($idCertificado, $idAsegurado, $motivo, $estado);
    }

    public function certificateAnnulmentEdit() {
        $idCertificadoAnulacion = isset($_GET['idCertificadoAnulacion']) ? $_GET['idCertificadoAnulacion'] : null;
        $certificadoAnulacion = $this->model->getCertificateAnnulment($idCertificadoAnulacion);

        require_once('views/certificateannulment_deprecado/certificateAnnulmentEdit.php');
    }

    public function certificateAnnulmentEdit2db() {
        $idCertificadoAnulacion = isset($_GET['idCertificadoAnulacion']) ? $_GET['idCertificadoAnulacion'] : null;
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;
        $motivo = isset($_GET['motivo']) ? $_GET['motivo'] : null;
        $idCertificadoReemplazo = isset($_GET['idCertificadoReemplazo']) ? $_GET['idCertificadoReemplazo'] : null;
        $estado = isset($_GET['estado']) ? $_GET['estado'] : null;

        return $this->model->editCertificateAnnulment($idCertificadoAnulacion, $idCertificado, $idAsegurado, $motivo, $idCertificadoReemplazo, $estado);
    }

    public function deleteCertificateAnnulment() {
        $idCertificadoAnulacion = isset($_GET['idCertificadoAnulacion']) ? $_GET['idCertificadoAnulacion'] : null;

        return $this->model->deleteCertificateAnnulment($idCertificadoAnulacion);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}