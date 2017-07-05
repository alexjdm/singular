<?php
  //require_once('connections/db.php');

    if (isset($_GET['controller']) && isset($_GET['action'])) {
        $controller = $_GET['controller'];
        $action     = $_GET['action'];
    } else {
        $controller = 'Home';
        $action     = 'index';
        //$controller = 'Account';
        //$action     = 'login';
    }

    if($controller == 'Home' || $controller == 'VigaT' || $controller == 'VigaRectangular' || $controller == 'PilarRectangular')
    {
        //require_once('views/routes.php');
        require_once('views/layout.php');
    }
    else
    {
        require_once('views/layout.php');
    }