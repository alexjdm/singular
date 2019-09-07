<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 10-04-2016
 * Time: 17:34
 */

function redirect($url, $statusCode = 303)
{
    header('Location: ' . $url, true, $statusCode);
    die();
}

function upload($file){
    $target_dir = "../upload/";
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($file["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            echo "The file ". basename($file["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    return $target_file;
}

function GetPoliceNumber($nombreArchivo)
{
    if(isset($nombreArchivo))
    {
        $split = explode(' ', $nombreArchivo);
        $split = explode('-', $split[1]);
        $index = strpos($split[1], '.');
        return substr($split[1], 0, $index);
    }

    return 0;
}

function GetCertificateNumber($nombreArchivo)
{
    if(isset($nombreArchivo))
    {
        $split = explode(' ', $nombreArchivo);
        $split = explode('-', $split[1]);
        return $split[0];
    }

    return 0;
}

function FormatearFechaEn($fecha){
    $fechaSpa = explode(' ', $fecha);
    if(strpos($fecha, '-'))
    {
        list($dia, $mes, $año) = explode('-', $fechaSpa[0]);
    }
    else
    {
        list($dia, $mes, $año) = explode('/', $fechaSpa[0]);
    }
    $fechaEn = $año . "-" . $mes . "-" . $dia;
    return $fechaEn;
}

function FormatearFechaSpa($fecha){
    $fechaSpa = explode(' ', $fecha);
    if(strpos($fecha, '-'))
    {
        list($año, $mes, $dia) = explode('-', $fechaSpa[0]);
    }
    else
    {
        list($año, $mes, $dia) = explode('/', $fechaSpa[0]);
    }
    $fechaSpa = $dia . "-" . $mes . "-" . $año;
    return $fechaSpa;
}

function FormatearFechaCompletaSpa($fecha){
    $fechaSpa = explode(' ', $fecha);
    if(strpos($fecha, '-'))
    {
        list($año, $mes, $dia) = explode('-', $fechaSpa[0]);
    }
    else
    {
        list($año, $mes, $dia) = explode('/', $fechaSpa[0]);
    }
    $fechaSpa = $dia . "-" . $mes . "-" . $año . " " . $fechaSpa[1];
    return $fechaSpa;
}

function FormatearMonto($monto){
    return number_format($monto, 0, ",", ".");
}

function String2DB($string){
    return str_replace("'", "''", $string);
}

function FormatearRut($identificador)
{
    $identificador = str_replace(".", "", $identificador); // Se quitan puntos
    $pos = strpos($identificador, '-');
    $cuenta = strlen($identificador);
    if($pos == false)
    {
        $identificador = substr($identificador, 0, $cuenta - 1) . "-" . substr($identificador, $cuenta - 1);
    }

    return $identificador;
}

function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
{
    $pagination = '';
    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
        $pagination .= '<ul class="pagination">';

        $right_links    = $current_page + 3;
        $previous       = $current_page - 3; //previous link
        $next           = $current_page + 1; //next link
        $first_link     = true; //boolean var to decide our first link

        if($current_page > 1){
            $previous_link = ($previous==0)?1:$previous;
            $pagination .= '<li class="first"><a href="#" data-page="1" title="First">&laquo;</a></li>'; //first link
            $pagination .= '<li><a href="#" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
            for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
                if($i > 0){
                    $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
                }
            }
            $first_link = false; //set first link to false
        }

        if($first_link){ //if current active page is first link
            $pagination .= '<li class="first active"><a href="#">'.$current_page.'</a></li>';
        }elseif($current_page == $total_pages){ //if it's the last active link
            $pagination .= '<li class="last active"><a href="#">'.$current_page.'</a></li>';
        }else{ //regular current link
            $pagination .= '<li class="active"><a href="#">'.$current_page.'</a></li>';
        }

        for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
            if($i<=$total_pages){
                $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
            }
        }
        if($current_page < $total_pages){
            $next_link = ($i > $total_pages)? $total_pages : $i;
            $pagination .= '<li><a href="#" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
            $pagination .= '<li class="last"><a href="#" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
        }

        $pagination .= '</ul>';
    }
    return $pagination; //return pagination links
}

function getMes($fecha)
{
    return date("m", strtotime($fecha));
}


function getCompany($companias, $idCompania)
{
    foreach ($companias as $compania):
        if($compania['ID_COMPANIA'] == $idCompania):
            return $compania;
        endif;
    endforeach;

    return null;
}

function getTipoMercaderia($tiposMercaderia, $idTipoMercaderia)
{
    foreach ($tiposMercaderia as $tipoMercaderia):
        if($tipoMercaderia['ID_TIPO_MERCADERIA'] == $idTipoMercaderia):
            return $tipoMercaderia;
        endif;
    endforeach;

    return null;
}

function getCertificado($certificados, $idCertificado)
{
    foreach ($certificados as $certificado):
        if($certificado['ID_CERTIFICADO'] == $idCertificado):
            return $certificado;
        endif;
    endforeach;

    return null;
}

function getAsegurado($asegurados, $idAsegurado)
{
    foreach ($asegurados as $asegurado):
        if($asegurado['ID_ASEGURADO'] == $idAsegurado):
            return $asegurado;
        endif;
    endforeach;

    return null;
}

function getPoliza($polizas, $idPoliza)
{
    foreach ($polizas as $poliza):
        if($poliza['ID_POLIZA'] == $idPoliza):
            return $poliza;
        endif;
    endforeach;

    return null;
}

function getCliente($idUsuarioSolicitante)
{
    $usuario = getUsuarioSolicitante($idUsuarioSolicitante);

    $corredoraBusiness = new InsuranceBroker();
    $corredora = $corredoraBusiness->getInsuranceBrokerByIdUser($usuario['ID_USUARIO']);

    return $corredora;
}

function getUsuarioSolicitante($idUsuarioSolicitante)
{
    $usuarioBusiness = new Usuario();
    $usuario = $usuarioBusiness->getUser($idUsuarioSolicitante);

    return $usuario;
}

