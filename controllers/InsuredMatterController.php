<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("businesslogic/InsuredMatter.php");
require "lib/phpmailer/class.phpmailer.php";

class InsuredMatterController {

    public function __construct()
    {
    }

    public function index() {

        $insuredMatterBusiness = new InsuredMatter();
        $materiasAseguradas = $insuredMatterBusiness->getInsuredMattersList();

        require_once('views/insuredmatter/index.php');
    }

    public function newInsuredMatter() {
        require_once('views/insuredmatter/newInsuredMatter.php');
    }

    public function createNewInsuredMatter() {
        $materiaAsegurada = isset($_GET['materiaAsegurada']) ? $_GET['materiaAsegurada'] : null;

        $insuredMatterBusiness = new InsuredMatter();
        $insuredMatterBusiness->newInsuredMatter($materiaAsegurada);
    }

    public function insuredMatterEdit() {
        $idMateriaAsegurada = isset($_GET['idMateriaAsegurada']) ? $_GET['idMateriaAsegurada'] : null;

        $insuredMatterBusiness = new InsuredMatter();
        $materiaAsegurada = $insuredMatterBusiness->getInsuredMatter($idMateriaAsegurada);

        require_once('views/insuredmatter/insuredMatterEdit.php');
    }

    public function insuredMatterEdit2db() {
        $idMateriaAsegurada = isset($_GET['idMateriaAsegurada']) ? $_GET['idMateriaAsegurada'] : null;
        $materiaAsegurada = isset($_GET['materiaAsegurada']) ? $_GET['materiaAsegurada'] : null;

        $insuredMatterBusiness = new InsuredMatter();
        $insuredMatterBusiness->editInsuredMatter($idMateriaAsegurada, $materiaAsegurada);
    }

    public function deleteInsuredMatter() {
        $idMateriaAsegurada = isset($_GET['idMateriaAsegurada']) ? $_GET['idMateriaAsegurada'] : null;

        $insuredMatterBusiness = new InsuredMatter();
        $insuredMatterBusiness->deleteInsuredMatter($idMateriaAsegurada);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}