<?php

require_once 'connections/db.php';
include_once("models/DAO/TiposMedio_DAO.php");

class MediaType
{

    public function getMediaTypeList()
    {
        $tipoMedioDAO = new TipoMedio_DAO();
        return $tipoMedioDAO->getMedioTypesList();
    }

    public function newMedioType($nombre)
    {
        $tipoMedioDAO = new TipoMedio_DAO();
        $tipoMedioDAO->newMedioType($nombre);
    }

    public function getMedioType($idMedioType)
    {
        $tipoMedioDAO = new TipoMedio_DAO();
        return $tipoMedioDAO->getMedioType($idMedioType);
    }

    public function editMedioType($idMedioType, $nombre)
    {
        $tipoMedioDAO = new TipoMedio_DAO();
        $tipoMedioDAO->editMedioType($idMedioType, $nombre);
    }

    public function deleteMedioType($idMedioType)
    {
        $tipoMedioDAO = new TipoMedio_DAO();
        $tipoMedioDAO->deleteMedioType($idMedioType);
    }

}