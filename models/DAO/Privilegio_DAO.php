<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 04-07-2017
 * Time: 23:25
 */

class Privilegio_DAO {

    public function getPrivilegesList(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM privilegio ORDER BY CODIGO_PRIVILEGIO ASC");
        $sql->execute();

        return $sql->fetchAll();
    }

    public function getPrivilege($idPrilegio){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM privilegio WHERE ID_PRIVILEGIO=:ID_PRIVILEGIO");
        $sql->execute(array('ID_PRIVILEGIO' => $idPrilegio));

        return $sql->fetchAll()[0];
    }

    public function getPrivilegesByIdPerfil($idPerfil){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM perfil_privilegio WHERE ID_PERFIL=:ID_PERFIL");
        $sql->execute(array('ID_PERFIL' => $idPerfil));
        $idPrivilegios = $sql->fetchAll();

        $privilegios = array();
        foreach($idPrivilegios as $idPrivilegio)
        {
            $sql = $pdo->prepare("SELECT * FROM privilegio WHERE ID_PRIVILEGIO=:ID_PRIVILEGIO");
            $sql->execute(array('ID_PRIVILEGIO' => $idPrivilegio));

            $sql->fetchAll()[0];

            $privilegioPerfil = $sql->fetchAll()[0];
            if($privilegioPerfil != null)
            {
                array_push($privilegios, $privilegioPerfil);
            }
        }

        return $privilegios;
    }

}