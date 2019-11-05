<?php
require "../auth/autenticacao.php";
require "../config/conexao.php";

//pegano id do video que vai ser deletado
$idVideo  = $_GET['idVideo'];
$success =  false;
if ($client->getAccessToken()) {
  $youtube = new Google_Service_YouTube($client);
  try {
    $youtube->videos->delete($idVideo);
    $success =  true;
  } catch (Google_Service_Exception $e) {
    $htmlBody .= sprintf(
      '<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage())
    );
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf(
      '<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage())
    );
  }

  /*PDO PARA FAZER EXCLUÃO NO BANCO DE DADOS*/
  if($success == true){
    try {
        $deletarVideo = $pdo->prepare("DELETE FROM video WHERE youtubeVideoId = :id");
        $deletarVideo->bindValue(":id", $idVideo);
        $deletarVideo->execute();
      
      header("Location: ../view/listar.php");
    } catch (PDOException  $e) {
      $errorMysql = $e->getMessage();
      $htmlBody .= "Erro ao excluir do banco de dados";
    }
  }else{
    $htmlBody .="Erro ao tentar excluir vídeo";    
}
    
  $_SESSION[$tokenSessionKey] = $client->getAccessToken();
} elseif ($OAUTH2_CLIENT_ID == 'REPLACE_ME') {
  $htmlBody = <<<END
  <h3>Client Credentials Required</h3>
  <p>
    You need to set <code>\$OAUTH2_CLIENT_ID</code> and
    <code>\$OAUTH2_CLIENT_ID</code> before proceeding.
  <p>
END;
} else {
  // If the user hasn't authorized the app, initiate the OAuth flow
  $state = mt_rand();
  $client->setState($state);
  $_SESSION['state'] = $state;
  $authUrl = $client->createAuthUrl();
  $htmlBody = <<<END
<h3>Authorization Required</h3>
<p>You need to <a href="$authUrl">authorize access</a> before proceeding.<p>
END;
}
