<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Perfil_DAO {

    public function getPerfilesList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM perfil where ID_PERFIL > 0 ORDER BY NOMBRE_PERFIL ASC");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getPerfil($idUsuario){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM perfil WHERE ID_PERFIL=:ID_PERFIL");
        $sql->execute(array('ID_PERFIL' => $idUsuario));

        return $sql->fetchAll()[0];
    }

}