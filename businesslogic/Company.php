<?php

require_once 'connections/db.php';
include_once("models/DAO/Compania_DAO.php");

class Company
{

    public function getCompaniesList()
    {
        $model = new Compania_DAO();
        return $model->getCompaniesList();
    }

    public function getCompany($idCompany)
    {
        $model = new Compania_DAO();
        return $model->getCompany($idCompany);
    }

    public function newCompany($nombre, $tasa, $prima_minima, $limite_embarque, $tipo_cuenta, $comision)
    {
        $model = new Compania_DAO();
        $model ->newCompany($nombre, $tasa, $prima_minima, $limite_embarque, $tipo_cuenta, $comision);
    }

    public function editCompany($idCompania, $nombre, $tasa, $prima_minima, $limite_embarque, $tipo_cuenta, $comision)
    {
        $model = new Compania_DAO();
        $model->editCompany($idCompania, $nombre, $tasa, $prima_minima, $limite_embarque, $tipo_cuenta, $comision);
    }

    public function deleteCompany($idCompania)
    {
        $model = new Compania_DAO();
        $model->deleteCompany($idCompania);
    }

}