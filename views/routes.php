<?php

function call($controller, $action) {
    // require the file that matches the controller name
    require_once('controllers/' . $controller . 'Controller.php');

    // create a new instance of the needed controller
    switch($controller) {
        case 'Account':
            $controller = new AccountController();
            break;
        case 'Home':
            $controller = new HomeController();
            break;
        case 'User':
            $controller = new UserController();
            break;
        case 'Company':
            $controller = new CompanyController();
            break;
        case 'InsuranceBroker':
            $controller = new InsuranceBrokerController();
            break;
        /*case 'Client':
            $controller = new InsuranceBrokerController();
            break;*/
        case 'JobTitle':
            $controller = new JobTitleController();
            break;
        case 'Insurance':
            $controller = new InsuranceController();
            break;
        case 'Insured':
            $controller = new InsuredController();
            break;
        case 'InsuredMatter':
            $controller = new InsuredMatterController();
            break;
        case 'Packing':
            $controller = new PackingController();
            break;
        case 'Policy':
            $controller = new PolicyController();
            break;
        case 'GuaranteePolicy':
            $controller = new GuaranteePolicyController();
            break;
        case 'MerchandiseType':
            $controller = new MerchandiseTypeController();
            break;
        case 'Certificate':
            $controller = new CertificateController();
            break;
        case 'CertificateRequest':
            $controller = new CertificateRequestController();
            break;
        case 'CertificateModify':
            $controller = new CertificateModifyController();
            break;
        case 'CertificateAnnulment':
            $controller = new CertificateAnnulmentController();
            break;
        case 'Sinister':
            $controller = new SinisterController();
            break;
        case 'Export':
            $controller = new ExportController();
            break;
    }

    // call the action
    $controller->{ $action }();
}

// just a list of the controllers we have and their actions
// we consider those "allowed" values
$controllers = array(
    'Account' => ['login', 'logout', 'validation', 'remember', 'rememberMail', 'profile', 'error'],
    'Home' => ['index', 'error'],
    'Company' => ['index', 'newCompany', 'createNewCompany', 'companyEdit', 'companyEdit2db', 'deleteCompany', 'error'],
    'InsuranceBroker' => ['index', 'newInsuranceBroker', 'createNewInsuranceBroker', 'insuranceBrokerEdit', 'insuranceBrokerEdit2db', 'deleteInsuranceBroker', 'myInsuranceBroker', 'error'],
    'Client' => ['index', 'newClient', 'createNewClient', 'clientEdit', 'clientEdit2db', 'deleteClient', 'usersClient', 'error'],
    'User' => ['index', 'sellers', 'newSeller', 'createNewSeller', 'sellerEdit', 'newUser', 'createNewUser', 'userEdit', 'userEdit2db', 'deleteUser', 'changePassword', 'changePassword2db', 'usersInsuranceBroker', 'insuranceUsers', 'error'],
    'JobTitle' => ['index', 'newJobTitle', 'createNewJobTitle', 'jobTitleEdit', 'jobTitleEdit2db', 'deleteJobTitle', 'error'],
    'Policy' => ['index', 'newPolicy', 'createNewPolicy', 'policyEdit', 'policyEdit2db', 'deletePolicy', 'error'],
    'GuaranteePolicy' => ['index', 'newGuaranteePolicy', 'createNewGuaranteePolicy', 'guaranteePolicyEdit', 'guaranteePolicyEdit2db', 'deleteGuaranteePolicy', 'error'],
    'Insurance' => ['index', 'newInsurance', 'createNewInsurance', 'insuranceEdit', 'insuranceEdit2db', 'deleteInsurance', 'error'],
    'Insured' => ['index', 'newInsured', 'createNewInsured', 'insuredEdit', 'insuredEdit2db', 'deleteInsured', 'validateInsured', 'invalidateInsured', 'error'],
    'MerchandiseType' => ['index', 'newMerchandiseType', 'createNewMerchandiseType', 'merchandiseTypeEdit', 'merchandiseTypeEdit2db', 'deleteMerchandiseType', 'error'],
    'InsuredMatter' => ['index', 'newInsuredMatter', 'createNewInsuredMatter', 'insuredMatterEdit', 'insuredMatterEdit2db', 'deleteInsuredMatter', 'error'],
    'Packing' => ['index', 'newPacking', 'createNewPacking', 'packingEdit', 'packingEdit2db', 'deletePacking', 'error'],
    'Certificate' => ['request', 'newCertificateRequest', 'createNewCertificateRequest', 'certificateRequestEdit', 'certificateRequestEdit2db',
        'newCertificate', 'addCertificate', 'changeCertificate', 'changeNewCertificate',
        'index', 'createNewCertificate', 'certificateEdit', 'certificateEdit2db', 'viewCertificate', 'deleteCertificate',
        'annulments', 'newCertificateAnnulment', 'createNewCertificateAnnulment', 'certificateAnnulmentEdit', 'certificateAnnulmentEdit2db', 'deleteCertificateAnnulment', 'addReplaceCertificateNumber', 'addReplaceCertificateNumber2db', 'setCertificateAnnulment',
        'searchCertificate',
        'error'],
    //'CertificateRequest' => ['index', 'newCertificateRequest', 'createNewCertificateRequest', 'certificateRequestEdit', 'certificateRequestEdit2db', 'deleteCertificateRequest', 'error'],
    'CertificateModify' => ['index', 'newCertificateModify', 'createNewCertificateModify', 'certificateModifyEdit', 'certificateModifyEdit2db', 'setCertificateModify', 'deleteCertificateModify', 'error'],
    //'CertificateAnnulment' => ['index', 'newCertificateAnnulment', 'createNewCertificateAnnulment', 'certificateAnnulmentEdit', 'certificateAnnulmentEdit2db', 'deleteCertificateAnnulment', 'addReplaceCertificateNumber', 'error'],
    'Sinister' => ['index', 'newSinister', 'createNewSinister', 'sinisterEdit', 'sinisterEdit2db', 'deleteSinister', 'error'],
    'Export' => ['ExportUsers', 'error']
);

// check that the requested controller and action are both allowed
// if someone tries to access something else he will be redirected to the error action of the home controller
if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } else {
        call('Home', 'error');
    }
} else {
    call('Home', 'error');
}