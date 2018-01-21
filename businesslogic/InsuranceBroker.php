<?php

require_once 'connections/db.php';
include_once("models/DAO/Corredora_DAO.php");
include_once ("helpers/SessionHelper.php");

class InsuranceBroker
{

    public function save($nombre, $rut, $direccion, $ciudad, $telefono, $giro, $razonSocial, $tasa, $primaMin)
    {
        $model = new Corredora_DAO();
        $corredora = getCurrentInsuranceBroker();
        return $model->newInsuranceBroker($nombre, $rut, $direccion, $ciudad, $telefono, $giro, $razonSocial, $tasa, $primaMin, $corredora['id']);
    }

}