<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 30-03-2016
 * Time: 0:30
 */

    //Inicio de variables de sesión
    if (!isset($_SESSION)) {
        @session_start();
    }

?>

<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="index.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">S<b>S</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">Singular Seguros</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

    </nav>
</header>