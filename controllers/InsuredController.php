<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/Asegurado_DAO.php");
include_once("models/DAO/Region_DAO.php");
include_once("models/DAO/Comuna_DAO.php");
include_once("models/DAO/Usuario_DAO.php");
include_once("helpers/SessionHelper.php");
include_once("businesslogic/Notification.php");

require "lib/phpmailer/class.phpmailer.php";

class InsuredController {

    public $model;
    public $modelR;
    public $modelC;
    public $modelU;

    public function __construct()
    {
        $this->model = new Asegurado_DAO();
        $this->modelR = new Region_DAO();
        $this->modelC = new Comuna_DAO();
        $this->modelU = new Usuario_DAO();
    }

    public function index() {

        $isSuperAdmin = isSuperAdmin();

        //$usuario = getCurrentUser();
        $corredora = getCurrentInsuranceBroker();
        $asegurados = array();
        if($isSuperAdmin == true)
        {
            $asegurados = $this -> model->getInsuredList();
        }
        else
        {
            $usuariosCorredora = $this -> modelU -> getUsersFromInsuredBroker($corredora['id']);
            $ids = '';
            $arrayIds = array();
            foreach ($usuariosCorredora as $usuarioCorredora) {
                array_push($arrayIds, $usuarioCorredora['ID_USUARIO']);
            }
            $ids = join("','",$arrayIds);

            $asegurados = $this -> model->getInsuredByInsuranceBrokerId($ids);
        }
        $regiones = $this->modelR->getRegionList();
        $comunas = $this->modelC->getComunaList();
        $usuarios = $this->modelU->getUsersList();

        require_once('views/insured/index.php');
    }

    public function newInsured() {
        $regiones = $this->modelR->getRegionList();
        $comunas = $this->modelC->getComunaList();

        require_once('views/insured/newInsured.php');
    }

    public function createNewInsured() {
        $rut = isset($_GET['rut']) ? $_GET['rut'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $giro = isset($_GET['giro']) ? $_GET['giro'] : null;
        $idRegion = isset($_GET['idRegion']) ? $_GET['idRegion'] : null;
        $idComuna = isset($_GET['idComuna']) ? $_GET['idComuna'] : null;
        $direccion = isset($_GET['direccion']) ? $_GET['direccion'] : null;

        // Si es SuperAdmin queda validado sino queda a la espera de validacion
        $estado = 0;
        $currentUser = getCurrentUser();
        $idUsuario = $currentUser['id'];
        if($currentUser['idPerfil'] == -1)
        {
            $estado = 1;
        }
        else
        {
            Notification::NotificarAsegurado($currentUser, $nombre, $giro, $idRegion, $idComuna, $direccion);
        }

        return $this->model->newInsured($idUsuario, $rut, $nombre, $giro, $idRegion, $idComuna, $direccion, $estado);
    }

    public function insuredEdit() {
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;
        $asegurado = $this->model->getInsured($idAsegurado);
        $regiones = $this->modelR->getRegionList();
        $comunas = $this->modelC->getComunaList();

        require_once('views/insured/insuredEdit.php');
    }

    public function insuredEdit2db() {
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;
        $rut = isset($_GET['rut']) ? $_GET['rut'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $giro = isset($_GET['giro']) ? $_GET['giro'] : null;
        $idRegion = isset($_GET['idRegion']) ? $_GET['idRegion'] : null;
        $idComuna = isset($_GET['idComuna']) ? $_GET['idComuna'] : null;
        $direccion = isset($_GET['direccion']) ? $_GET['direccion'] : null;

        return $this->model->editInsured($idAsegurado, $rut, $nombre, $giro, $idRegion, $idComuna, $direccion);
    }

    public function deleteInsured() {
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;

        return $this->model->deleteInsured($idAsegurado);
    }

    public function validateInsured() {
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;

        return $this->model->validateInsured($idAsegurado);
    }

    public function invalidateInsured() {
        $idAsegurado = isset($_GET['idAsegurado']) ? $_GET['idAsegurado'] : null;

        return $this->model->invalidateInsured($idAsegurado);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}