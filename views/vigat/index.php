<?php ?>

<!-- Content Header (Page header) -->
<section class="content-header">

    <h1 class="unidades">
        Unidades
        <small>VigaT</small>
    </h1>
    <ol class="breadcrumb unidades">
        <li><a href="#"><i class="fa fa-dashboard"></i> VigaT</a></li>
        <li class="active">Unidades</li>
    </ol>

    <h1 class="propmateriales">
        Propiedades de los Materiales
        <small>Viga T</small>
    </h1>
    <ol class="breadcrumb propmateriales">
        <li><a href="#"><i class="fa fa-dashboard"></i> Viga T</a></li>
        <li class="active">Propiedades de los Materiales</li>
    </ol>

    <h1 class="asignarseccion">
        Asignar Sección
        <small>VigaT</small>
    </h1>
    <ol class="breadcrumb asignarseccion">
        <li><a href="#"><i class="fa fa-dashboard"></i> VigaT</a></li>
        <li class="active">Asignar Sección</li>
    </ol>

    <h1 class="cargas">
        Cargas
        <small>VigaT</small>
    </h1>
    <ol class="breadcrumb cargas">
        <li><a href="#"><i class="fa fa-dashboard"></i> VigaT</a></li>
        <li class="active">Cargas</li>
    </ol>

</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div id="datos" class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Ingresa datos</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form name="formUnidades" id="formUnidades" class="form-horizontal unidades">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Longitud</label>
                            <div class="col-sm-10">
                                <label class="radio-inline"><input type="radio" name="optradioL" value="cm" checked>cm</label>
                                <label class="radio-inline"><input type="radio" name="optradioL">m</label>
                                <label class="radio-inline"><input type="radio" name="optradioL">pulg</label>
                                <label class="radio-inline"><input type="radio" name="optradioL">pie</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Fuerza</label>
                            <div class="col-sm-10">
                                <label class="radio-inline"><input type="radio" name="optradioF" checked>Kgf</label>
                                <label class="radio-inline"><input type="radio" name="optradioF">Tonf</label>
                                <label class="radio-inline"><input type="radio" name="optradioF">N</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Momento</label>
                            <div class="col-sm-10">
                                <label class="radio-inline"><input type="radio" name="optradioM" checked>Kgf · cm</label>
                                <label class="radio-inline"><input type="radio" name="optradioM">Kgf· m</label>
                                <label class="radio-inline"><input type="radio" name="optradioM">Ton· cm</label>
                                <label class="radio-inline"><input type="radio" name="optradioM">Ton· m</label>
                                <label class="radio-inline"><input type="radio" name="optradioM">N· cm</label>
                                <label class="radio-inline"><input type="radio" name="optradioM">N· m</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Tensión</label>
                            <div class="col-sm-10">
                                <label class="radio-inline"><input type="radio" name="optradioT" value="Kgf/cm2" checked>Kgf/cm2</label>
                                <label class="radio-inline"><input type="radio" name="optradioT" value="Mpa">Mpa</label>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <input type="button" id="unidadesNext" class="btn btn-primary pull-right" value="Siguiente">
                    </div><!-- /.box-footer -->
                </form>

                <form name="formMateriales" id="formMateriales" class="form-horizontal propmateriales">
                    <div class="box-body">
                        <label>ACERO</label>
                        <div class="form-group">
                            <label for="fy" class="col-sm-2 control-label">fy</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="fy" id="fy" placeholder="cm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ES" class="col-sm-2 control-label">Es</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Es" id="Es" placeholder="cm">
                            </div>
                        </div>
                        <label>HORMIGÓN</label>
                        <div class="form-group">
                            <label for="Grado" class="col-sm-2 control-label">Grado</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Grado" id="Grado" placeholder="Grado">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fc" class="col-sm-2 control-label">fc'</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="fc" id="fc" placeholder="cm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Ec" class="col-sm-2 control-label">Ec</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Ec" id="Ec" placeholder="cm">
                            </div>
                        </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <input type="button" id="propmaterialesNext" class="btn btn-primary pull-right" value="Siguiente">
                    </div><!-- /.box-footer -->
                </form>

                <form name="formSeccion" id="formSeccion" class="form-horizontal asignarseccion">
                    <div class="box-body">
                        <label>GEOMETRÍA</label>
                        <div class="form-group">
                            <label for="b" class="col-sm-2 control-label">b</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="b" id="b" placeholder="cm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bw" class="col-sm-2 control-label">bw</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="bw" id="bw" placeholder="cm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="h" class="col-sm-2 control-label">h</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="h" id="h" placeholder="cm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hf" class="col-sm-2 control-label">hf</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="hf" id="hf" placeholder="cm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="r" class="col-sm-2 control-label">r</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="r" id="r" placeholder="cm">
                            </div>
                        </div>
                        <label>REFUERZOS</label>
                        <div class="form-group">
                            <label for="optradioR" class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                <label class="radio-inline"><input type="radio" name="optradioR" value="1" checked>Verificar</label>
                                <label class="radio-inline"><input type="radio" name="optradioR" value="2" ">Diseñar</label>
                            </div>
                        </div>

                        <div id="contenido_a_mostrar">
                            <label>Refuerzo transversal</label>
                            <div class="form-group">
                                <label for="Av" class="col-sm-2 control-label">Av</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="Av" id="Av" placeholder="cm2">
                                </div>
                            </div>
                            <label>Distribución refuerzo longitudinal</label>
                            <div class="form-group">
                                <label for="n" class="col-sm-2 control-label">n</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="n" id="n" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="As1" class="col-sm-2 control-label">As1</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="As1" id="As1" placeholder="cm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Asn" class="col-sm-2 control-label">Asn</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="Asn" id="Asn" placeholder="cm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="d1" class="col-sm-2 control-label">d1</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="d1" id="d1" placeholder="cm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dn" class="col-sm-2 control-label">dn</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="dn" id="dn" placeholder="cm">
                                </div>
                            </div>
                        </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <input type="button" id="asignarseccionNext" class="btn btn-primary pull-right" value="Siguiente">
                    </div><!-- /.box-footer -->
                </form>

                <form name="formCargas" id="formCargas" class="form-horizontal cargas">
                    <div class="box-body">
                        <label>SOLICITACIONES</label>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Mu</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Mu" id="Mu" placeholder="Unidad de momento">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Vu</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Vu" id="Vu" placeholder="Unidad de fuerza">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                                        Diseño Sísmico
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" >
                                        Sin Diseño Sísmico
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <input type="button" id="cargasNext" class="btn btn-primary pull-right" value="Calcular">
                    </div><!-- /.box-footer -->
                </form>

                <div id="respuesta"></div>

            </div><!-- /.box -->
        </div><!-- /.col (left) -->
        <div id="dibujo" class="col-md-6">
            <canvas id="c" class="upper-canvas " width="600" height="500" style="position: absolute; width: 600px; height: 500px; left: 0; top: 0; -webkit-user-select: none; cursor: default;"></canvas>
        </div>
        <div id="resultado" class="col-md-12">

        </div>
    </div>

</section><!-- /.content -->





<script>

    $('#resultado').hide();

    var Nombre;
    var UniLongitud;
    var UniFuerza;
    var UniMomento;
    var UniTension;
    var AceroFy;
    var AceroES;
    var HormGrado;
    var HormFc;
    var HormEc;
    var GeoB;
    var GeoBw;
    var GeoH;
    var GeoHf;
    var GeoR;
    var Refuerzos;
    var RefTransAv;
    var RefLongN;
    var RefLongAs1;
    var RefLongAsn;
    var RefLongD1;
    var RefLongDn;
    var Mu;
    var Vu;
    var DisenoSismico;

    $( ".propmateriales" ).hide();
    $( ".asignarseccion" ).hide();
    $( ".cargas" ).hide();

    $('#unidadesNext').click(function() {
        $( ".unidades" ).hide();
        $( ".propmateriales" ).show();
        $( ".asignarseccion" ).hide();
        $('#respuesta').hide();

        UniLongitud = $('input[name=optradioL]:checked').val();
        UniFuerza = $('input[name=optradioF]:checked').val();
        UniMomento = $('input[name=optradioM]:checked').val();
        UniTension = $('input[name=optradioT]:checked').val();

        $('#fy').attr("placeholder", UniTension);
        $('#Es').attr("placeholder", UniTension);
        $('#fc').attr("placeholder", UniTension);
    });

    $('#propmaterialesNext').click(function() {

        //validacion
        AceroFy = $('#fy').val();
        AceroES = $('#Es').val();
        HormGrado = $('#Grado').val();
        HormFc = $('#fc').val();

        if(AceroFy != '' && AceroES != '' && HormGrado != '' && HormFc != '')
        {
            $( ".unidades" ).hide();
            $( ".propmateriales" ).hide();
            $( ".asignarseccion" ).show();
            $( ".cargas" ).hide();
            $('#respuesta').hide();
        }
        else {
            $('#respuesta').show().html('Debes completar todos los datos');
        }

    });

    $('#asignarseccionNext').click(function() {

        //validacion
        GeoB = $('#b').val();
        GeoBw = $('#bw').val();
        GeoH = $('#h').val();
        GeoHf = $('#hf').val();
        GeoR = $('#r').val();
        Refuerzos = $('input[name=optradioR]:checked').val();
        RefLongN = $('#n').val();
        RefTransAv = $('#Av').val();
        RefLongAs1 = $('#As1').val();
        RefLongAsn = $('#Asn').val();
        RefLongD1 = $('#d1').val();
        RefLongDn = $('#dn').val();

        if(GeoB != '' && GeoBw != '' && GeoH != '' && GeoHf != '' &&
            GeoR != '' && ((Refuerzos == 1 ) || (Refuerzos == 2 && RefLongN != '' && RefTransAv != '' && RefLongAs1 != '' &&
            RefLongAsn != '' && RefLongD1 != '' && RefLongDn != '')))
        {
            $( ".unidades" ).hide();
            $( ".propmateriales" ).hide();
            $( ".asignarseccion" ).hide();
            $( ".cargas" ).show();
            $('#respuesta').hide();
        }
        else {
            $('#respuesta').show().html('Debes completar todos los datos');
        }

    });

    $('#cargasNext').click(function() {

        //validacion
        Mu = $('#Mu').val();
        Vu = $('#Vu').val();
        DisenoSismico = $('#optionsRadios1').val();

        if(Mu != '' && Vu != '')
        {
            $('#respuesta').hide();

            var e = 'ajax.php?controller=VigaT&action=calculate'; console.debug(e);
            var data = { b: GeoB, bw:GeoBw, h: GeoH, hf: GeoHf, r: GeoR, fc: HormFc, fy: AceroFy, Es: AceroES, Mu: Mu, Vu: Vu, n: RefLongN }; console.debug(data);

            $.ajax({
                type: 'GET',
                url: e,
                data: data,
                dataType : "json",
                beforeSend: function () {
                    console.debug("Before");
                    $('#cargasNext').html("Cargando...");
                },
                success: function (data) {
                    console.log(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);

                    if(data.status == "success"){
                        console.log("Success");
                        console.log(JSON.stringify(data));
                        //$('#resultado').html(JSON.stringify(data));

                        $.each(data, function(i, v) {
                            // For each record in the returned array

                            if(i != "status")
                            {
                                console.log(i);
                                console.log(v);
                                $('#resultado').append("<p>").append(i).append(" = ").append(v).append("</p>");
                            }

                        });

                        $('#resultado').show();
                        $('#datos').hide();
                        $('#dibujo').hide();
                        $('#cargasNext').html('Calcular');
                    }
                    else{
                        $('#cargasNext').html("Agregar");
                        //$('#messageNewCliente').html('<div class="alert alert-danger" role="alert"><strong>Error! </strong>' + data.message + '</div>');
                    }
                    return false;
                },
                error: function (data) {
                    console.debug("Error");
                    console.debug(data);
                    //var returnedData = JSON.parse(data); console.debug(returnedData);
                    $('#cargasNext').html("Agregar");
                    return false;
                }
            });
        }
        else {
            $('#respuesta').show().html('Debes completar todos los datos');
        }

    });



    $('input[type=radio][name=optradioR]').change(function() {
        if (this.value == '1') {
            $('#contenido_a_mostrar').show();
        }
        else if (this.value == '2') {
            $('#contenido_a_mostrar').hide();
        }
    });


    // Place script tags at the bottom of the page.
    // That way progressive page rendering and
    // downloads are not blocked.

    // Run only when HTML is loaded and
    // DOM properly initialized (courtesy jquery)
    $(function() {
        var canvas = this.__canvas = new fabric.Canvas('c');

        var HH = 100;
        var HV = 250;

        var start2Points = [
            {x: 0, y: 0},
            {x: 0, y: 50},
            {x: 100, y: 50},
            {x: 100, y: 250},
            {x: 150, y: 250},
            {x: 150, y: 50},
            {x: 250, y: 50},
            {x: 250, y: 0}
        ];

        var startPoints = [
            {x: 0, y: 0},
            {x: 0, y: 50},
            {x: 100, y: 50},
            {x: 100, y: 150},
            {x: 150, y: 150},
            {x: 150, y: 50},
            {x: 250, y: 50},
            {x: 250, y: 0}
        ];

        var clonedStartPoints = startPoints.map(function(o){
            return fabric.util.object.clone(o);
        });

        var polygon = new fabric.Polygon(clonedStartPoints, {
            left: 200,
            top: 200,
            fill: 'rgba(42, 44, 44, 0.9)',
            selectable: false
        });
        canvas.add(polygon);

        var circ1 = new fabric.Circle({
            radius: 5, fill: 'white', left: 190, top: 260
        });
        canvas.add(circ1);

        var circ2 = new fabric.Circle({
            radius: 5, fill: 'white', left: 210, top: 260
        });
        canvas.add(circ2);

        /*var rect = new fabric.Rect({
         left: 150,
         top: 200,
         originX: 'left',
         originY: 'top',
         width: 150,
         height: 60,
         angle: 0,
         fill: 'rgba(255,0,0,0.5)',
         transparentCorners: false
         });

         canvas.add(rect).setActiveObject(rect);*/

        function observeBoolean(property) {
            document.getElementById(property).onclick = function() {
                canvas.item(0)[property] = this.checked;
                canvas.renderAll();
            };
        }

        function observeNumeric(property) {
            document.getElementById(property).onchange = function() {
                canvas.item(0)[property] = this.value;
                canvas.renderAll();
            };
        }

        function observeOptionsList(property) {
            var list = document.querySelectorAll('#' + property +
                ' [type="checkbox"]');
            for (var i = 0, len = list.length; i < len; i++) {
                list[i].onchange = function() {
                    canvas.item(0)[property](this.name, this.checked);
                    canvas.renderAll();
                };
            }
        }

        /*observeBoolean('hasControls');
        observeBoolean('hasBorders');
        observeBoolean('hasRotatingPoint');
        observeBoolean('visible');
        observeBoolean('selectable');
        observeBoolean('evented');
        observeBoolean('transparentCorners');
        observeBoolean('centeredScaling');
        observeBoolean('centeredRotation');

        observeNumeric('padding');
        observeNumeric('cornerSize');
        observeNumeric('rotatingPointOffset');
        observeNumeric('borderColor');
        observeNumeric('cornerColor');

        observeOptionsList('setControlVisible');*/
    });

</script>