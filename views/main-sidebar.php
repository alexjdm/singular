<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 30-03-2016
 * Time: 0:32
 */
?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Luis Mansilla</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Menú</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="<?php if($controller=='VigaT'){ echo 'active'; } ?>"><a href="index.php?controller=VigaT&action=index"><i class="fa fa-link"></i> <span>Viga T</span></a></li>
            <li class="<?php if($controller=='VigaRectangular'){ echo 'active'; } ?>"><a href="index.php?controller=VigaRectangular&action=index"><i class="fa fa-link"></i> <span>Viga Rect</span></a></li>
            <li class="<?php if($controller=='PilarRectangular'){ echo 'active'; } ?>"><a href="index.php?controller=PilarRectangular&action=index"><i class="fa fa-link"></i> <span>Pilar Rect</span></a></li>
        </ul><!-- /.sidebar-menu -->

    </section>
    <!-- /.sidebar -->
</aside>
