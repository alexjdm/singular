<?php

require_once 'connections/db.php';
include_once("models/DAO/MateriaAsegurada_DAO.php");

class InsuredMatter
{

    public function getInsuredMattersList()
    {
        $model = new MateriaAsegurada_DAO();
        return $model->getInsuredMattersList();
    }

    public function newInsuredMatter($materiaAsegurada)
    {
        $model = new MateriaAsegurada_DAO();
        $model->newInsuredMatter($materiaAsegurada);
    }

    public function getInsuredMatter($idMateriaAsegurada)
    {
        $model = new MateriaAsegurada_DAO();
        return $model->getInsuredMatter($idMateriaAsegurada);
    }

    public function editInsuredMatter($idMateriaAsegurada, $materiaAsegurada)
    {
        $model = new MateriaAsegurada_DAO();
        $model->editInsuredMatter($idMateriaAsegurada, $materiaAsegurada);
    }

    public function deleteInsuredMatter($idMateriaAsegurada)
    {
        $model = new MateriaAsegurada_DAO();
        $model->deleteInsuredMatter($idMateriaAsegurada);
    }

}