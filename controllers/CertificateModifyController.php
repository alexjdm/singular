<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("helpers/SessionHelper.php");
include_once("businesslogic/Certificate.php");
include_once("businesslogic/Policy.php");
include_once("businesslogic/Insured.php");
include_once("businesslogic/Usuario.php");
require "lib/phpmailer/class.phpmailer.php";

class CertificateModifyController {

    public function __construct()
    {
    }

    public function index() {

        $certificadoBusiness = new Certificate();
        $certificadosVM = $certificadoBusiness -> getCertificateModifiesVM();

        require_once('views/certificatemodify/index.php');
    }

    public function newCertificateModify() {

        $cerficateBusiness = new Certificate();
        $polizaBusiness = new Policy();
        $aseguradoBusiness = new Insured();

        $polizas = $polizaBusiness->getPoliciesList();
        $asegurados = $aseguradoBusiness->getInsuredList();
        $certificadoModificaciones = $cerficateBusiness -> getCertificateModifiesList();

        require_once('views/certificatemodify/newCertificateModify.php');
    }

    public function createNewCertificateModify() {
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $dondeDice = isset($_GET['dondeDice']) ? $_GET['dondeDice'] : null;
        $debeDecir = isset($_GET['debeDecir']) ? $_GET['debeDecir'] : null;

        $cerficateBusiness = new Certificate();
        $cerficateBusiness->newCertificateModify($idCertificado, $dondeDice, $debeDecir);
    }

    public function certificateModifyEdit() {
        $idCertificadoModificacion = isset($_GET['idCertificadoModificacion']) ? $_GET['idCertificadoModificacion'] : null;

        $cerficateBusiness = new Certificate();
        $polizaBusiness = new Policy();
        $aseguradoBusiness = new Insured();

        $certificadoModificacion = $cerficateBusiness->getCertificateModify($idCertificadoModificacion);
        $polizas = $polizaBusiness->getPoliciesList();
        $asegurados = $aseguradoBusiness->getInsuredList();
        $certificados = $cerficateBusiness->getCertificatesList();

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

        $cerficateBusiness = new Certificate();
        $cerficateBusiness->editCertificateModify($idCertificadoModificacion, $idCertificado, $dondeDice, $debeDecir);
    }

    public function setCertificateModify() {
        $idCertificadoModificacion = isset($_GET['idCertificadoModificacion']) ? $_GET['idCertificadoModificacion'] : null;
        $estado = isset($_GET['estado']) ? $_GET['estado'] : null;

        $cerficateBusiness = new Certificate();
        $cerficateBusiness->setCertificateModify($idCertificadoModificacion, $estado);
    }

    public function deleteCertificateModify() {
        $idCertificadoModificacion = isset($_GET['idCertificadoModificacion']) ? $_GET['idCertificadoModificacion'] : null;

        $cerficateBusiness = new Certificate();
        $cerficateBusiness->deleteCertificateModify($idCertificadoModificacion);
    }



    public function error() {
        require_once('views/error/error.php');
    }

}