<?php
/*Incluimos el fichero de la clase*/
require_once 'connections/db.php';
require_once 'helpers/CommonHelper.php';
include_once("models/DAO/MateriaAsegurada_DAO.php");
require "lib/phpmailer/class.phpmailer.php";

class InsuredMatterController {

    public $model;

    public function __construct()
    {
        $this->model = new MateriaAsegurada_DAO();
    }

    public function index() {
        $materiasAseguradas = $this->model->getInsuredMattersList();
        require_once('views/insuredmatter/index.php');
    }

    public function newInsuredMatter() {
        require_once('views/insuredmatter/newInsuredMatter.php');
    }

    public function createNewInsuredMatter() {
        $materiaAsegurada = isset($_GET['materiaAsegurada']) ? $_GET['materiaAsegurada'] : null;

        return $this->model->newInsuredMatter($materiaAsegurada);
    }

    public function insuredMatterEdit() {
        $idMateriaAsegurada = isset($_GET['idMateriaAsegurada']) ? $_GET['idMateriaAsegurada'] : null;
        $materiaAsegurada = $this->model->getInsuredMatter($idMateriaAsegurada);

        require_once('views/insuredmatter/insuredMatterEdit.php');
    }

    public function insuredMatterEdit2db() {
        $idMateriaAsegurada = isset($_GET['idMateriaAsegurada']) ? $_GET['idMateriaAsegurada'] : null;
        $materiaAsegurada = isset($_GET['materiaAsegurada']) ? $_GET['materiaAsegurada'] : null;

        return $this->model->editInsuredMatter($idMateriaAsegurada, $materiaAsegurada);
    }

    public function deleteInsuredMatter() {
        $idMateriaAsegurada = isset($_GET['idMateriaAsegurada']) ? $_GET['idMateriaAsegurada'] : null;

        return $this->model->deleteInsuredMatter($idMateriaAsegurada);
    }

    public function error() {
        require_once('views/error/error.php');
    }

}