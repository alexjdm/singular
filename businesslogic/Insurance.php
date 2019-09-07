<?php

require_once 'connections/db.php';
include_once("models/DAO/Seguro_DAO.php");

class Insurance
{

    public function getInsurancesList()
    {
        $model = new Seguro_DAO();

        $seguros = $model->getInsurancesList();

        return $seguros;
    }

}