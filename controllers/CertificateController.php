<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
require_once 'helpers/SessionHelper.php';
include_once("models/DAO/Certificado_DAO.php");
include_once("models/DAO/CertificadoModificacion_DAO.php");
include_once("models/DAO/Asegurado_DAO.php");
include_once("models/DAO/TipoMercaderia_DAO.php");
include_once("models/DAO/MateriaAsegurada_DAO.php");
include_once("models/DAO/Embalaje_DAO.php");
include_once("models/DAO/Poliza_DAO.php");
include_once("models/DAO/Usuario_DAO.php");
include_once("models/DAO/Corredora_DAO.php");
include_once ("helpers/SessionHelper.php");
include_once("businesslogic/Notification.php");
include_once("businesslogic/Certificate.php");

require "lib/phpmailer/class.phpmailer.php";

class CertificateController {

    public $model;
    public $modelTM;
    public $modelP;
    public $modelMA;
    public $modelE;
    public $modelU;
    public $modelC;

    public function __construct()
    {
        $this->model = new Certificado_DAO();
        $this->modelCM = new CertificadoModificacion_DAO();
        $this->modelA = new Asegurado_DAO();
        $this->modelTM = new TipoMercaderia_DAO();
        $this->modelP = new Poliza_DAO();
        $this->modelMA = new MateriaAsegurada_DAO();
        $this->modelE = new Embalaje_DAO();
        $this->modelU = new Usuario_DAO();
        $this->modelC = new Corredora_DAO();
    }

    public function index() {

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $certificados = $this->model->getCertificatesList();
        }
        else
        {
            $currentUser = getCurrentUser();
            $idCorredora = $currentUser['idCorredora'];
            $usuarios = $this->modelU->getUsers($idCorredora);
            $certificados = $this->model->getCertificates($usuarios);
        }

        $asegurados = $this->modelA->getInsuredList();
        $usuarios = $this->modelU->getUsersList();

        require_once('views/certificate/index.php');
    }

    public function newCertificate() {
        $certificadoSolicitudes = $this->modelCS->getCertificateRequestsList();

        require_once('views/certificate/newCertificate.php');
    }

    public function addCertificate() {
        $idCertificadoSolicitud = isset($_GET['idCertificadoSolicitud']) ? $_GET['idCertificadoSolicitud'] : null;
        $certificadoSolicitud = $this->model->getCertificateRequest($idCertificadoSolicitud);

        require_once('views/certificate/addCertificate.php');
    }

    public function createNewCertificate() {

        if(!empty($_FILES)) {
            if(is_uploaded_file($_FILES['certificado']['tmp_name'])) {
                /*$dirpath = realpath(dirname(getcwd()));
                $dirpath = realpath(dirname($_SERVER['PHP_SELF']));*/
                $dirpath = dirname($_SERVER['SCRIPT_FILENAME']);

                $idCertificadoSolicitud = isset($_POST['idCertificadoSolicitud']) ? $_POST['idCertificadoSolicitud'] : null;
                $numeroCertificado = isset($_POST['numeroCertificado']) ? $_POST['numeroCertificado'] : null;
                $certificateBusiness = new Certificate();
                $numeroPoliza = $certificateBusiness->getPolicyNumber($idCertificadoSolicitud); //En realidad el idCertificadoSolicitud = idCertificado
                //$randomNumber = rand();

                $sourcePath = $_FILES['certificado']['tmp_name'];
                $targetPath = "upload/" . $numeroPoliza . '-' . $numeroCertificado . '-' . $_FILES['certificado']['name'];

                $ubicacion = $targetPath;
                $formato = pathinfo($targetPath, PATHINFO_EXTENSION);

                if(move_uploaded_file($sourcePath, $dirpath . '/' . $targetPath)) {

                    //$numero = $this->model->getLastNumber() + 1;

                    //Enviar correo de notificación al solicitante del certificado
                    $currentUser = getCurrentUser();
                    Notification::NotificarCertificado($currentUser, $idCertificadoSolicitud);

                    return $this->model->addCertificate($idCertificadoSolicitud, $numeroCertificado, $formato, $ubicacion);
                }
                else
                {
                    $status  = "error";
                    $message = "Error, por favor intente nuevamente.";

                    $data = array(
                        'status'  => $status,
                        'message' => $message
                    );

                    echo json_encode($data);
                }
            }
        }
    }

    public function changeCertificate() {
        $idCertificadoModificacion = isset($_GET['idCertificadoModificacion']) ? $_GET['idCertificadoModificacion'] : null;
        $certificadoModificacion = $this->modelCM->getCertificateModify($idCertificadoModificacion);
        $certificado = $this->model->getCertificate($certificadoModificacion['ID_CERTIFICADO']);

        require_once('views/certificate/changeCertificate.php');
    }

    public function changeNewCertificate() {

        if(!empty($_FILES)) {
            if(is_uploaded_file($_FILES['certificado']['tmp_name'])) {
                /*$dirpath = realpath(dirname(getcwd()));
                $dirpath = realpath(dirname($_SERVER['PHP_SELF']));*/
                $dirpath = dirname($_SERVER['SCRIPT_FILENAME']);

                $idCertificadoModificacion = isset($_POST['idCertificadoModificacion']) ? $_POST['idCertificadoModificacion'] : null;
                $idCertificado = isset($_POST['idCertificado']) ? $_POST['idCertificado'] : null;
                $numeroCertificado = isset($_POST['numeroCertificado']) ? $_POST['numeroCertificado'] : null;
                $certificateBusiness = new Certificate();
                $numeroPoliza = $certificateBusiness->getPolicyNumber($idCertificado);
                //$randomNumber = rand();

                $sourcePath = $_FILES['certificado']['tmp_name'];
                $targetPath = "upload/" . $numeroPoliza . '_' . $numeroCertificado . '_' . $_FILES['certificado']['name'];

                $ubicacion = $targetPath;
                $formato = pathinfo($targetPath, PATHINFO_EXTENSION);

                if(move_uploaded_file($sourcePath, $dirpath . '/' . $targetPath)) {

                    //$numero = $this->model->getLastNumber() + 1;

                    //Enviar correo de notificación al solicitante del certificado
                    $currentUser = getCurrentUser();
                    Notification::NotificarCertificado($currentUser, $idCertificado);

                    $this->modelCM->setCertificateModify($idCertificadoModificacion, true);

                    return $this->model->changeCertificate($idCertificado, $numeroCertificado, $formato, $ubicacion);
                }
                else
                {
                    $status  = "error";
                    $message = "Error, por favor intente nuevamente.";

                    $data = array(
                        'status'  => $status,
                        'message' => $message
                    );

                    echo json_encode($data);
                }
            }
        }
    }

    public function viewCertificate() {
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $certificado = $this->model->getCertificate($idCertificado);

        require_once('views/certificate/viewCertificate.php');
    }

    public function certificateEdit() {
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $certificadoSolicitud = $this->model->getCertificate($idCertificado);

        $asegurados = $this->modelA->getInsuredList();
        $tipoMercaderias = $this->modelTM->getMerchandiseTypesList();
        $polizas = $this->modelP->getPoliciesList();
        $materiasAseguradas = $this->modelMA->getInsuredMattersList();
        $embalajes = $this->modelE->getPackingsList();

        require_once('views/certificate/certificateEdit.php');
    }

    public function certificateEdit2db() {

        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;
        $idTipoMercaderia = isset($_GET['idTipoMercaderia']) ? $_GET['idTipoMercaderia'] : null;
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;
        $aFavorDe = isset($_GET['aFavorDe']) ? $_GET['aFavorDe'] : null;
        $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;
        $origen = isset($_GET['origen']) ? $_GET['origen'] : null;


        return $this->model->editCertificate($idCertificado, $idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo, $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloCamion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada, $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones);
    }

    public function deleteCertificate() {
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;

        return $this->model->deleteCertificate($idCertificado);
    }

    public function request() {

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $usuarios = $this->modelU->getUsersList();
            $certificadoSolicitudes = $this->model->getCertificateRequestsList();
        }
        else
        {
            $currentUser = getCurrentUser();
            $idCorredora = $currentUser['idCorredora'];
            $certificadoSolicitudes = $this->model->getCertificateRequests($idCorredora);
        }

        $tipoMercaderias = $this->modelTM->getMerchandiseTypesList();
        $polizas = $this->modelP->getPoliciesList();
        $materiasAseguradas = $this->modelMA->getInsuredMattersList();
        $embalajes = $this->modelE->getPackingsList();
        $asegurados = $this->modelA->getInsuredList();

        require_once('views/certificate/request.php');
    }

    public function newCertificateRequest() {
        $asegurados = $this->modelA->getInsuredList();
        $tipoMercaderias = $this->modelTM->getMerchandiseTypesList();
        $polizas = $this->modelP->getPoliciesList();
        $materiasAseguradas = $this->modelMA->getInsuredMattersList();
        $embalajes = $this->modelE->getPackingsList();
        $currentCorredora = getCurrentInsuranceBroker();
        $corredora = $this->modelC->getInsuranceBroker($currentCorredora['id']);

        require_once('views/certificate/newCertificateRequest.php');
    }

    public function createNewCertificateRequest() {

        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;
        $idTipoMercaderia = isset($_GET['idTipoMercaderia']) ? $_GET['idTipoMercaderia'] : null;
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;
        $aFavorDe = isset($_GET['aFavorDe']) ? $_GET['aFavorDe'] : null;
        $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;
        $origen = isset($_GET['origen']) ? $_GET['origen'] : null;
        $destino = isset($_GET['destino']) ? $_GET['destino'] : null;
        $via = isset($_GET['via']) ? $_GET['via'] : null;
        $fechaEmbarque = isset($_GET['fechaEmbarque']) ? $_GET['fechaEmbarque'] : null;
        $fechaEmbarque = date("Y-m-d", strtotime($fechaEmbarque));
        $transportista = isset($_GET['transportista']) ? $_GET['transportista'] : null;
        $naveVueloCamion = isset($_GET['naveVueloCamion']) ? $_GET['naveVueloCamion'] : null;
        $blAwbCrt = isset($_GET['blAwbCrt']) ? $_GET['blAwbCrt'] : null;
        $referenciaDespacho = isset($_GET['referenciaDespacho']) ? $_GET['referenciaDespacho'] : null;
        $idMateriaAsegurada = isset($_GET['idMateriaAsegurada']) ? $_GET['idMateriaAsegurada'] : null;
        $detalleMercaderia = isset($_GET['detalleMercaderia']) ? $_GET['detalleMercaderia'] : null;
        $idEmbalaje = isset($_GET['idEmbalaje']) ? $_GET['idEmbalaje'] : null;
        $montoAseguradoCIF = isset($_GET['montoAseguradoCIF']) ? $_GET['montoAseguradoCIF'] : null;
        $tasa = isset($_GET['tasa']) ? $_GET['tasa'] : null;
        $primaMin = isset($_GET['primaMin']) ? $_GET['primaMin'] : null;
        $primaSeguro = isset($_GET['primaSeguro']) ? $_GET['primaSeguro'] : null;
        $observaciones = isset($_GET['observaciones']) ? $_GET['observaciones'] : null;

        //Enviar correo de notificación a los superAdmin
        $estadoSolicitud = 0;
        $estadoAnulacion = -1;
        $currentUser = getCurrentUser();
        $idUsuarioSolicitante = $currentUser['id'];
        if($currentUser['idPerfil'] == -1)
        {
            $estado = 1;
        }
        else
        {
            Notification::NotificarCertificadoSolicitud($currentUser, $idAsegurado, $idTipoMercaderia, $idPoliza);
        }

        return $this->model->newCertificateRequest($idUsuarioSolicitante, $idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo,
            $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloCamion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada,
            $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones, $estadoSolicitud, $estadoAnulacion);
    }

    public function certificateRequestEdit() {
        $idCertificadoSolicitud = isset($_GET['idCertificadoSolicitud']) ? $_GET['idCertificadoSolicitud'] : null;
        $certificadoSolicitud = $this->model->getCertificateRequest($idCertificadoSolicitud);

        $asegurados = $this->modelA->getInsuredList();
        $tipoMercaderias = $this->modelTM->getMerchandiseTypesList();
        $polizas = $this->modelP->getPoliciesList();
        $materiasAseguradas = $this->modelMA->getInsuredMattersList();
        $embalajes = $this->modelE->getPackingsList();

        require_once('views/certificate/certificateRequestEdit.php');
    }

    public function certificateRequestEdit2db() {

        $idCertificadoSolicitud = isset($_GET['idCertificadoSolicitud']) ? $_GET['idCertificadoSolicitud'] : null;
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;
        $idTipoMercaderia = isset($_GET['idTipoMercaderia']) ? $_GET['idTipoMercaderia'] : null;
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;
        $aFavorDe = isset($_GET['aFavorDe']) ? $_GET['aFavorDe'] : null;
        $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;
        $origen = isset($_GET['origen']) ? $_GET['origen'] : null;
        $destino = isset($_GET['destino']) ? $_GET['destino'] : null;
        $via = isset($_GET['via']) ? $_GET['via'] : null;
        $fechaEmbarque = isset($_GET['fechaEmbarque']) ? $_GET['fechaEmbarque'] : null;
        $fechaEmbarque = date("Y-m-d", strtotime($fechaEmbarque));
        $transportista = isset($_GET['transportista']) ? $_GET['transportista'] : null;
        $naveVueloCamion = isset($_GET['naveVueloCamion']) ? $_GET['naveVueloCamion'] : null;
        $blAwbCrt = isset($_GET['blAwbCrt']) ? $_GET['blAwbCrt'] : null;
        $referenciaDespacho = isset($_GET['referenciaDespacho']) ? $_GET['referenciaDespacho'] : null;
        $idMateriaAsegurada = isset($_GET['idMateriaAsegurada']) ? $_GET['idMateriaAsegurada'] : null;
        $detalleMercaderia = isset($_GET['detalleMercaderia']) ? $_GET['detalleMercaderia'] : null;
        $idEmbalaje = isset($_GET['idEmbalaje']) ? $_GET['idEmbalaje'] : null;
        $montoAseguradoCIF = isset($_GET['montoAseguradoCIF']) ? $_GET['montoAseguradoCIF'] : null;
        $tasa = isset($_GET['tasa']) ? $_GET['tasa'] : null;
        $primaMin = isset($_GET['primaMin']) ? $_GET['primaMin'] : null;
        $primaSeguro = isset($_GET['primaSeguro']) ? $_GET['primaSeguro'] : null;
        $observaciones = isset($_GET['observaciones']) ? $_GET['observaciones'] : null;


        return $this->model->editCertificateRequest($idCertificadoSolicitud, $idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo, $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloCamion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada, $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones);
    }

    public function annulments() {

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
        $certificados = $this->model->getCertificatesList();

        require_once('views/certificate/annulments.php');
    }

    public function newCertificateAnnulment() {
        $polizas = $this->modelP->getPoliciesList();
        //$seguros = $this->modelS->getInsurancesList();
        //$asegurados = $this->modelA->getInsuredList();
        //$certificados = $this->model->getCertificatesList();

        require_once('views/certificate/newCertificateAnnulment.php');
    }

    public function createNewCertificateAnnulment() {
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $motivo = isset($_GET['motivo']) ? $_GET['motivo'] : null;

        return $this->model->newCertificateAnnulment($idCertificado, $motivo);
    }

    public function certificateAnnulmentEdit() {
        $idCertificadoAnulacion = isset($_GET['idCertificadoAnulacion']) ? $_GET['idCertificadoAnulacion'] : null;
        //$certificadoAnulacion = $this->model->getCertificateAnnulment($idCertificadoAnulacion);
        $certificadoAnular = $this->model->getCertificate($idCertificadoAnulacion);
        $polizas = $this->modelP->getPoliciesList();
        //$certificados = $this->model->getCertificatesList();

        require_once('views/certificate/certificateAnnulmentEdit.php');
    }

    public function certificateAnnulmentEdit2db() {
        //$idCertificadoAnulacion = isset($_GET['idCertificadoAnulacion']) ? $_GET['idCertificadoAnulacion'] : null;
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $motivo = isset($_GET['motivo']) ? $_GET['motivo'] : null;
        //$idCertificadoReemplazo = isset($_GET['idCertificadoReemplazo']) ? $_GET['idCertificadoReemplazo'] : null;
        //$estado = isset($_GET['estado']) ? $_GET['estado'] : null;

        return $this->model->editCertificateAnnulment($idCertificado, $motivo);
    }

    public function addReplaceCertificateNumber() {
        $idCertificadoAnulacion = isset($_GET['idCertificadoAnulacion']) ? $_GET['idCertificadoAnulacion'] : null;
        $certificadoAnulacion = $this->model->getCertificateAnnulment($idCertificadoAnulacion);

        $isSuperAdmin = isSuperAdmin();
        $certificados = array();
        $certificados1 = array();
        if($isSuperAdmin)
        {
            $certificados1 = $this->model->getCertificatesList();
        }
        else
        {
            $currentUser = getCurrentUser();
            $idCorredora = $currentUser['idCorredora'];
            $usuarios = $this->modelU->getUsers($idCorredora);
            $certificados1 = $this->model->getCertificates($usuarios);
        }

        foreach ($certificados1 as $certificado):
            if($certificadoAnulacion['ID_CERTIFICADO'] != $certificado['ID_CERTIFICADO']):
                array_push($certificados, $certificado);
            endif;
        endforeach;

        require_once('views/certificate/addReplaceCertificateNumber.php');
    }

    public function addReplaceCertificateNumber2db() {
        $idCertificadoAnulacion = isset($_GET['idCertificadoAnulacion']) ? $_GET['idCertificadoAnulacion'] : null;
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;

        return $this->model->addReplaceCertificateNumber2db($idCertificadoAnulacion, $idCertificado);
    }

    public function setCertificateAnnulment() {
        $idCertificadoAnulacion = isset($_GET['idCertificadoAnulacion']) ? $_GET['idCertificadoAnulacion'] : null;
        $estado = isset($_GET['estado']) ? $_GET['estado'] : null;

        return $this->model->setCertificateAnnulment($idCertificadoAnulacion, $estado);
    }

    public function searchCertificate()
    {
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;
        $numero = isset($_GET['numero']) ? $_GET['numero'] : null;

        $certificado = $this->model->searchCertificate($idPoliza, $numero);

        if($certificado != null)
        {
            $certificado['FECHA_EMBARQUE'] = FormatearFechaSpa($certificado['FECHA_EMBARQUE']);
            $respuesta = array($certificado);
            $status = "success";
        }
        else {
            $status = "error";
            $respuesta = "No se ha encontrado ningún certificado con ese número asociado a la póliza seleccionada.";
        }

        $data = array(
            'status'  => $status,
            'message' => $respuesta
        );
        echo json_encode($data);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}