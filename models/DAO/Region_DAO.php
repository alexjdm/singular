<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Region_DAO {

    public function getRegionList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM region");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getRegion($idRegion){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM region WHERE ID_REGION=:ID_REGION");
        $sql->execute(array('ID_REGION' => $idRegion));

        return $sql->fetchAll()[0];
    }

}