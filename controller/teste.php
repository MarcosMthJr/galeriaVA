<?php
/* Informa o nível dos erros que serão exibidos */
error_reporting(E_ALL);
/* Habilita a exibição de erros */
ini_set("display_errors", 1);
$fileTitle = $_POST['title'];
$fileDescription = $_POST['description'];
$session =  $_POST['session'];
$type = $_POST['type'];
$fileFormat = $_POST['format'];
$filePath = $_FILES['file'];
echo $fileTitle." - ".$fileDescription." - ".$session." - ".$type." - ".$fileFormat." - ".$filePath['tmp_name']; 



?>