<?php

require_once 'connections/db.php';
include_once("models/DAO/Certificado_DAO.php");
include_once("models/DAO/CertificadoModificacion_DAO.php");

class Certificate
{

    public function getNumberRequest()
    {
        $model = new Certificado_DAO();
        $corredora = getCurrentInsuranceBroker();
        $solicitudesPendientes = array();
        if(isSuperAdmin() == true)
        {
            $solicitudesPendientes = $model->getCertificateRequestsByState(0); // 0: Pendiente
        }
        else
        {
            $solicitudesPendientes = $model->getCertificateRequestsByInsuredBrokerAndState($corredora['id'], 0); // 0: Pendiente
        }

        return count($solicitudesPendientes);
    }

    public function getNumberAnnulments()
    {
        $model = new Certificado_DAO();
        $corredora = getCurrentInsuranceBroker();
        $anulacionesPendientes = array();
        if(isSuperAdmin() == true)
        {
            $anulacionesPendientes = $model->getCertificateAnnulmentsByState(0); // 0: Pendiente
        }
        else
        {
            $anulacionesPendientes = $model->getCertificateAnnulmentsByInsuredBrokerAndState($corredora['id'], 0); // 0: Pendiente
        }

        return count($anulacionesPendientes);
    }

    public function getNumberModifies()
    {
        $model = new CertificadoModificacion_DAO();
        $corredora = getCurrentInsuranceBroker();
        if(isSuperAdmin() == true)
        {
            $modificacionesPendientes = $model->getCertificateModifiesByState(0); // 0: Pendiente
        }
        else
        {
            $modificacionesPendientes = $model->getCertificateModifiesByInsuredBrokerAndState($corredora['id'], 0); // 0: Pendiente
        }

        return count($modificacionesPendientes);
    }

    public function getPolicyNumber($idCertificado)
    {
        $model = new Certificado_DAO();
        $certificado = $model->getCertificate($idCertificado);

        return $certificado['ID_POLIZA'];
    }

}