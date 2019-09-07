<?php

require_once 'connections/db.php';
include_once("models/DAO/Corredora_DAO.php");
include_once("models/DAO/Usuario_DAO.php");
include_once ("helpers/SessionHelper.php");

class InsuranceBroker
{

    public $model;
    public $modelU;

    public function __construct()
    {
        $this->model = new Corredora_DAO();
        $this->modelU = new Usuario_DAO();
    }

    public function save($nombre, $rut, $direccion, $ciudad, $telefono, $giro, $razonSocial, $tasa, $primaMin, $idVendedor)
    {
        $corredora = getCurrentInsuranceBroker();
        $this->model->newInsuranceBroker($nombre, $rut, $direccion, $ciudad, $telefono, $giro, $razonSocial, $tasa, $primaMin, $idVendedor, $corredora['id']);
    }

    public function getClientsForCurrentUser()
    {
        $currentUser = getCurrentUser();
        $idCorredora = $currentUser['idCorredora'];
        $corredoras2 = $this->model->getClients($idCorredora);

        $corredoras = array();
        foreach ($corredoras2 as $corredora)
        {
            $vendedor = $this->modelU->getUser($corredora['ID_USUARIO_VENDEDOR']);
            $corredora['VENDEDOR'] = $vendedor['NOMBRE']. " " . $vendedor['APELLIDO'];
            array_push($corredoras, $corredora);
        }

        return $corredoras;
    }

    public function getInsuranceBrokerByIdUser($idUsuario)
    {
        $corredora = $this->model->getInsuranceBrokerByUserId($idUsuario);
        return $corredora;
    }

    public function getInsuranceBroker($idCorredora)
    {
        $corredora = $this->model->getInsuranceBroker($idCorredora);
        return $corredora;
    }

    public function getInsuranceBrokersList()
    {
        $corredoras = $this->model->getInsuranceBrokersList();
        return $corredoras;
    }

}