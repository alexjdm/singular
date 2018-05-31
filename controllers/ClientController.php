<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/Cliente_DAO.php");
require "lib/phpmailer/class.phpmailer.php";

class ClientController {

    public $model;

    public function __construct()
    {
        $this->model = new Cliente_DAO();
    }

    public function index() {
        $clientes = $this->model->getClientsList();
        require_once('views/client/index.php');
    }

    public function newClient() {
        require_once('views/client/newClient.php');
    }

    public function createNewClient() {
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $rut = isset($_GET['rut']) ? $_GET['rut'] : null;
        $direccion = isset($_GET['direccion']) ? $_GET['direccion'] : null;
        $ciudad = isset($_GET['ciudad']) ? $_GET['ciudad'] : null;
        $telefono = isset($_GET['telefono']) ? $_GET['telefono'] : null;
        $giro = isset($_GET['giro']) ? $_GET['giro'] : null;
        $razonSocial = isset($_GET['razonSocial']) ? $_GET['razonSocial'] : null;
        $tasa = isset($_GET['tasa']) ? $_GET['tasa'] : null;
        $primaMin = isset($_GET['primaMin']) ? $_GET['primaMin'] : null;

        return $this->model->newClient($nombre, $rut, $direccion, $ciudad, $telefono, $giro, $razonSocial, $tasa, $primaMin);
    }

    public function clientEdit() {
        $idCliente = isset($_GET['idCliente']) ? $_GET['idCliente'] : null;
        $cliente = $this->model->getClient($idCliente);

        require_once('views/client/clientEdit.php');
    }

    public function clientEdit2db() {
        $idCliente = isset($_GET['idCliente']) ? $_GET['idCliente'] : null;
        $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
        $rut = isset($_GET['rut']) ? $_GET['rut'] : null;
        $direccion = isset($_GET['direccion']) ? $_GET['direccion'] : null;
        $ciudad = isset($_GET['ciudad']) ? $_GET['ciudad'] : null;
        $telefono = isset($_GET['telefono']) ? $_GET['telefono'] : null;
        $giro = isset($_GET['giro']) ? $_GET['giro'] : null;
        $razonSocial = isset($_GET['razonSocial']) ? $_GET['razonSocial'] : null;
        $tasa = isset($_GET['tasa']) ? $_GET['tasa'] : null;
        $primaMin = isset($_GET['primaMin']) ? $_GET['primaMin'] : null;

        return $this->model->editClient($idCliente, $nombre, $rut, $direccion, $ciudad, $telefono, $giro, $razonSocial, $tasa, $primaMin);
    }

    public function deleteClient() {
        $idCliente = isset($_GET['idCliente']) ? $_GET['idCliente'] : null;

        return $this->model->deleteClient($idCliente);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}