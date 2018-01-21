<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 10-04-2016
 * Time: 17:34
 */



function getCurrentUser()
{
    if (!isset($_SESSION)) {
        @session_start();
    }

    $usuario = array(
        "id" => $_SESSION['id'],
        "nombre" => $_SESSION['nombre'],
        "apellido" => $_SESSION['apellido'],
        "identificador" => $_SESSION['identificador'],
        "correo" => $_SESSION['correo'],
        "idPerfil" => $_SESSION['idPerfil'],
        "idCargo" => $_SESSION['idCargo'],
        "fechaIngreso" => $_SESSION['fechaIngreso'],
        "idCorredora" => $_SESSION['idCorredora']
    );

    return $usuario;
}

function getCurrentInsuranceBroker()
{
    if (!isset($_SESSION)) {
        @session_start();
    }

    $corredora = array(
        "id" => $_SESSION['idCorredora'],
        "nombre" => $_SESSION['nombreCorredora']
    );

    return $corredora;
}

function isSuperAdmin()
{
    if (!isset($_SESSION)) {
        @session_start();
    }

    if($_SESSION['idPerfil'] == -1)
        return true;
    else
        return false;
}

function isAdmin()
{
    if (!isset($_SESSION)) {
        @session_start();
    }

    if($_SESSION['idPerfil'] == 3)
        return true;
    else
        return false;
}