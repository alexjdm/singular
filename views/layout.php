<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 30-03-2016
 * Time: 0:30
 */

//error_reporting(E_ALL);
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);
ini_set('memory_limit', '-1');

require_once 'helpers/SessionHelper.php';

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    @session_start();
}

//Validación de sesión.
if(empty($_SESSION['id']))
{
    // Go to login
    header('Location: index.php?controller=Account&action=login');
    exit();
}

$usuario = getCurrentUser();
$isSuperAdmin = isSuperAdmin();
$corredora = getCurrentInsuranceBroker();
//echo $usuario;
//echo $corredora;

?>

<!DOCTYPE html>
<html>
    <?php require_once('header.php'); ?>

    <div class="modal fade" id="modalPrincipal"></div>
    <div class="modal fade" id="modalConfirmacion"></div>
    <div class="modal fade" id="modalSubmodal"></div>

    <body class="hold-transition skin-red sidebar-mini">
        <div class="wrapper">
            <?php require_once('main-header.php'); ?>

            <?php require_once('main-sidebar.php'); ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <?php require_once('routes.php'); ?>
            </div><!-- /.content-wrapper -->

            <?php require_once('footer.php'); ?>

            <?php require_once('control-sidebar.php'); ?>

        </div>

    </body>

</html>