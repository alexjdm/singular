<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Comuna_DAO {

    public function getComunaList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM comuna ORDER BY NOMBRE ASC");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getComuna($idComuna){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM comuna WHERE ID_COMUNA=:ID_COMUNA");
        $sql->execute(array('ID_COMUNA' => $idComuna));

        return $sql->fetchAll()[0];
    }

}