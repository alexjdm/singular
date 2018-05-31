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
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            //$objWriter->save($filePath);
            $objWriter->save(str_replace(__FILE__,$_SERVER['DOCUMENT_ROOT'] .'/path/to/save/filename.xlsx',__FILE__));

            $response = array(
                'status' => 'success',
                'url' => $filePath
            );
            echo json_encode($response);
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

}