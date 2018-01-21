<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 30-03-2016
 * Time: 0:42
 */
?>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-theme-demo-options-tab" data-toggle="tab"><i class="fa fa-wrench"></i></a></li>
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li class="active"><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Mi Empresa</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="index.php?controller=InsuranceBroker&action=myInsuranceBroker">
                        <i class="menu-icon fa fa-building-o bg-yellow"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Corredora</h4>

                            <p>Editar</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=User&action=insuranceUsers">
                        <i class="menu-icon fa fa-users bg-orange"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Usuarios</h4>

                            <p>Editar</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <div id="control-sidebar-theme-demo-options-tab" class="tab-pane">
            <h3 class="control-sidebar-heading">Empresas Externas</h3>
            <ul class="control-sidebar-menu">
                <?php if($isSuperAdmin ): ?>
                <li>
                    <a href="index.php?controller=Company&action=index">
                        <i class="menu-icon fa fa-building bg-red"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Compañia</h4>

                            <p>Editar</p>
                        </div>
                    </a>
                </li>
                <?php endif; ?>

                <li>
                    <a href="index.php?controller=InsuranceBroker&action=index">
                        <i class="menu-icon fa fa-users bg-light-blue"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Clientes</h4>

                            <p>Editar</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane active" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading">Mantenedores</h3>

                <?php if($isSuperAdmin ): ?>
                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <a href="index.php?controller=MerchandiseType&action=index">Tipos de Mercadería</a>
                    </label>
                </div>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <a href="index.php?controller=InsuredMatter&action=index">Materia Asegurada</a>
                    </label>
                </div>


                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <a href="index.php?controller=Packing&action=index">Embalaje</a>
                    </label>
                </div>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <a href="index.php?controller=User&action=index">Usuarios</a>
                    </label>
                </div>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <a href="index.php?controller=Policy&action=index">Polizas</a>
                    </label>
                </div>

                <?php endif; ?>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <a href="index.php?controller=JobTitle&action=index">Cargos</a>
                    </label>
                </div>

            </form>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
