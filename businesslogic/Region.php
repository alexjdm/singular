<?php

require_once 'connections/db.php';
include_once("models/DAO/Region_DAO.php");

class Region
{

    public function getRegionList()
    {
        $model = new Region_DAO();
        return $model->getRegionList();
    }

}