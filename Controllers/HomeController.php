<?php

class HomeController {

public $model;

    public function index() {
        require_once('views/home/index.php');
    }

    public function unidades() {
        require_once('views/vigat/unidades.php');
    }


    public function error() {
        require_once('views/error/error.php');
    }

}