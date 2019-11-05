<?php
//carregando conexão com  banco e autenticação
require "../auth/autenticacao.php";
/* Informa o nível dos erros que serão exibidos */
error_reporting(E_ALL);
/* Habilita a exibição de erros */
ini_set("display_errors", 1);

  // recuperando token de acesso do client
  if ($client->getAccessToken()) {
    $service = new Google_Service_YouTube($client);

    $queryParams = [
        'id' => 'iAR993pLfgA'
    ];
    
    $response = $service->videos->listVideos('snippet,processingDetails', $queryParams);
    var_dump($response);
    echo"<br>";
   
}


?>