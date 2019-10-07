<?php

require_once 'connections/db.php';
include_once("models/DAO/Perfil_DAO.php");

class Profile
{

    public function getProfilesList()
    {
        $model = new Perfil_DAO();
        return $model->getProfilesList();
    }

    public function getAllProfiles()
    {
        $model = new Perfil_DAO();
        return $model->getAllProfiles();
    }

}