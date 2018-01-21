<?php

include_once("../models/DAO/Registro_DAO.php");

class LogHelper
{

    public static function log($idUsuario, $fecha, $descripcion, $url, $idCorredora) {
        $rdao = new Registro_DAO();
        $rdao->save($idUsuario, $fecha, $descripcion, $url, $idCorredora);
    }
}