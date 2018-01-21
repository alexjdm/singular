<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
require_once 'helpers/SessionHelper.php';
include_once("models/DAO/Certificado_DAO.php");
include_once("models/DAO/Asegurado_DAO.php");
include_once("models/DAO/TipoMercaderia_DAO.php");
include_once("models/DAO/MateriaAsegurada_DAO.php");
include_once("models/DAO/Embalaje_DAO.php");
include_once("models/DAO/Poliza_DAO.php");

include_once("BusinessLogic/Notification.php");

require "lib/phpmailer/class.phpmailer.php";

class CertificateRequestController {

    public $model;
    public $modelC;
    public $modelTM;
    public $modelP;
    public $modelMA;
    public $modelE;
    public $modelU;

    public function __construct()
    {
        $this->model = new Certificado_DAO();
        $this->modelA = new Asegurado_DAO();
        $this->modelTM = new TipoMercaderia_DAO();
        $this->modelP = new Poliza_DAO();
        $this->modelMA = new MateriaAsegurada_DAO();
        $this->modelE = new Embalaje_DAO();
        $this->modelU = new Usuario_DAO();
    }

    public function index() {

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

        require_once('views/certificaterequest/index.php');
    }

    public function newCertificateRequest() {
        $asegurados = $this->modelA->getInsuredList();
        $tipoMercaderias = $this->modelTM->getMerchandiseTypesList();
        $polizas = $this->modelP->getPoliciesList();
        $materiasAseguradas = $this->modelMA->getInsuredMattersList();
        $embalajes = $this->modelE->getPackingsList();

        require_once('views/certificaterequest/newCertificateRequest.php');
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
        $estado = 0;
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
            $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones, $estado);
    }

    public function certificateRequestEdit() {
        $idCertificadoSolicitud = isset($_GET['idCertificadoSolicitud']) ? $_GET['idCertificadoSolicitud'] : null;
        $certificadoSolicitud = $this->model->getCertificateRequest($idCertificadoSolicitud);

        $asegurados = $this->modelA->getInsuredList();
        $tipoMercaderias = $this->modelTM->getMerchandiseTypesList();
        $polizas = $this->modelP->getPoliciesList();
        $materiasAseguradas = $this->modelMA->getInsuredMattersList();
        $embalajes = $this->modelE->getPackingsList();

        require_once('views/certificaterequest/certificateRequestEdit.php');
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

    public function deleteCertificateRequest() {
        $idCertificadoSolicitud = isset($_GET['idCertificadoSolicitud']) ? $_GET['idCertificadoSolicitud'] : null;

        return $this->model->deleteCertificateRequest($idCertificadoSolicitud);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}