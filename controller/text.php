<?php
/* Informa o nível dos erros que serão exibidos */
error_reporting(E_ALL);
/* Habilita a exibição de erros */
ini_set("display_errors", 1);

$fileTitle = $_POST['title'];
$file = $_FILES['file'];
$fileFormat = $_POST['format'];
$fileDescription = $_POST['description'];
$session = $_POST['session'];
$type = $_POST['type'];

echo $fileTitle."<br>";
echo $file['name'];
?>