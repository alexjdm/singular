<?php

require_once 'connections/db.php';
include_once("models/DAO/Usuario_DAO.php");

class Usuario
{

    public function getUser($idUsuario)
    {
        $uDao = new Usuario_DAO();
        return $uDao->getUser($idUsuario);
    }

    public function getUsers($idCorredora)
    {
        $uDao = new Usuario_DAO();
        return $uDao->getUsers($idCorredora);
    }

    public function getSuperAdmins()
    {
        $uDao = new Usuario_DAO();
        return $uDao->getSuperAdmins();
    }

    public function getUsersList(){
        $uDao = new Usuario_DAO();
        return $uDao->getUsersList();
    }

    public function getSellersList()
    {
        $currentUser = getCurrentUser();
        $idCorredora = $currentUser['idCorredora'];

        $uDao = new Usuario_DAO();
        $sellers = $uDao->getSellersListByInsuranceBrokerId($idCorredora);

        return $sellers;
    }

    public function changePasswordUser($idUsuario, $password)
    {
        $uDao = new Usuario_DAO();
        $uDao -> changePasswordUser($idUsuario, $password);
    }

    public function newUser($nombre, $rut, $apellido, $correo, $idCargo, $idCorredora, $idPerfil)
    {
        $uDao = new Usuario_DAO();
        $uDao -> newUser($nombre, $rut, $apellido, $correo, $idCargo, $idCorredora, $idPerfil);
    }

    public function newUserByIdentifier($identificador, $nombre, $apellido, $correo, $idCargo, $idCorredora, $idPerfil)
    {
        $uDao = new Usuario_DAO();
        $uDao -> newUser($identificador, $nombre, $apellido, $correo, $idCargo, $idCorredora, $idPerfil);
    }

    public function getUsersByIdInsuranceBroker($idCorredora)
    {
        $uDao = new Usuario_DAO();
        return $uDao -> getUsersByIdInsuranceBroker($idCorredora);
    }

    public function editUser($idUsuario, $identificador, $nombre, $apellido, $correo, $idCargo, $idPerfil, $idCorredora)
    {
        $uDao = new Usuario_DAO();
        $uDao -> editUser($idUsuario, $identificador, $nombre, $apellido, $correo, $idCargo, $idPerfil, $idCorredora);
    }

}