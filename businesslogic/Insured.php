<?php

require_once 'connections/db.php';
include_once("models/DAO/Asegurado_DAO.php");
include_once("models/DAO/Usuario_DAO.php");
include_once ("helpers/SessionHelper.php");

class Insured
{

    public function getNumberRequest()
    {
        $modelA = new Asegurado_DAO();
        $modelU = new Usuario_DAO();

        $corredora = getCurrentInsuranceBroker();
        $idsUsuariosCorredora = $modelU -> getUsers($corredora['id']);

        $asegurados = $modelA->getInsuredByState(0, $idsUsuariosCorredora); // 0: No Ingresado a la compañia

        return count($asegurados);
    }

}