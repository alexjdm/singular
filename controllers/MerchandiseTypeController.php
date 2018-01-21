<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/TipoMercaderia_DAO.php");
require "lib/phpmailer/class.phpmailer.php";

class MerchandiseTypeController {

    public $model;

    public function __construct()
    {
        $this->model = new TipoMercaderia_DAO();
    }

    public function index() {
        $tipoMercaderias = $this->model->getMerchandiseTypesList();
        require_once('views/merchandisetype/index.php');
    }

    public function newMerchandiseType() {
        require_once('views/merchandisetype/newMerchandiseType.php');
    }

    public function createNewMerchandiseType() {
        $tipoMercaderia = isset($_GET['tipoMercaderia']) ? $_GET['tipoMercaderia'] : null;

        return $this->model->newMerchandiseType($tipoMercaderia);
    }

    public function merchandiseTypeEdit() {
        $idTipoMercaderia = isset($_GET['idTipoMercaderia']) ? $_GET['idTipoMercaderia'] : null;
        $tipoMercaderia = $this->model->getMerchandiseType($idTipoMercaderia);

        require_once('views/merchandisetype/merchandiseTypeEdit.php');
    }

    public function merchandiseTypeEdit2db() {
        $idTipoMercaderia = isset($_GET['idTipoMercaderia']) ? $_GET['idTipoMercaderia'] : null;
        $tipoMercaderia = isset($_GET['tipoMercaderia']) ? $_GET['tipoMercaderia'] : null;

        return $this->model->editMerchandiseType($idTipoMercaderia, $tipoMercaderia);
    }

    public function deleteMerchandiseType() {
        $idTipoMercaderia = isset($_GET['idTipoMercaderia']) ? $_GET['idTipoMercaderia'] : null;

        return $this->model->deleteMerchandiseType($idTipoMercaderia);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}