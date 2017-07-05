<?php
  //require_once('connections/db.php');

  if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action     = $_GET['action'];

    require_once('views/routes.php');
  } else {
    exit();
  }

?>