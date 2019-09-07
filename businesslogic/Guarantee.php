<?php

require_once 'connections/db.php';
include_once("models/DAO/PolizaGarantia_DAO.php");

class Guarantee
{

    public function getNumberRequest()
    {
        $model = new PolizaGarantia_DAO();

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $garantias = $model->getGuaranteePolicyByState(0); // 0: No Ingresado a la compañia
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

            $garantias = $model->getGuaranteePoliciesByUsersByState($usuarios, 0);
        }

        return count($garantias);
    }

    public function getGuaranteePoliciesList()
    {
        $model = new PolizaGarantia_DAO();
        return $model->getGuaranteePoliciesList();
    }

    public function getGuaranteePoliciesVM(){

        $aseguradoBusiness = new Insured();
        $asegurados = $aseguradoBusiness->getInsuredList();

        $isSuperAdmin = isSuperAdmin();
        if($isSuperAdmin)
        {
            $garantias = $this->getGuaranteePoliciesList();
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

            $garantias = $this->getGuaranteePoliciesByUsers($usuarios);
        }

        $garantiasVM = $this -> ToGuaranteePolocyVM($garantias, $asegurados);
        return $garantiasVM;
    }

    public function getGuaranteePoliciesByUsers($usuarios){

        $aseguradoBusiness = new Insured();

        $model = new PolizaGarantia_DAO();
        $garantias = $model->getGuaranteePoliciesByUsers($usuarios);
        $asegurados = $aseguradoBusiness->getInsuredList();

        $garantiasVM = Array();
        foreach ($garantias as $garantia)
        {
            $garantiaVM = Array();
            $garantiaVM['ID_GARANTIA'] = $garantia['ID_GARANTIA'];

            $asegurado = getAsegurado($asegurados, $garantia['ID_ASEGURADO']);
            if(isset($asegurado))
                $garantiaVM['NOMBRE_ASEGURADO'] = $asegurado['NOMBRE'];
            else
                $garantiaVM['NOMBRE_ASEGURADO'] = "--";

            $cliente = getCliente($garantia['ID_USUARIO_SOLICITANTE']);
            if(isset($cliente))
                $garantiaVM['CLIENTE'] = $cliente['NOMBRE'];
            else
                $garantiaVM['CLIENTE'] = "--";

            $garantiaVM['TIPO_GARANTIA'] = $garantia['TIPO_GARANTIA'];
            $garantiaVM['FECHA_INICIO'] = FormatearFechaSpa($garantia['FECHA_INICIO']);
            $garantiaVM['PLAZO'] = $garantia['PLAZO'];
            $garantiaVM['MONTO_CIF'] = $garantia['MONTO_CIF'];
            $garantiaVM['DERECHOS'] = $garantia['DERECHOS'];
            if($garantia['ESTADO'] == 0)
                $garantiaVM['ESTADO'] = "Pendiente";
            else if($garantia['ESTADO'] == 1)
                $garantiaVM['ESTADO'] = "Lista";
            else
                $garantiaVM['ESTADO'] = "--";

            array_push($garantiasVM, $garantiaVM);
        }

        return $garantiasVM;
    }



    public function ToGuaranteePolocyVM($garantias, $asegurados)
    {
        $garantiasVM = Array();
        foreach ($garantias as $garantia)
        {
            $garantiaVM = Array();
            $garantiaVM['ID_GARANTIA'] = $garantia['ID_GARANTIA'];

            $asegurado = getAsegurado($asegurados, $garantia['ID_ASEGURADO']);
            if(isset($asegurado))
                $garantiaVM['NOMBRE_ASEGURADO'] = $asegurado['NOMBRE'];
            else
                $garantiaVM['NOMBRE_ASEGURADO'] = "--";

            $cliente = getCliente($garantia['ID_USUARIO_SOLICITANTE']);
            if(isset($cliente))
                $garantiaVM['CLIENTE'] = $cliente['NOMBRE'];
            else
                $garantiaVM['CLIENTE'] = "--";

            $garantiaVM['TIPO_GARANTIA'] = $garantia['TIPO_GARANTIA'];
            $garantiaVM['FECHA_INICIO'] = FormatearFechaSpa($garantia['FECHA_INICIO']);
            $garantiaVM['PLAZO'] = $garantia['PLAZO'];
            $garantiaVM['MONTO_CIF'] = $garantia['MONTO_CIF'];
            $garantiaVM['DERECHOS'] = $garantia['DERECHOS'];
            if($garantia['ESTADO'] == 0)
                $garantiaVM['ESTADO'] = "Pendiente";
            else if($garantia['ESTADO'] == 1)
                $garantiaVM['ESTADO'] = "Lista";
            else
                $garantiaVM['ESTADO'] = "--";

            array_push($garantiasVM, $garantiaVM);
        }

        return $garantiasVM;
    }

    public function newGuaranteePolicy($idAsegurado, $tipoGarantia, $tipoMercaderia, $embalaje, $direccion, $fechaInicio, $plazo, $montoCIF, $derechos, $idUsuarioSolicitante)
    {
        $model = new PolizaGarantia_DAO();
        $model->newGuaranteePolicy($idAsegurado, $tipoGarantia, $tipoMercaderia, $embalaje, $direccion, $fechaInicio, $plazo, $montoCIF, $derechos, $idUsuarioSolicitante);
    }

    public function editGuaranteePolicy($idGarantia, $idAsegurado, $tipoGarantia, $tipoMercaderia, $embalaje, $direccion, $fechaInicio, $plazo, $montoCIF, $derechos)
    {
        $model = new PolizaGarantia_DAO();
        $model->editGuaranteePolicy($idGarantia, $idAsegurado, $tipoGarantia, $tipoMercaderia, $embalaje, $direccion, $fechaInicio, $plazo, $montoCIF, $derechos);
    }

    public function deleteGuaranteePolicy($idGarantia)
    {
        $model = new PolizaGarantia_DAO();
        $model->deleteGuaranteePolicy($idGarantia);
    }

    public function getGuaranteePolicy($idGarantia)
    {
        $model = new PolizaGarantia_DAO();
        return $model->getGuaranteePolicy($idGarantia);
    }
}