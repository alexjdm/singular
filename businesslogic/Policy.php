<?php

require_once 'connections/db.php';
include_once("models/DAO/Poliza_DAO.php");
include_once("models/DAO/Compania_DAO.php");

class Policy
{

    public function getAllPolicies()
    {
        $model = new Poliza_DAO();
        $polizas = $model->getAllPolicies();

        return $polizas;
    }

    public function getPoliciesList()
    {
        $model = new Poliza_DAO();
        $polizas = $model->getPoliciesList();

        return $polizas;
    }

    public function getValidatePoliciesList()
    {
        $model = new Poliza_DAO();
        $polizas = $model->getValidatePoliciesList();

        return $polizas;
    }

    public function getPolicies(){
        $polizaDAO = new Poliza_DAO();
        $polizas = $polizaDAO->getPoliciesList();

        $companiaDAO = new Compania_DAO();
        $companias = $companiaDAO->getCompaniesList();

        $polizasVM = Array();

        foreach ($polizas as $poliza)
        {
            $polizaVM = Array();
            $polizaVM['ID_POLIZA'] = $poliza['ID_POLIZA'];
            $polizaVM['TIPO_POLIZA'] = $poliza['TIPO_POLIZA'];
            $polizaVM['NUMERO'] = $poliza['NUMERO'];
            $polizaVM['FECHA_INICIO'] = FormatearFechaSpa($poliza['FECHA_INICIO']);
            $polizaVM['FECHA_FIN'] = FormatearFechaSpa($poliza['FECHA_FIN']);

            $compania = getCompany($companias, $poliza['ID_COMPANIA']);
            if(isset($compania))
                $polizaVM['COMPANIA'] = $compania['NOMBRE'];
            else
                $polizaVM['COMPANIA'] = "--";

            array_push($polizasVM, $polizaVM);
        }

        return $polizasVM;
    }

    public function getPolicy($idPolicy){
        $polizaDAO = new Poliza_DAO();
        $poliza = $polizaDAO->getPolicy($idPolicy);

        $companyBusiness = new Company();

        $polizaVM = Array();
        $polizaVM['ID_POLIZA'] = $poliza['ID_POLIZA'];
        $polizaVM['TIPO_POLIZA'] = $poliza['TIPO_POLIZA'];
        $polizaVM['NUMERO'] = $poliza['NUMERO'];
        $polizaVM['FECHA_INICIO'] = FormatearFechaSpa($poliza['FECHA_INICIO']);
        $polizaVM['FECHA_FIN'] = FormatearFechaSpa($poliza['FECHA_FIN']);
        $polizaVM['ID_COMPANIA'] = $poliza['ID_COMPANIA'];

        $compania = $companyBusiness->getCompany($poliza['ID_COMPANIA']);
        if(isset($compania))
            $polizaVM['COMPANIA'] = $compania['NOMBRE'];
        else
            $polizaVM['COMPANIA'] = "--";

        return $polizaVM;
    }

    public function newPolicy($idCompania, $tipoPoliza, $numeroPoliza)
    {
        $polizaDAO = new Poliza_DAO();
        $polizaDAO->newPolicy($idCompania, $tipoPoliza, $numeroPoliza);
    }

    public function editPolicy($idPoliza, $idCompania, $tipoPoliza, $numeroPoliza)
    {
        $polizaDAO = new Poliza_DAO();
        $polizaDAO->editPolicy($idPoliza, $idCompania, $tipoPoliza, $numeroPoliza);
    }

    public function deletePolicy($idPoliza)
    {
        $polizaDAO = new Poliza_DAO();
        $polizaDAO->deletePolicy($idPoliza);
    }

}