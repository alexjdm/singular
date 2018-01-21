<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/CertificadoModificacion_DAO.php");
include_once("models/DAO/Poliza_DAO.php");
include_once("models/DAO/Asegurado_DAO.php");
include_once("models/DAO/Certificado_DAO.php");
include_once("models/DAO/Usuario_DAO.php");
include_once("helpers/SessionHelper.php");
require "lib/phpmailer/class.phpmailer.php";

class CertificateModifyController {

    public $model;
    public $modelP;
    public $modelA;
    public $modelC;
    public $modelU;

    public function __construct()
    {
        $this->model = new CertificadoModificacion_DAO();
        $this->modelP = new Poliza_DAO();
        $this->modelA = new Asegurado_DAO();
        $this->modelC = new Certificado_DAO();
        $this->modelU = new Usuario_DAO();
    }

    public function index() {

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $certificadoModificaciones = $this->model->getCertificateModifiesList();
            $certificados = $this->modelC->getCertificatesList();
        }
        else
        {
            $currentUser = getCurrentUser();
            $idCorredora = $currentUser['idCorredora'];
            $certificadoModificaciones = $this->model->getCertificateModifies($idCorredora);
            $usuarios = $this->modelU->getUsers($idCorredora);
            $certificados = $this->modelC->getCertificates($usuarios);
        }

        $polizas = $this->modelP->getPoliciesList();
        $asegurados = $this->modelA->getInsuredList();

        require_once('views/certificatemodify/index.php');
    }

    public function newCertificateModify() {
        $polizas = $this->modelP->getPoliciesList();
        $asegurados = $this->modelA->getInsuredList();

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $certificadoModificaciones = $this->model->getCertificateModifiesList();
            $certificados = $this->modelC->getCertificatesList();
        }
        else
        {
            $currentUser = getCurrentUser();
            $idCorredora = $currentUser['idCorredora'];
            $certificadoModificaciones = $this->model->getCertificateModifies($idCorredora);
            $usuarios = $this->modelU->getUsers($idCorredora);
            $certificados = $this->modelC->getCertificates($usuarios);
        }

        require_once('views/certificatemodify/newCertificateModify.php');
    }

    public function createNewCertificateModify() {
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $dondeDice = isset($_GET['dondeDice']) ? $_GET['dondeDice'] : null;
        $debeDecir = isset($_GET['debeDecir']) ? $_GET['debeDecir'] : null;

        return $this->model->newCertificateModify($idCertificado, $dondeDice, $debeDecir);
    }

    public function certificateModifyEdit() {
        $idCertificadoModificacion = isset($_GET['idCertificadoModificacion']) ? $_GET['idCertificadoModificacion'] : null;
        $certificadoModificacion = $this->model->getCertificateModify($idCertificadoModificacion);
        $polizas = $this->modelP->getPoliciesList();
        $asegurados = $this->modelA->getInsuredList();

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $certificados = $this->modelC->getCertificatesList();
        }
        else
        {
            $currentUser = getCurrentUser();
            $idCorredora = $currentUser['idCorredora'];
            $usuarios = $this->modelU->getUsers($idCorredora);
            $certificados = $this->modelC->getCertificates($usuarios);
        }

        foreach ($certificados as $certificado)
        {
            if($certificado['ID_CERTIFICADO'] == $certificadoModificacion['ID_CERTIFICADO'])
            {
                $certificadoModificado = $certificado;
                break;
            }
        }

        require_once('views/certificatemodify/certificateModifyEdit.php');
    }

    public function certificateModifyEdit2db() {
        $idCertificadoModificacion = isset($_GET['idCertificadoModificacion']) ? $_GET['idCertificadoModificacion'] : null;
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $dondeDice = isset($_GET['dondeDice']) ? $_GET['dondeDice'] : null;
        $debeDecir = isset($_GET['debeDecir']) ? $_GET['debeDecir'] : null;

        return $this->model->editCertificateModify($idCertificadoModificacion, $idCertificado, $dondeDice, $debeDecir);
    }

    public function setCertificateModify() {
        $idCertificadoModificacion = isset($_GET['idCertificadoModificacion']) ? $_GET['idCertificadoModificacion'] : null;
        $estado = isset($_GET['estado']) ? $_GET['estado'] : null;

        return $this->model->setCertificateModify($idCertificadoModificacion, $estado);
    }

    public function deleteCertificateModify() {
        $idCertificadoModificacion = isset($_GET['idCertificadoModificacion']) ? $_GET['idCertificadoModificacion'] : null;

        return $this->model->deleteCertificateModify($idCertificadoModificacion);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}