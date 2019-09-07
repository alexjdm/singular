<?php

require_once 'connections/db.php';
include_once("models/DAO/Embalaje_DAO.php");

class Packing
{

    public function getPackingsList()
    {
        $embalajeDAO = new Embalaje_DAO();
        return $embalajeDAO->getPackingsList();
    }

    public function newPacking($embalaje, $idPoliza)
    {
        $embalajeDAO = new Embalaje_DAO();
        $embalajeDAO->newPacking($embalaje, $idPoliza);
    }

    public function getPacking($idEmbalaje)
    {
        $embalajeDAO = new Embalaje_DAO();
        return $embalajeDAO -> getPacking($idEmbalaje);
    }

    public function editPacking($idEmbalaje, $embalaje, $idPoliza)
    {
        $embalajeDAO = new Embalaje_DAO();
        $embalajeDAO ->editPacking($idEmbalaje,$embalaje, $idPoliza);
    }

    public function deletePacking($idEmbalaje)
    {
        $embalajeDAO = new Embalaje_DAO();
        $embalajeDAO -> deletePacking($idEmbalaje);
    }

}