<?php
require_once("businesslogic/Certificate.php");
require_once("businesslogic/Insured.php");
require_once("businesslogic/Guarantee.php");
require_once("businesslogic/Sinister.php");

$certificateBusiness = new Certificate();
$notificacionSolicitud = $certificateBusiness -> getNumberRequest();
$notificacionAnulacion = $certificateBusiness -> getNumberAnnulments();
$notificacionModificacion = $certificateBusiness -> getNumberModifies();

$insuredBusiness = new Insured();
$notificacionAsegurado = $insuredBusiness -> getNumberRequest();

$guaranteeBusiness = new Guarantee();
$notificacionGarantia = $guaranteeBusiness -> getNumberRequest();

$sinisterBusiness = new Sinister();
$notificacionSiniestro = $sinisterBusiness -> getNumberRequest();
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
                <p><?php echo $usuario['nombre'] . ' ' . $usuario['apellido'] ?></p>
                <!-- Company -->
                <a href="#"><i class="fa fa-building-o" aria-hidden="true"></i> <?php echo $corredora['nombre'] ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu tree" data-widget="tree">

            <li class="header">Certificado</li>
            <li class="<?php if($controller=='Certificate' && $action == 'request'){ echo 'active'; } ?>"><a href="index.php?controller=Certificate&action=request"><i class="fa fa-link"></i> <span>Solicitar</span> <?php if($notificacionSolicitud > 0) { echo '<span class="pull-right-container"><small class="label pull-right bg-green">' . $notificacionSolicitud . '</small></span>'; } ?></a></li>
            <li class="<?php if($controller=='Certificate' && $action == 'annulments'){ echo 'active'; } ?>"><a href="index.php?controller=Certificate&action=annulments"><i class="fa fa-link"></i> <span>Anulaciones</span> <?php if($notificacionAnulacion > 0) { echo '<span class="pull-right-container"><small class="label pull-right bg-green">' . $notificacionAnulacion . '</small></span>'; } ?></a></li>
            <li class="<?php if($controller=='CertificateModify' && $action == 'index'){ echo 'active'; } ?>"><a href="index.php?controller=CertificateModify&action=index"><i class="fa fa-link"></i> <span>Modificaciones</span> <?php if($notificacionModificacion > 0) { echo '<span class="pull-right-container"><small class="label pull-right bg-green">' . $notificacionModificacion . '</small></span>'; } ?></a></li>

            <li class="header">Solicitudes</li>
            <li class="<?php if($controller=='GuaranteePolicy' && $action == 'index'){ echo 'active'; } ?>"><a href="index.php?controller=GuaranteePolicy&action=index"><i class="fa fa-link"></i> <span>Garantías</span> <?php if($notificacionGarantia > 0) { echo '<span class="pull-right-container"><small class="label pull-right bg-green">' . $notificacionGarantia . '</small></span>'; } ?></a></li>
            <li class="<?php if($controller=='Sinister' && $action == 'index'){ echo 'active'; } ?>"><a href="index.php?controller=Sinister&action=index"><i class="fa fa-link"></i> <span>Siniestros</span> <?php if($notificacionSiniestro > 0) { echo '<span class="pull-right-container"><small class="label pull-right bg-green">' . $notificacionSiniestro . '</small></span>'; } ?></a></li>
            <li class="<?php if($controller=='Insured' && $action == 'index'){ echo 'active'; } ?>"><a href="index.php?controller=Insured&action=index"><i class="fa fa-link"></i> <span>Asegurados</span> <?php if($notificacionAsegurado > 0) { echo '<span class="pull-right-container"><small class="label pull-right bg-green">' . $notificacionAsegurado . '</small></span>'; } ?></a></li>

            <li class="header">Reportes</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="<?php if($controller=='Certificate' && $action == 'index'){ echo 'active'; } ?>"><a href="index.php?controller=Certificate&action=index"><i class="fa fa-link"></i> <span>Certificados</span></a></li>
            <li class="<?php if($controller=='Insurance' && $action == 'index'){ echo 'active'; } ?>"><a href="index.php?controller=Insurance&action=index"><i class="fa fa-link"></i> <span>Seguros</span></a></li>
            <!--<li class="<?php if($controller=='Company' && $action == 'index'){ echo 'active'; } ?>"><a href="index.php?controller=Company&action=index"><i class="fa fa-link"></i> <span>Compañía</span></a></li>-->
            <!--<li class="<?php if($controller=='InsuranceBroker' && $action == 'index'){ echo 'active'; } ?>"><a href="index.php?controller=InsuranceBroker&action=index"><i class="fa fa-link"></i> <span>Corredoras</span></a></li>-->
            <!--<li class="<?php if($controller=='Client' && $action == 'index'){ echo 'active'; } ?>"><a href="index.php?controller=Client&action=index"><i class="fa fa-link"></i> <span>Clientes</span></a></li>-->
            <!--<li class="<?php if($controller=='JobTitle' && $action == 'index'){ echo 'active'; } ?>"><a href="index.php?controller=JobTitle&action=index"><i class="fa fa-link"></i> <span>Cargos</span></a></li>-->
            <!--<li class="<?php if($controller=='User' && $action == 'sellers'){ echo 'active'; } ?>"><a href="index.php?controller=User&action=sellers"><i class="fa fa-link"></i> <span>Vendedores</span></a></li>-->
            <!--<li class="<?php if($controller=='Policy' && $action == 'index'){ echo 'active'; } ?>"><a href="index.php?controller=Policy&action=index"><i class="fa fa-link"></i> <span>Polizas</span></a></li>-->
            <!--<li class="<?php if($controller=='MerchandiseType' && $action == 'index'){ echo 'active'; } ?>"><a href="index.php?controller=MerchandiseType&action=index"><i class="fa fa-link"></i> <span>Tipos de Mercadería</span></a></li>-->

            <li class="header">Estadísticas</li>

        </ul><!-- /.sidebar-menu -->

    </section>
    <!-- /.sidebar -->
</aside>
