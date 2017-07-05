<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
    <?php require_once('header.php'); ?>

    <div class="modal fade" id="modalPrincipal"></div>
    <div class="modal fade" id="modalConfirmacion"></div>
    <div class="modal fade" id="modalSubmodal"></div>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require_once('main-header.php'); ?>

            <?php require_once('main-sidebar.php'); ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <?php require_once('routes.php'); ?>
            </div><!-- /.content-wrapper -->

            <?php require_once('footer.php'); ?>

            <?php //require_once('control-sidebar.php'); ?>

        </div>

    </body>

</html>