<?php
/**
 * Created by PhpStorm.
 * User: alexj
 * Date: 17-10-2017
 * Time: 22:58
 */

if(!empty($_FILES)) {
    if(is_uploaded_file($_FILES['certificado']['tmp_name'])) {
        $sourcePath = $_FILES['certificado']['tmp_name'];
        $targetPath = "../../dist/img/" . $_FILES['certificado']['name'];
        if(move_uploaded_file($sourcePath, $targetPath)) {

        }
    }
}