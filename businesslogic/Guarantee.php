<?php

require_once 'connections/db.php';
include_once("models/DAO/PolizaGarantia_DAO.php");

class Guarantee
{

    public function getNumberRequest()
    {
        $model = new PolizaGarantia_DAO();

        $garantias = $model->getGuaranteePolicyByState(0); // 0: No Ingresado a la compañia

        return count($garantias);
    }

}