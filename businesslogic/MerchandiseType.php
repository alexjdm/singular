<?php

require_once 'connections/db.php';
include_once("models/DAO/TipoMercaderia_DAO.php");

class MerchandiseType
{

    public function getMerchandiseTypesList()
    {
        $tiposMercaderiaDAO = new TipoMercaderia_DAO();
        $tiposMercaderia = $tiposMercaderiaDAO->getMerchandiseTypesList();

        return $tiposMercaderia;
    }

    public function newMerchandiseType($tipoMercaderia)
    {
        $tiposMercaderiaDAO = new TipoMercaderia_DAO();
        $tiposMercaderiaDAO -> newMerchandiseType($tipoMercaderia);
    }

    public function getMerchandiseType($idTipoMercaderia)
    {
        $tiposMercaderiaDAO = new TipoMercaderia_DAO();
        $tipoMercaderia = $tiposMercaderiaDAO->getMerchandiseType($idTipoMercaderia);
        return $tipoMercaderia;
    }

    public function editMerchandiseType($idTipoMercaderia, $tipoMercaderia)
    {
        $tiposMercaderiaDAO = new TipoMercaderia_DAO();
        $tiposMercaderiaDAO->editMerchandiseType($idTipoMercaderia, $tipoMercaderia);
    }

    public function deleteMerchandiseType($idTipoMercaderia)
    {
        $tiposMercaderiaDAO = new TipoMercaderia_DAO();
        $tiposMercaderiaDAO->deleteMerchandiseType($idTipoMercaderia);
    }

}