<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
require_once 'helpers/SessionHelper.php';
include_once("businesslogic/Insured.php");
include_once("businesslogic/MerchandiseType.php");
include_once("businesslogic/InsuredMatter.php");
include_once("businesslogic/Packing.php");
include_once("businesslogic/Policy.php");
include_once("businesslogic/Usuario.php");
include_once("businesslogic/InsuranceBroker.php");
include_once("businesslogic/Notification.php");
include_once("businesslogic/Certificate.php");
include_once("businesslogic/Insured.php");

require "lib/phpmailer/class.phpmailer.php";

class CertificateController {

    public function __construct()
    {
    }

    public function index() {

        $certificadoBusiness = new Certificate();
        $certificadosVM = $certificadoBusiness -> getCertificatesListVM();

        require_once('views/certificate/index.php');
    }

    public function newCertificate() {

        $certificadoBusiness = new Certificate();
        $certificadoSolicitudes = $certificadoBusiness -> getCertificateRequestsList();

        require_once('views/certificate/newCertificate.php');
    }

    public function addCertificate() {
        $idCertificadoSolicitud = isset($_GET['idCertificadoSolicitud']) ? $_GET['idCertificadoSolicitud'] : null;

        $certificadoBusiness = new Certificate();
        $certificadoSolicitud = $certificadoBusiness->getCertificateRequest($idCertificadoSolicitud);

        require_once('views/certificate/addCertificate.php');
    }

    public function createNewCertificate() {

        if(!empty($_FILES)) {
            if(is_uploaded_file($_FILES['certificado']['tmp_name'])) {
                /*$dirpath = realpath(dirname(getcwd()));
                $dirpath = realpath(dirname($_SERVER['PHP_SELF']));*/
                $dirpath = dirname($_SERVER['SCRIPT_FILENAME']);

                $idCertificadoSolicitud = isset($_POST['idCertificadoSolicitud']) ? $_POST['idCertificadoSolicitud'] : null;
                //$numeroCertificado = isset($_POST['numeroCertificado']) ? $_POST['numeroCertificado'] : null;
                $certificateBusiness = new Certificate();
                $numeroPoliza = $certificateBusiness->getPolicyNumber($idCertificadoSolicitud); //En realidad el idCertificadoSolicitud = idCertificado
                //$randomNumber = rand();

                $numeroPolizaArchivo = GetPoliceNumber($_FILES['certificado']['name']);
                $numeroCertificado = GetCertificateNumber($_FILES['certificado']['name']);

                if($numeroPolizaArchivo != $numeroPoliza)
                {
                    $status  = "error";
                    $message = "El número de póliza ingresado en el archivo no es igual al ingresado en la solicitud.";

                    $data = array(
                        'status'  => $status,
                        'message' => $message
                    );

                    echo json_encode($data);
                }
                else
                {
                    if($numeroCertificado > 0)
                    {
                        $sourcePath = $_FILES['certificado']['tmp_name'];
                        $targetPath = "upload/Certificado " . $numeroCertificado . '-' . $numeroPoliza . '-' . $_FILES['certificado']['name'];
                        // TODO: Verificar si se sube con el mismo nombre

                        $ubicacion = $targetPath;
                        $formato = pathinfo($targetPath, PATHINFO_EXTENSION);

                        if(move_uploaded_file($sourcePath, $dirpath . '/' . $targetPath)) {

                            //$numero = $this->model->getLastNumber() + 1;

                            //Enviar correo de notificación al solicitante del certificado
                            $currentUser = getCurrentUser();
                            $notificationBusiness = new Notification();
                            $notificationBusiness->NotificarCertificado($currentUser, $idCertificadoSolicitud);

                            $certificadoBusiness = new Certificate();
                            $certificadoBusiness->addCertificate($idCertificadoSolicitud, $numeroCertificado, $formato, $ubicacion);
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
                    else
                    {
                        $status  = "error";
                        $message = "El número de certificado ingresado no es mayor a cero.";

                        $data = array(
                            'status'  => $status,
                            'message' => $message
                        );

                        echo json_encode($data);
                    }
                }

            }
        }
    }

    public function changeCertificate() {
        $idCertificadoModificacion = isset($_GET['idCertificadoModificacion']) ? $_GET['idCertificadoModificacion'] : null;

        $certificadoBusiness = new Certificate();
        $certificadoModificacion = $certificadoBusiness->getCertificateModify($idCertificadoModificacion);
        $certificado = $certificadoBusiness->getCertificate($certificadoModificacion['ID_CERTIFICADO']);

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
                $targetPath = "upload/Certificado " . $numeroCertificado . '-' . $numeroPoliza . '-' . $_FILES['certificado']['name'];
                // TODO: Verificar si se sube con el mismo nombre

                $ubicacion = $targetPath;
                $formato = pathinfo($targetPath, PATHINFO_EXTENSION);

                if(move_uploaded_file($sourcePath, $dirpath . '/' . $targetPath)) {

                    //$numero = $this->model->getLastNumber() + 1;

                    //Enviar correo de notificación al solicitante del certificado
                    $currentUser = getCurrentUser();
                    Notification::NotificarCertificado($currentUser, $idCertificado);

                    $certificadoBusiness = new Certificate();
                    $certificadoBusiness->setCertificateModify($idCertificadoModificacion, true);

                    $certificadoBusiness->changeCertificate($idCertificado, $numeroCertificado, $formato, $ubicacion);
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

        $certificadoBusiness = new Certificate();
        $certificado = $certificadoBusiness->getCertificate($idCertificado);

        require_once('views/certificate/viewCertificate.php');
    }

    public function certificateEdit() {
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;

        $certificadoBusiness = new Certificate();
        $aseguradosBusiness = new Insured();
        $tipoMercaderiaBusiness = new MerchandiseType();
        $polizaBusiness = new Policy();
        $materiaAseguradaBusiness = new InsuredMatter();
        $embalajeBusiness = new Packing();

        $certificadoSolicitud = $certificadoBusiness->getCertificate($idCertificado);
        $asegurados = $aseguradosBusiness->getInsuredList();
        $tipoMercaderias = $tipoMercaderiaBusiness->getMerchandiseTypesList();
        $polizas = $polizaBusiness->getPoliciesList();
        $materiasAseguradas = $materiaAseguradaBusiness->getInsuredMattersList();
        $embalajes = $embalajeBusiness->getPackingsList();

        require_once('views/certificate/certificateEdit.php');
    }

    public function certificateEdit2db() {

        /*$idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;
        $idTipoMercaderia = isset($_GET['idTipoMercaderia']) ? $_GET['idTipoMercaderia'] : null;
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;
        $aFavorDe = isset($_GET['aFavorDe']) ? $_GET['aFavorDe'] : null;
        $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;
        $origen = isset($_GET['origen']) ? $_GET['origen'] : null;

        $certificadoBusiness = new Certificate();
        $certificadoBusiness->editCertificate($idCertificado, $idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo, $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloCamion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada, $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones);*/
    }

    public function deleteCertificate() {
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;

        $certificadoBusiness = new Certificate();
        $certificadoBusiness->deleteCertificate($idCertificado);
    }

    public function request() {

        $certificadoBusiness = new Certificate();
        $certificadosVM = $certificadoBusiness -> getRequestList();

        require_once('views/certificate/request.php');
    }

    public function newCertificateRequest() {

        $aseguradosBusiness = new Insured();
        $tipoMercaderiaBusiness = new MerchandiseType();
        $polizaBusiness = new Policy();
        $materiaAseguradaBusiness = new InsuredMatter();
        $embalajeBusiness = new Packing();
        $corredoraBusiness = new InsuranceBroker();

        $asegurados = $aseguradosBusiness->getAllInsured();
        //$asegurados = $aseguradosBusiness->getInsuredList();
        $tipoMercaderias = $tipoMercaderiaBusiness->getMerchandiseTypesList();
        $polizas = $polizaBusiness->getValidatePoliciesList();
        $materiasAseguradas = $materiaAseguradaBusiness->getInsuredMattersList();
        $embalajes = $embalajeBusiness->getPackingsList();
        $currentCorredora = getCurrentInsuranceBroker();
        $corredora = $corredoraBusiness->getInsuranceBroker($currentCorredora['id']);

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
        $habilitado = 1;

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
            $notificationBusiness = new Notification();
            $notificationBusiness -> NotificarCertificadoSolicitud($currentUser, $idAsegurado, $idTipoMercaderia, $idPoliza);
        }

        $certificateBusiness = new Certificate();
        $certificateBusiness->newCertificateRequest($idUsuarioSolicitante, $idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo,
            $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloCamion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada,
            $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones, $estadoSolicitud, $estadoAnulacion, $habilitado);
    }

    public function certificateRequestEdit() {
        $idCertificadoSolicitud = isset($_GET['idCertificadoSolicitud']) ? $_GET['idCertificadoSolicitud'] : null;

        $certificadoBusiness = new Certificate();
        $aseguradosBusiness = new Insured();
        $tipoMercaderiaBusiness = new MerchandiseType();
        $polizaBusiness = new Policy();
        $materiaAseguradaBusiness = new InsuredMatter();
        $embalajeBusiness = new Packing();

        $certificadoSolicitud = $certificadoBusiness->getCertificateRequest($idCertificadoSolicitud);
        $asegurados = $aseguradosBusiness->getInsuredList();
        $tipoMercaderias = $tipoMercaderiaBusiness->getMerchandiseTypesList();
        $polizas = $polizaBusiness->getPoliciesList();
        $materiasAseguradas = $materiaAseguradaBusiness->getInsuredMattersList();
        $embalajes = $embalajeBusiness->getPackingsList();

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

        $certificadoBusiness = new Certificate();
        $certificadoBusiness->editCertificateRequest($idCertificadoSolicitud, $idAsegurado, $idTipoMercaderia, $idPoliza, $aFavorDe, $tipo, $origen, $destino, $via, $fechaEmbarque, $transportista, $naveVueloCamion, $blAwbCrt, $referenciaDespacho, $idMateriaAsegurada, $detalleMercaderia, $idEmbalaje, $montoAseguradoCIF, $tasa, $primaMin, $primaSeguro, $observaciones);
    }

    public function annulments() {

        $certificadoBusiness = new Certificate();
        $certificadosVM = $certificadoBusiness -> getAnnulmentsVM();

        require_once('views/certificate/annulments.php');
    }

    public function annulmentrequest() {

        $certificadoBusiness = new Certificate();
        $certificadoAnulaciones = $certificadoBusiness -> getAnnulmentRequestVM();

        require_once('views/certificate/annulmentrequest.php');
    }

    public function newCertificateAnnulment() {

        $polizaBusiness = new Policy();
        $polizas = $polizaBusiness->getValidatePoliciesList();

        require_once('views/certificate/newCertificateAnnulment.php');
    }

    public function createNewCertificateAnnulment() {
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $motivo = isset($_GET['motivo']) ? $_GET['motivo'] : null;

        $certificadoBusiness = new Certificate();
        $certificadoBusiness->newCertificateAnnulment($idCertificado, $motivo);
    }

    public function certificateAnnulmentEdit() {
        $idCertificadoAnulacion = isset($_GET['idCertificadoAnulacion']) ? $_GET['idCertificadoAnulacion'] : null;

        $certificadoBusiness = new Certificate();
        $polizaBusiness = new Policy();

        $certificadoAnular = $certificadoBusiness->getCertificate($idCertificadoAnulacion);
        $polizas = $polizaBusiness->getPoliciesList();


        require_once('views/certificate/certificateAnnulmentEdit.php');
    }

    public function certificateAnnulmentEdit2db() {
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $motivo = isset($_GET['motivo']) ? $_GET['motivo'] : null;

        $certificadoBusiness = new Certificate();
        $certificadoBusiness->editCertificateAnnulment($idCertificado, $motivo);
    }

    public function addReplaceCertificateNumber() {
        $idCertificadoAnulacion = isset($_GET['idCertificadoAnulacion']) ? $_GET['idCertificadoAnulacion'] : null;

        $certificadoBusiness = new Certificate();
        $certificadoAnulacion = $certificadoBusiness->getCertificateAnnulment($idCertificadoAnulacion);

        $certificados = array();
        $certificados1 = $certificadoBusiness->getCertificatesList();

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

        $certificadoBusiness = new Certificate();
        $certificadoBusiness->addReplaceCertificateNumber2db($idCertificadoAnulacion, $idCertificado);
    }

    public function setCertificateAnnulment() {
        $idCertificadoAnulacion = isset($_GET['idCertificadoAnulacion']) ? $_GET['idCertificadoAnulacion'] : null;
        $estado = isset($_GET['estado']) ? $_GET['estado'] : null;

        $certificadoBusiness = new Certificate();
        $certificadoBusiness->setCertificateAnnulment($idCertificadoAnulacion, $estado);
    }

    public function searchCertificate()
    {
        $idPoliza = isset($_GET['idPoliza']) ? $_GET['idPoliza'] : null;
        $numero = isset($_GET['numero']) ? $_GET['numero'] : null;

        $certificadoBusiness = new Certificate();
        $certificado = $certificadoBusiness -> searchCertificate($idPoliza, $numero);

        if($certificado != null)
        {
            $aseguradoBusiness = new Insured();
            $asegurados = $aseguradoBusiness->getAllInsured();
            $asegurado = getAsegurado($asegurados, $certificado['ID_ASEGURADO']);
            if(isset($asegurado))
                $certificado['NOMBRE_ASEGURADO'] = $asegurado['NOMBRE'];
            else
                $certificado['NOMBRE_ASEGURADO'] = "--";

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