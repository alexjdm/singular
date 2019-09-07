<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("businesslogic/MerchandiseType.php");
require "lib/phpmailer/class.phpmailer.php";

class MerchandiseTypeController {

    public function __construct()
    {
    }

    public function index() {

        $tipoMercaderiaBusiness = new MerchandiseType();
        $tipoMercaderias = $tipoMercaderiaBusiness -> getMerchandiseTypesList();

        require_once('views/merchandisetype/index.php');
    }

    public function newMerchandiseType() {
        require_once('views/merchandisetype/newMerchandiseType.php');
    }

    public function createNewMerchandiseType() {
        $tipoMercaderia = isset($_GET['tipoMercaderia']) ? $_GET['tipoMercaderia'] : null;

        $tipoMercaderiaBusiness = new MerchandiseType();
        $tipoMercaderiaBusiness->newMerchandiseType($tipoMercaderia);
    }

    public function merchandiseTypeEdit() {
        $idTipoMercaderia = isset($_GET['idTipoMercaderia']) ? $_GET['idTipoMercaderia'] : null;

        $tipoMercaderiaBusiness = new MerchandiseType();
        $tipoMercaderia = $tipoMercaderiaBusiness->getMerchandiseType($idTipoMercaderia);

        require_once('views/merchandisetype/merchandiseTypeEdit.php');
    }

    public function merchandiseTypeEdit2db() {
        $idTipoMercaderia = isset($_GET['idTipoMercaderia']) ? $_GET['idTipoMercaderia'] : null;
        $tipoMercaderia = isset($_GET['tipoMercaderia']) ? $_GET['tipoMercaderia'] : null;

        $tipoMercaderiaBusiness = new MerchandiseType();
        $tipoMercaderiaBusiness->editMerchandiseType($idTipoMercaderia, $tipoMercaderia);
    }

    public function deleteMerchandiseType() {
        $idTipoMercaderia = isset($_GET['idTipoMercaderia']) ? $_GET['idTipoMercaderia'] : null;

        $tipoMercaderiaBusiness = new MerchandiseType();
        $tipoMercaderiaBusiness->deleteMerchandiseType($idTipoMercaderia);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}