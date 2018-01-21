<?php

require_once 'connections/db.php';
include_once("models/DAO/Siniestro_DAO.php");

class Sinister
{

    public function getNumberRequest()
    {
        $model = new Siniestro_DAO();

        $siniestros = $model->getSinistersByState(0); // 0: No Ingresado a la compañia

        return count($siniestros);
    }

}