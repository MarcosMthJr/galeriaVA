<?php
$error =  false;
session_start();
$url  = 'http://localhost/youtubeAPI/view/upload.php';
if (empty($_POST['title'])) {
    $_SESSION['empty-title'] = "Digite um titulo";
    $error =  true;
    echo "<META HTTP-EQUIV= Refresh CONTENT='0;URL=$url'>";
}else{
    $_SESSION['value-title'] = $_POST['title'];  
}

if (empty($_POST['description'])) {
    $_SESSION['empty-description'] = "Digite uma descrição";
    $error =  true;
    echo "<META HTTP-EQUIV= Refresh CONTENT='0;URL=$url'>";
}else{
    $_SESSION['value-description'] = $_POST['description'];  
}
if (empty($_POST['session'])) {
    $_SESSION['empty-session'] = "Digite o número da sessão";
    $error =  true;
    echo "<META HTTP-EQUIV= Refresh CONTENT='0;URL=$url'>";
}else{
    $_SESSION['value-session'] = $_POST['session'];  
}
if (empty($_POST['type'])) {
    $_SESSION['empty-type'] = "Digite um tipo";
    $error =  true;
    echo "<META HTTP-EQUIV= Refresh CONTENT='0;URL=$url'>";
}else{
    $_SESSION['value-type'] = $_POST['type'];  
}


