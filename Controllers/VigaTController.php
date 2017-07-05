<?php

include_once("BusinessLogic/VigaT.php");

class VigaTController {

    public $BLVigaT;

    public function __construct()
    {
        $this->BLVigaT = new VigaT();
    }

    public function index() {
        require_once('views/vigat/index.php');
    }

    public function calculate() {

        //return $this->BLVigaT->checkVigaT();
        return $this->BLVigaT->checkCorteVigaT();
    }

    public function error() {
        require_once('views/error/error.php');
    }

}