<?php

require_once 'connections/db.php';
include_once("models/DAO/Asegurado_DAO.php");
include_once("models/DAO/Usuario_DAO.php");
include_once ("helpers/SessionHelper.php");
include_once ("businesslogic/Region.php");
include_once ("businesslogic/Comuna.php");
include_once ("businesslogic/Usuario.php");

class Insured
{

    public function getNumberRequest()
    {
        $modelA = new Asegurado_DAO();
        $modelU = new Usuario_DAO();

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $asegurados = $modelA->getInsuredByState(0); // 0: No Ingresado a la compañia
        }
        else
        {
            $currentUser = getCurrentUser();
            $usuarioBusiness = new Usuario();
            if($currentUser['idPerfil'] == 3) // Es administrador
            {
                //$corredora = getCurrentInsuranceBroker();
                //$idsUsuariosCorredora = $modelU -> getUsers($corredora['id']);
                $idCorredora = $currentUser['idCorredora'];
                $usuarios = $usuarioBusiness->getUsers($idCorredora);
            }
            else
            {
                $usuarios = $usuarioBusiness->getUser($currentUser['idUsuario']);
            }

            $asegurados = $modelA->getInsuredByUsersByState($usuarios,0); // 0: No Ingresado a la compañia
        }

        return count($asegurados);
    }

    public function getAllInsured(){

        $model = new Asegurado_DAO();
        return $asegurados = $model->getInsuredList();
    }

    public function getInsuredList(){

        $model = new Asegurado_DAO();

        $isSuperAdmin = isSuperAdmin();

        $asegurados = array();
        if($isSuperAdmin == true)
        {
            $asegurados = $model->getInsuredList();
        }
        else
        {
            $currentUser = getCurrentUser();
            $usuarioBusiness = new Usuario();
            if($currentUser['idPerfil'] == 3) // Es administrador
            {
                $idCorredora = $currentUser['idCorredora'];
                $usuarios = $usuarioBusiness->getUsers($idCorredora);
            }
            else
            {
                $usuarios = $usuarioBusiness->getUser($currentUser['idUsuario']);
            }

            $asegurados = $model->getInsuredByUsers($usuarios);
        }

        $regionBusiness = new Region();
        $comunaBusiness = new Comuna();
        $usuarioBusiness = new Usuario();

        $regiones = $regionBusiness->getRegionList();
        $comunas = $comunaBusiness->getComunaList();
        $usuarios = $usuarioBusiness->getUsersList();

        $aseguradosVM = array();
        $aseguradoVM = array();
        foreach ($asegurados as $asegurado)
        {
            $aseguradoVM = array();
            $aseguradoVM['ID_ASEGURADO'] = $asegurado['ID_ASEGURADO'];
            $aseguradoVM['IDENTIFICADOR'] = $asegurado['IDENTIFICADOR'];
            $aseguradoVM['NOMBRE'] = $asegurado['NOMBRE'];

            foreach ($regiones as $region):
                if($region['ID_REGION'] == $asegurado['ID_REGION']):
                    $aseguradoVM['REGION'] = utf8_encode($region['NOMBRE']);
                    break;
                endif;
            endforeach;

            foreach ($comunas as $comuna):
                if($comuna['ID_COMUNA'] == $asegurado['ID_COMUNA']):
                    $aseguradoVM['COMUNA'] = utf8_encode($comuna['NOMBRE']);
                    break;
                endif;
            endforeach;

            $aseguradoVM['DIRECCION'] = $asegurado['DIRECCION'];

            if($asegurado['ESTADO'] == 0)
            {
                $aseguradoVM['ESTADO'] = "No Ingresado";
            }
            else if ($asegurado['ESTADO'] == 1)
            {
                $aseguradoVM['ESTADO'] = "Ingresado";
            }
            else
            {
                $aseguradoVM['ESTADO'] = "Desconocido";
            }

            if($isSuperAdmin){
                foreach ($usuarios as $usuario):
                    if($usuario['ID_USUARIO'] == $asegurado['ID_USUARIO_CREADOR']):
                        $aseguradoVM['USUARIO'] = $usuario['NOMBRE'] . ' ' . $usuario['APELLIDO'];
                        break;
                    endif;
                endforeach;
            }

            array_push($aseguradosVM, $aseguradoVM);
        }

        return $aseguradosVM;
    }

    public function getInsured($idAsegurado){

        $model = new Asegurado_DAO();
        return $model->getInsured($idAsegurado);

    }

    public function newInsured($idUsuario, $rut, $nombre, $giro, $idRegion, $idComuna, $direccion, $estado)
    {
        $model = new Asegurado_DAO();
        $model->newInsured($idUsuario, $rut, $nombre, $giro, $idRegion, $idComuna, $direccion, $estado);
    }

    public function editInsured($idAsegurado, $rut, $nombre, $giro, $idRegion, $idComuna, $direccion)
    {
        $model = new Asegurado_DAO();
        $model->editInsured($idAsegurado, $rut, $nombre, $giro, $idRegion, $idComuna, $direccion);
    }

    public function deleteInsured($idAsegurado){

        $model = new Asegurado_DAO();
        $model->deleteInsured($idAsegurado);

    }

    public function validateInsured($idAsegurado){

        $model = new Asegurado_DAO();
        $model->validateInsured($idAsegurado);

    }

    public function invalidateInsured($idAsegurado){

        $model = new Asegurado_DAO();
        $model->invalidateInsured($idAsegurado);

    }

    public function approveAllInsured()
    {
        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin == true)
        {
            $model = new Asegurado_DAO();
            $model->approveAllInsured();
        }
    }

}