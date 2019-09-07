<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("businesslogic/Sinister.php");
include_once("businesslogic/Insured.php");
include_once("businesslogic/Certificate.php");
include_once("businesslogic/Policy.php");
include_once("businesslogic/Usuario.php");
include_once("businesslogic/InsuranceBroker.php");
include_once("businesslogic/Sinister.php");
require "lib/phpmailer/class.phpmailer.php";

class SinisterController {

    public function __construct()
    {
    }

    public function index() {

        $sinisterBusiness = new Sinister();
        $siniestrosVM = $sinisterBusiness -> getSinistersReport();

        require_once('views/sinister/index.php');
    }

    public function newSinister() {

        $polizaBusiness = new Policy();
        $aseguradoBusiness = new Insured();
        $certificadoBusiness = new Certificate();

        $polizas = $polizaBusiness->getAllPolicies();
        $asegurados = $aseguradoBusiness->getInsuredList();
        $certificados = $certificadoBusiness->getCertificatesList();

        require_once('views/sinister/newSinister.php');
    }

    public function createNewSinister() {
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $motivo = isset($_GET['motivo']) ? $_GET['motivo'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $telefono = isset($_GET['telefono']) ? $_GET['telefono'] : null;
        $correo = isset($_GET['correo']) ? $_GET['correo'] : null;

        $currentUser = getCurrentUser();

        $sinesterBusiness = new Sinister();
        $sinesterBusiness->newSinister($idCertificado, $motivo, $nombre, $telefono, $correo);
        $sinesterBusiness->sendEmail($currentUser, $motivo, $nombre, $telefono, $correo);
    }

    public function addSinister() {
        $idSinister = isset($_GET['idSiniestro']) ? $_GET['idSiniestro'] : null;
        $sinisterBusiness = new Sinister();
        $siniestro = $sinisterBusiness -> getSinisterVM($idSinister);

        require_once('views/sinister/addSinister.php');
    }

    public function addSinisterDoc() {

        if(!empty($_FILES)) {
            if(is_uploaded_file($_FILES['liquidacionSiniestro']['tmp_name'])) {
                /*$dirpath = realpath(dirname(getcwd()));
                $dirpath = realpath(dirname($_SERVER['PHP_SELF']));*/
                $dirpath = dirname($_SERVER['SCRIPT_FILENAME']);

                $idSiniestro = isset($_POST['idSiniestro']) ? $_POST['idSiniestro'] : null;

                $sourcePath = $_FILES['liquidacionSiniestro']['tmp_name'];
                $targetPath = "upload/LiquidacionSiniestro-" . $idSiniestro . '-' . $_FILES['liquidacionSiniestro']['name'];
                // TODO: Verificar si se sube con el mismo nombre

                $ubicacion = $targetPath;
                //$formato = pathinfo($targetPath, PATHINFO_EXTENSION);

                if(move_uploaded_file($sourcePath, $dirpath . '/' . $targetPath)) {
                    $sinisterBusiness = new Sinister();
                    $sinisterBusiness->addSinisterDoc($idSiniestro, $ubicacion);
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

    public function sinisterEdit() {
        $idSiniestro = isset($_GET['idSiniestro']) ? $_GET['idSiniestro'] : null;

        $siniestroBusiness = new Sinister();
        $certificadoBusiness = new Certificate();
        $polizaBusiness = new Policy();

        $siniestro = $siniestroBusiness->getSinister($idSiniestro);
        $certificado = $certificadoBusiness->getCertificate($siniestro['ID_CERTIFICADO']);

        $numeroCertificado = $certificado['NUMERO'];

        $polizas = $polizaBusiness->getAllPolicies();

        require_once('views/sinister/sinisterEdit.php');
    }

    public function sinisterEdit2db() {
        $idSiniestro = isset($_GET['idSiniestro']) ? $_GET['idSiniestro'] : null;
        $idCertificado = isset($_GET['idCertificado']) ? $_GET['idCertificado'] : null;
        $motivo = isset($_GET['motivo']) ? $_GET['motivo'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $telefono = isset($_GET['telefono']) ? $_GET['telefono'] : null;
        $correo = isset($_GET['correo']) ? $_GET['correo'] : null;
        $numero = isset($_GET['numeroSiniestro']) ? $_GET['numeroSiniestro'] : null;

        $siniestroBusiness = new Sinister();
        $siniestroBusiness->editSinister($idSiniestro, $idCertificado, $motivo, $nombre, $telefono, $correo, $numero);
    }

    public function deleteSinister() {
        $idSiniestro = isset($_GET['idSiniestro']) ? $_GET['idSiniestro'] : null;

        $sinesterBusiness = new Sinister();
        $sinesterBusiness->deleteSinister($idSiniestro);
    }




    public function error() {
        require_once('views/error/error.php');
    }

}