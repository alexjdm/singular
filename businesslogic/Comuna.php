<?php

require_once 'connections/db.php';
include_once("models/DAO/Comuna_DAO.php");

class Comuna
{

    public function getComunaList()
    {
        $model = new Comuna_DAO();
        return $model->getComunaList();
    }

}