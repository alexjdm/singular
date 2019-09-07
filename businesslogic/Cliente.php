<?php

require_once 'connections/db.php';
include_once("models/DAO/Cliente_DAO.php");

class Cliente
{

    public function getClient($idCliente)
    {
        $model = new Cliente_DAO();
        return $model->getClient($idCliente);
    }

}