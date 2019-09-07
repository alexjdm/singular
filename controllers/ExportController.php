<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 01-03-2018
 * Time: 14:42
 */

require_once 'connections/db.php';
//require_once 'helpers/CommonHelper.php';
require_once("businesslogic/InsuranceBroker.php");
require_once("businesslogic/Sinister.php");
include_once("businesslogic/Usuario.php");
include_once("businesslogic/InsuranceBroker.php");
include_once("businesslogic/Company.php");
include_once("businesslogic/MerchandiseType.php");
include_once("businesslogic/Policy.php");
include_once("businesslogic/Certificate.php");
include_once("businesslogic/Insured.php");
include_once("businesslogic/Insurance.php");
//require "lib/php-export-data/php-export-data.class.php";
require "lib/PHPExcel-1.8/Classes/PHPExcel.php";

class ExportController {

    public function ExportUsers()
    {
        $insuranceBrokerBusiness = new InsuranceBroker();
        $clientes = $insuranceBrokerBusiness->getClientsForCurrentUser();

        $objPHPExcel = new PHPExcel();

        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("alexjdm") // Nombre del autor
        ->setLastModifiedBy("SingularAdmin") //Ultimo usuario que lo modificó
        ->setTitle("Lista de Clientes"); // Titulo
        /*->setSubject("Reporte Excel con PHP y MySQL") //Asunto
        ->setDescription("Reporte de alumnos") //Descripción
        ->setKeywords("reporte alumnos carreras") //Etiquetas
        ->setCategory("Reporte excel"); //Categorias*/

        $titulosColumnas = array('N°', 'RUT', 'NOMBRE', 'DIRECCION', 'CIUDAD', 'TELEFONO', 'GIRO', 'RAZON SOCIAL', 'TASA', 'PRIMA MIN', 'VENDEDOR');

        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);

        // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1',  $titulosColumnas[0])  //Titulo de las columnas
            ->setCellValue('B1',  $titulosColumnas[1])
            ->setCellValue('C1',  $titulosColumnas[2])
            ->setCellValue('D1',  $titulosColumnas[3])
            ->setCellValue('E1',  $titulosColumnas[4])
            ->setCellValue('F1',  $titulosColumnas[5])
            ->setCellValue('G1',  $titulosColumnas[6])
            ->setCellValue('H1',  $titulosColumnas[7])
            ->setCellValue('I1',  $titulosColumnas[8])
            ->setCellValue('J1',  $titulosColumnas[9])
            ->setCellValue('K1',  $titulosColumnas[10]);

        $objPHPExcel->getActiveSheet()->setTitle('Clientes');

        $i = 2; //Numero de fila donde se va a comenzar a rellenar
        $contador = 1;
        foreach ($clientes as $cliente):
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $contador)
                ->setCellValue('B'.$i, $cliente['RUT'])
                ->setCellValue('C'.$i, $cliente['NOMBRE'])
                ->setCellValue('D'.$i, $cliente['DIRECCION'])
                ->setCellValue('E'.$i, $cliente['CIUDAD'])
                ->setCellValue('F'.$i, $cliente['TELEFONO'])
                ->setCellValue('G'.$i, $cliente['GIRO'])
                ->setCellValue('H'.$i, $cliente['RAZON_SOCIAL'])
                ->setCellValue('I'.$i, $cliente['TASA'])
                ->setCellValue('J'.$i, $cliente['PRIMA_MIN'])
                ->setCellValue('K'.$i, $cliente['VENDEDOR']);
            $i++;
            $contador++;
        endforeach;

        for($i = 'A'; $i <= 'K'; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
        }

        // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="listado_clientes.xlsx"');
        header('Cache-Control: max-age=0');

        $filePath = 'http://www.singularseguros.cl/admin/temp/listado_clientes.xlsx';
        //echo $filePath;
        try{
            /*$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            //$objWriter->save($filePath);
            //$objWriter->save(str_replace(__FILE__,$_SERVER['DOCUMENT_ROOT'] .'/path/to/save/filename.xlsx',__FILE__));
            $objWriter->save('php://output');*/

            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            ob_start();
            $objWriter->save("php://output");
            $xlsData = ob_get_contents();
            ob_end_clean();

            $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );

            die(json_encode($response));

            /*$response = array(
                'status' => 'success',
                'url' => $filePath
            );
            echo json_encode($response);*/
        }
        catch (PHPExcel_Writer_Exception $e)
        {
            echo "error";
            $response = array(
                'status' => 'error',
                'url' => $e
            );
            echo json_encode($response);
        }


        /*$exporter = new ExportDataExcel('browser', 'test.xls');

        $exporter->initialize();

        $exporter->addRow(array("This", "is", "a", "test"));
        $exporter->addRow(array(1, 2, 3, "123-456-7890"));

        $exporter->addRow(array("foo"));

        $exporter->finalize();

        //echo json_encode($exporter);

        //exit();*/
    }

    public function ExportSinisterStadistic()
    {
        $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;
        //$fecha = '14-11-2018 al 21-11-2018';
        if($fecha == null)
        {
            $fechaInicio = date('Y-m-d', strtotime(date('Y-m-d'). ' - 7 days'));
            $fechaFin = date('Y-m-d');
        }
        else
        {
            $splitStr = explode(" ",$fecha);
            $fechaInicio = FormatearFechaEn($splitStr[0]);
            $fechaFin = FormatearFechaEn($splitStr[2]);

        }

        $siniestroBusiness = new Sinister();
        $salida = $siniestroBusiness -> getSinisterStadistic($fechaInicio, $fechaFin);

        if(isset($salida))
        {
            $siniestrosVM = $salida[0];
            $numeroCertificados = $salida[1];
            $montoAsegurado = $salida[2];
            $primaSeguro = $salida[3];
            $montoProvision = $salida[4];
            $indemnizacion = $salida[5];
        }

        $objPHPExcel = new PHPExcel();

        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("alexjdm") // Nombre del autor
        ->setLastModifiedBy("SingularAdmin") //Ultimo usuario que lo modificó
        ->setTitle("Estadística Siniestros"); // Titulo
        /*->setSubject("Reporte Excel con PHP y MySQL") //Asunto
        ->setDescription("Reporte de alumnos") //Descripción
        ->setKeywords("reporte alumnos carreras") //Etiquetas
        ->setCategory("Reporte excel"); //Categorias*/

        //$titulosColumnas = array('N°', 'Cliente', 'Asegurado', 'Mes', 'Fecha Solicitud', 'Monto Asegurado', 'Prima de Seguro', 'Prima Cliente', 'Prima Cía.', 'Profit Cliente', 'Comision Corredor', 'Diferencia Equal', 'Ingreso Equal', 'Comision Vendedor', 'Medio', 'Poliza', 'No. Cert.', 'Transbordo', 'Tipo Mercaderia', 'Ejecutivo', 'Cert', 'Factura');
        $titulosColumnas = array('N°', 'Cliente', 'Asegurado', 'Mes', 'Fecha Solicitud', 'Monto Asegurado', 'Prima Cía.', 'Poliza', 'No. Cert.', 'Ejecutivo', 'Siniestro', 'Motivo', 'Monto Provision', 'Fecha Denuncia', 'Indemnización');

        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);

        // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1',  $titulosColumnas[0])  //Titulo de las columnas
            ->setCellValue('B1',  $titulosColumnas[1])
            ->setCellValue('C1',  $titulosColumnas[2])
            ->setCellValue('D1',  $titulosColumnas[3])
            ->setCellValue('E1',  $titulosColumnas[4])
            ->setCellValue('F1',  $titulosColumnas[5])
            ->setCellValue('G1',  $titulosColumnas[6])
            ->setCellValue('H1',  $titulosColumnas[7])
            ->setCellValue('I1',  $titulosColumnas[8])
            ->setCellValue('J1',  $titulosColumnas[9])
            ->setCellValue('K1',  $titulosColumnas[10])
            ->setCellValue('L1',  $titulosColumnas[11])
            ->setCellValue('M1',  $titulosColumnas[12])
            ->setCellValue('N1',  $titulosColumnas[13])
            ->setCellValue('O1',  $titulosColumnas[14])
            /*->setCellValue('P1',  $titulosColumnas[15])
            ->setCellValue('Q1',  $titulosColumnas[16])
            ->setCellValue('R1',  $titulosColumnas[17])
            ->setCellValue('S1',  $titulosColumnas[18])
            ->setCellValue('T1',  $titulosColumnas[19])
            ->setCellValue('U1',  $titulosColumnas[20])
            ->setCellValue('V1',  $titulosColumnas[21])*/
        ;

        $objPHPExcel->getActiveSheet()->setTitle('Estadística Siniestros');

        $i = 2; //Numero de fila donde se va a comenzar a rellenar
        $contador = 1;
        foreach ($siniestrosVM as $siniestroVM):
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $contador)
                ->setCellValue('B'.$i, $siniestroVM['CLIENTE'])
                ->setCellValue('C'.$i, $siniestroVM['ASEGURADO'])
                ->setCellValue('D'.$i, $siniestroVM['MES'])
                ->setCellValue('E'.$i, $siniestroVM['FECHA_SOLICITUD'])
                ->setCellValue('F'.$i, $siniestroVM['MONTO_ASEGURADO'])
                ->setCellValue('G'.$i, $siniestroVM['PRIMA'])
                ->setCellValue('H'.$i, $siniestroVM['POLIZA'])
                ->setCellValue('I'.$i, $siniestroVM['NUMERO_CERTIFICADO'])
                ->setCellValue('J'.$i, $siniestroVM['EJECUTIVO'])
                ->setCellValue('K'.$i, $siniestroVM['SINIESTRO'])
                ->setCellValue('L'.$i, $siniestroVM['MOTIVO'])
                ->setCellValue('M'.$i, $siniestroVM['MONTO_PROVISION'])
                ->setCellValue('N'.$i, $siniestroVM['FECHA_DENUNCIA'])
                ->setCellValue('O'.$i, $siniestroVM['INDEMNIZACION'])
            ;
            $i++;
            $contador++;
        endforeach;

        // Totalizadores
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E'.$i, "Certificados")
            ->setCellValue('F'.$i, "Monto Asegurado")
            ->setCellValue('G'.$i, "Prima de Seguro")
            ->setCellValue('M'.$i, "Monto Provision")
            ->setCellValue('O'.$i, "Indemnización")
            ;
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E'.$i, $numeroCertificados)
            ->setCellValue('F'.$i, $montoAsegurado)
            ->setCellValue('G'.$i, $primaSeguro)
            ->setCellValue('M'.$i, $montoProvision)
            ->setCellValue('O'.$i, $indemnizacion)
        ;

        for($i = 'A'; $i <= 'O'; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
        }

        // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="listado_clientes.xlsx"');
        header('Cache-Control: max-age=0');

        try{

            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            ob_start();
            $objWriter->save("php://output");
            $xlsData = ob_get_contents();
            ob_end_clean();

            $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );

            die(json_encode($response));

        }
        catch (PHPExcel_Writer_Exception $e)
        {
            echo "error";
            $response = array(
                'status' => 'error',
                'url' => $e
            );
            echo json_encode($response);
        }

    }

    public function ExportClientTransport()
    {
        $certificadoBusiness = new Certificate();
        $salida = $certificadoBusiness -> getClientTransportStadistic();

        if(isset($salida))
        {
            $transportesVM = $salida[0];
            $numeroCertificados = $salida[1];
            $montoAsegurado = $salida[2];
            $primaSeguro = $salida[3];
            $primaCliente = $salida[4];
            $difCliente = $salida[5];
        }

        $objPHPExcel = new PHPExcel();

        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("alexjdm") // Nombre del autor
        ->setLastModifiedBy("SingularAdmin") //Ultimo usuario que lo modificó
        ->setTitle("Estadística Cliente"); // Titulo
        /*->setSubject("Reporte Excel con PHP y MySQL") //Asunto
        ->setDescription("Reporte de alumnos") //Descripción
        ->setKeywords("reporte alumnos carreras") //Etiquetas
        ->setCategory("Reporte excel"); //Categorias*/

        $titulosColumnas = array('N°', 'Asegurado', 'Mes', 'Fecha Solicitud', 'Monto Asegurado', 'Prima de Seguro', 'Prima Cliente', 'Profit Cliente', 'Medio', 'Poliza', 'No. Cert.', 'Transbordo', 'Tipo Mercadería', 'Ejecutivo', 'Cert', 'Fact');

        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);

        // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1',  $titulosColumnas[0])  //Titulo de las columnas
            ->setCellValue('B1',  $titulosColumnas[1])
            ->setCellValue('C1',  $titulosColumnas[2])
            ->setCellValue('D1',  $titulosColumnas[3])
            ->setCellValue('E1',  $titulosColumnas[4])
            ->setCellValue('F1',  $titulosColumnas[5])
            ->setCellValue('G1',  $titulosColumnas[6])
            ->setCellValue('H1',  $titulosColumnas[7])
            ->setCellValue('I1',  $titulosColumnas[8])
            ->setCellValue('J1',  $titulosColumnas[9])
            ->setCellValue('K1',  $titulosColumnas[10])
            ->setCellValue('L1',  $titulosColumnas[11])
            ->setCellValue('M1',  $titulosColumnas[12])
            ->setCellValue('N1',  $titulosColumnas[13])
            ->setCellValue('O1',  $titulosColumnas[14])
            ->setCellValue('P1',  $titulosColumnas[15])
        ;

        $objPHPExcel->getActiveSheet()->setTitle('Estadística Siniestros');

        $i = 2; //Numero de fila donde se va a comenzar a rellenar
        $contador = 1;
        foreach ($transportesVM as $transporteVM):
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $contador)
                ->setCellValue('B'.$i, $transporteVM['ASEGURADO'])
                ->setCellValue('C'.$i, $transporteVM['MES'])
                ->setCellValue('D'.$i, $transporteVM['FECHA_SOLICITUD'])
                ->setCellValue('E'.$i, $transporteVM['MONTO_ASEGURADO'])
                ->setCellValue('F'.$i, $transporteVM['PRIMA_SEGURO'])
                ->setCellValue('G'.$i, $transporteVM['PRIMA_CLIENTE'])
                ->setCellValue('H'.$i, $transporteVM['PROFIT_CLIENTE'])
                ->setCellValue('I'.$i, $transporteVM['MEDIO'])
                ->setCellValue('J'.$i, $transporteVM['POLIZA'])
                ->setCellValue('K'.$i, $transporteVM['NUMERO_CERTIFICADO'])
                ->setCellValue('L'.$i, $transporteVM['TRANSBORDO'])
                ->setCellValue('M'.$i, $transporteVM['TIPO_MERCADERIA'])
                ->setCellValue('N'.$i, $transporteVM['EJECUTIVO'])
                ->setCellValue('O'.$i, $transporteVM['FORMATO'])
                ->setCellValue('P'.$i, $transporteVM['FACTURA'])
            ;
            $i++;
            $contador++;
        endforeach;

        // Totalizadores
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D'.$i, "Certificados")
            ->setCellValue('E'.$i, "Monto Asegurado")
            ->setCellValue('F'.$i, "Prima de Seguro")
            ->setCellValue('G'.$i, "Prima Cliente")
            ->setCellValue('H'.$i, "Diferencia Cliente")
        ;
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D'.$i, $numeroCertificados)
            ->setCellValue('E'.$i, $montoAsegurado)
            ->setCellValue('F'.$i, $primaSeguro)
            ->setCellValue('G'.$i, $primaCliente)
            ->setCellValue('H'.$i, $difCliente)
        ;

        for($i = 'A'; $i <= 'O'; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
        }

        // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="listado_clientes.xlsx"');
        header('Cache-Control: max-age=0');

        try {

            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            ob_start();
            $objWriter->save("php://output");
            $xlsData = ob_get_contents();
            ob_end_clean();

            $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );

            die(json_encode($response));

        }
        catch (PHPExcel_Writer_Exception $e)
        {
            echo "error";
            $response = array(
                'status' => 'error',
                'url' => $e
            );
            echo json_encode($response);
        }

    }

    public function ExportSellerTransport()
    {
        $certificadoBusiness = new Certificate();
        $salida = $certificadoBusiness -> getSellerTransportStadistic();

        if(isset($salida))
        {
            $transportesVM = $salida[0];
            $numeroCertificados = $salida[1];
            $montoAsegurado = $salida[2];
            $primaSeguro = $salida[3];
            $primaCliente = $salida[4];
            $primaCia = $salida[5];
            $difCliente = $salida[6];
            $comisionCorredor = $salida[7];
            $difEqual = $salida[8];
            $ingresoEqual = $salida[9];
            $comisionVendedor = $salida[10];
        }

        $objPHPExcel = new PHPExcel();

        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("alexjdm") // Nombre del autor
        ->setLastModifiedBy("SingularAdmin") //Ultimo usuario que lo modificó
        ->setTitle("Estadística Vendedores"); // Titulo
        /*->setSubject("Reporte Excel con PHP y MySQL") //Asunto
        ->setDescription("Reporte de alumnos") //Descripción
        ->setKeywords("reporte alumnos carreras") //Etiquetas
        ->setCategory("Reporte excel"); //Categorias*/

        $titulosColumnas = array('N°', 'Cliente', 'Asegurado', 'Mes', 'Fecha Solicitud', 'Monto Asegurado', 'Prima de Seguro', 'Prima Cliente', 'Prima Cía.', 'Profit Cliente', 'Comision Corredor', 'Diferencia Equal', 'Ingreso Equal', 'Comision Vendedor', 'Medio', 'Poliza', 'No. Cert.', 'Transbordo', 'Tipo Mercaderia', 'Ejecutivo', 'Cert', 'Factura');

        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);

        // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1',  $titulosColumnas[0])  //Titulo de las columnas
            ->setCellValue('B1',  $titulosColumnas[1])
            ->setCellValue('C1',  $titulosColumnas[2])
            ->setCellValue('D1',  $titulosColumnas[3])
            ->setCellValue('E1',  $titulosColumnas[4])
            ->setCellValue('F1',  $titulosColumnas[5])
            ->setCellValue('G1',  $titulosColumnas[6])
            ->setCellValue('H1',  $titulosColumnas[7])
            ->setCellValue('I1',  $titulosColumnas[8])
            ->setCellValue('J1',  $titulosColumnas[9])
            ->setCellValue('K1',  $titulosColumnas[10])
            ->setCellValue('L1',  $titulosColumnas[11])
            ->setCellValue('M1',  $titulosColumnas[12])
            ->setCellValue('N1',  $titulosColumnas[13])
            ->setCellValue('O1',  $titulosColumnas[14])
            ->setCellValue('P1',  $titulosColumnas[15])
            ->setCellValue('Q1',  $titulosColumnas[16])
            ->setCellValue('R1',  $titulosColumnas[17])
            ->setCellValue('S1',  $titulosColumnas[18])
            ->setCellValue('T1',  $titulosColumnas[19])
            ->setCellValue('U1',  $titulosColumnas[20])
            ->setCellValue('V1',  $titulosColumnas[21])
        ;

        $objPHPExcel->getActiveSheet()->setTitle('Estadística Vendedor');

        $i = 2; //Numero de fila donde se va a comenzar a rellenar
        $contador = 1;
        foreach ($transportesVM as $transporteVM):
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $contador)
                ->setCellValue('B'.$i, $transporteVM['CLIENTE'])
                ->setCellValue('C'.$i, $transporteVM['ASEGURADO'])
                ->setCellValue('D'.$i, $transporteVM['MES'])
                ->setCellValue('E'.$i, $transporteVM['FECHA_SOLICITUD'])
                ->setCellValue('F'.$i, $transporteVM['MONTO_ASEGURADO'])
                ->setCellValue('G'.$i, $transporteVM['PRIMA_SEGURO'])
                ->setCellValue('H'.$i, $transporteVM['PRIMA_CLIENTE'])
                ->setCellValue('I'.$i, $transporteVM['PRIMA_CIA'])
                ->setCellValue('J'.$i, $transporteVM['PROFIT_CLIENTE'])
                ->setCellValue('K'.$i, $transporteVM['COMISION_CORREDOR'])
                ->setCellValue('L'.$i, $transporteVM['DIFERENCIA_EQUAL'])
                ->setCellValue('M'.$i, $transporteVM['INGRESO_EQUAL'])
                ->setCellValue('N'.$i, $transporteVM['COMISION_VENDEDOR'])
                ->setCellValue('O'.$i, $transporteVM['MEDIO'])
                ->setCellValue('P'.$i, $transporteVM['POLIZA'])
                ->setCellValue('Q'.$i, $transporteVM['NUMERO_CERTIFICADO'])
                ->setCellValue('R'.$i, $transporteVM['TRANSBORDO'])
                ->setCellValue('S'.$i, $transporteVM['TIPO_MERCADERIA'])
                ->setCellValue('T'.$i, $transporteVM['EJECUTIVO'])
                ->setCellValue('U'.$i, $transporteVM['FORMATO'])
                ->setCellValue('V'.$i, $transporteVM['FACTURA'])
            ;
            $i++;
            $contador++;
        endforeach;

        // Totalizadores
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E'.$i, "Certificados")
            ->setCellValue('F'.$i, "Monto Asegurado")
            ->setCellValue('G'.$i, "Prima de Seguro")
            ->setCellValue('H'.$i, "Prima Cliente")
            ->setCellValue('I'.$i, "Prima Cia.")
            ->setCellValue('J'.$i, "Diferencia Cliente")
            ->setCellValue('K'.$i, "Comisión Corredor")
            ->setCellValue('L'.$i, "Diferencia Equal")
            ->setCellValue('M'.$i, "Ingreso Equal")
            ->setCellValue('N'.$i, "Comisión Vendedor")
        ;
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E'.$i, $numeroCertificados)
            ->setCellValue('F'.$i, $montoAsegurado)
            ->setCellValue('G'.$i, $primaSeguro)
            ->setCellValue('H'.$i, $primaCliente)
            ->setCellValue('I'.$i, $primaCia)
            ->setCellValue('J'.$i, $difCliente)
            ->setCellValue('K'.$i, $comisionCorredor)
            ->setCellValue('L'.$i, $difEqual)
            ->setCellValue('M'.$i, $ingresoEqual)
            ->setCellValue('N'.$i, $comisionVendedor)
        ;

        for($i = 'A'; $i <= 'O'; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
        }

        // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="listado_clientes.xlsx"');
        header('Cache-Control: max-age=0');

        try{

            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            ob_start();
            $objWriter->save("php://output");
            $xlsData = ob_get_contents();
            ob_end_clean();

            $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );

            die(json_encode($response));

        }
        catch (PHPExcel_Writer_Exception $e)
        {
            echo "error";
            $response = array(
                'status' => 'error',
                'url' => $e
            );
            echo json_encode($response);
        }

    }

    public function ExportCompanyTransport()
    {
        $certificadoBusiness = new Certificate();
        $salida = $certificadoBusiness -> getCompanyTransportStadistic();

        if(isset($salida))
        {
            $transportesVM = $salida[0];
            $numeroCertificados = $salida[1];
            $montoAsegurado = $salida[2];
            $primaSeguro = $salida[3];
            $primaCia = $salida[4];
            $comisionCorredor = $salida[5];
        }

        $objPHPExcel = new PHPExcel();

        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("alexjdm") // Nombre del autor
        ->setLastModifiedBy("SingularAdmin") //Ultimo usuario que lo modificó
        ->setTitle("Estadística Compañía"); // Titulo
        /*->setSubject("Reporte Excel con PHP y MySQL") //Asunto
        ->setDescription("Reporte de alumnos") //Descripción
        ->setKeywords("reporte alumnos carreras") //Etiquetas
        ->setCategory("Reporte excel"); //Categorias*/

        $titulosColumnas = array('N°', 'Asegurado', 'Mes', 'Fecha Solicitud', 'Monto Asegurado', 'Prima Seguro', 'Prima Cia.', 'Comisión Corredor', 'Medio', 'Poliza', 'Número Certificado', 'Transbordo', 'Tipo Mercadería');

        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $objPHPExcel->setActiveSheetIndex(0);

        // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1',  $titulosColumnas[0])  //Titulo de las columnas
            ->setCellValue('B1',  $titulosColumnas[1])
            ->setCellValue('C1',  $titulosColumnas[2])
            ->setCellValue('D1',  $titulosColumnas[3])
            ->setCellValue('E1',  $titulosColumnas[4])
            ->setCellValue('F1',  $titulosColumnas[5])
            ->setCellValue('G1',  $titulosColumnas[6])
            ->setCellValue('H1',  $titulosColumnas[7])
            ->setCellValue('I1',  $titulosColumnas[8])
            ->setCellValue('J1',  $titulosColumnas[9])
            ->setCellValue('K1',  $titulosColumnas[10])
            ->setCellValue('L1',  $titulosColumnas[11])
            ->setCellValue('M1',  $titulosColumnas[12])
            /*->setCellValue('N1',  $titulosColumnas[13])
            ->setCellValue('O1',  $titulosColumnas[14])
            ->setCellValue('P1',  $titulosColumnas[15])
            ->setCellValue('Q1',  $titulosColumnas[16])
            ->setCellValue('R1',  $titulosColumnas[17])
            ->setCellValue('S1',  $titulosColumnas[18])
            ->setCellValue('T1',  $titulosColumnas[19])
            ->setCellValue('U1',  $titulosColumnas[20])
            ->setCellValue('V1',  $titulosColumnas[21])*/
        ;

        $objPHPExcel->getActiveSheet()->setTitle('Estadística Siniestros');

        $i = 2; //Numero de fila donde se va a comenzar a rellenar
        $contador = 1;
        foreach ($transportesVM as $transporteVM):
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $contador)
                ->setCellValue('B'.$i, $transporteVM['ASEGURADO'])
                ->setCellValue('C'.$i, $transporteVM['MES'])
                ->setCellValue('D'.$i, $transporteVM['FECHA_SOLICITUD'])
                ->setCellValue('E'.$i, $transporteVM['MONTO_ASEGURADO'])
                ->setCellValue('F'.$i, $transporteVM['PRIMA_SEGURO'])
                ->setCellValue('G'.$i, $transporteVM['PRIMA_CIA'])
                ->setCellValue('H'.$i, $transporteVM['COMISION_CORREDOR'])
                ->setCellValue('I'.$i, $transporteVM['MEDIO'])
                ->setCellValue('J'.$i, $transporteVM['POLIZA'])
                ->setCellValue('K'.$i, $transporteVM['NUMERO_CERTIFICADO'])
                ->setCellValue('L'.$i, $transporteVM['TRANSBORDO'])
                ->setCellValue('M'.$i, $transporteVM['TIPO_MERCADERIA'])
            ;
            $i++;
            $contador++;
        endforeach;

        // Totalizadores
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D'.$i, "Certificados")
            ->setCellValue('E'.$i, "Monto Asegurado")
            ->setCellValue('F'.$i, "Prima de Seguro")
            ->setCellValue('G'.$i, "Prima Cia.")
            ->setCellValue('H'.$i, "Comisión Corredor")
        ;
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D'.$i, $numeroCertificados)
            ->setCellValue('E'.$i, $montoAsegurado)
            ->setCellValue('F'.$i, $primaSeguro)
            ->setCellValue('G'.$i, $primaCia)
            ->setCellValue('H'.$i, $comisionCorredor)
        ;

        for($i = 'A'; $i <= 'O'; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
        }

        // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="listado_clientes.xlsx"');
        header('Cache-Control: max-age=0');

        try{

            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            ob_start();
            $objWriter->save("php://output");
            $xlsData = ob_get_contents();
            ob_end_clean();

            $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );

            die(json_encode($response));

        }
        catch (PHPExcel_Writer_Exception $e)
        {
            echo "error";
            $response = array(
                'status' => 'error',
                'url' => $e
            );
            echo json_encode($response);
        }

    }

}