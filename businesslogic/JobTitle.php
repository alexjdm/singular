<?php

require_once 'connections/db.php';
include_once("models/DAO/Cargo_DAO.php");

class JobTitle
{

    public function getJobTitlesList()
    {
        $cargoDAO = new Cargo_DAO();
        return $cargoDAO->getJobTitlesList();
    }

    public function getJobTitlesByInsuranceBrokerId($idCorredora)
    {
        $cargoDAO = new Cargo_DAO();
        return $cargoDAO->getJobTitlesByInsuranceBrokerId($idCorredora);
    }

    public function newJobTitle($nombre)
    {
        $cargoDAO = new Cargo_DAO();
        $cargoDAO->newJobTitle($nombre);
    }

    public function getJobTitle($idCargo)
    {
        $cargoDAO = new Cargo_DAO();
        return $cargoDAO->getJobTitle($idCargo);
    }

    public function editJobTitle($idCargo, $nombre)
    {
        $cargoDAO = new Cargo_DAO();
        $cargoDAO->editJobTitle($idCargo, $nombre);
    }

    public function deleteJobTitle($idCargo)
    {
        $cargoDAO = new Cargo_DAO();
        $cargoDAO->deleteJobTitle($idCargo);
    }

}