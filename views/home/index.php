<section class="content-header">

    <h1>
        Sistema de Cálculo
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">index</li>
    </ol>

</section>

<section class="content">

    <div class="row">


        <h1 class="text-center">Bienvenido al sistema de cálculo</h1>
        <p class="text-center">Por favor, seleccione un tipo de estructura.</p>

        <div class="col-md-6 col-sm-12 text-center">
            <div class="single-about-detail">

                <div class="about-details">
                    <div class="pentagon-text">
                        <h1><i class="fa fa-bars"></i></h1>
                    </div>

                    <h3>Ingreso Sección</h3>
                    <p>Seleccione el tipo de estructura a utilizar:</p>
                    <br>
                    <button type="button" class="btn btn-default" onclick="window.location.href='index.php?controller=VigaRectangular&action=index'">VIGA RECTANGULAR</button>
                    <button type="button" class="btn btn-default" onclick="window.location.href='index.php?controller=VigaT&action=index'">VIGA T</button>
                    <button type="button" class="btn btn-default" onclick="window.location.href='index.php?controller=PilarRectangular&action=index'">PILAR RECTANGULAR</button>
                    <br><br><br>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-sm-12 text-center">
            <div class="single-about-detail">

                <div class="about-details">
                    <div class="pentagon-text">
                        <h1><i class="fa fa-file-excel-o"></i></h1>
                    </div>

                    <h3>Carga de documento</h3>
                    <p>Ingresar datos desde un archivo Excel.</p>
                    <br>
                    <center><input type="file" class="btn btn-default btn-xs" id="inputfile"></center>
                    <br><br>
                </div>
            </div>
        </div>


    </div>

</section><!-- /.content -->