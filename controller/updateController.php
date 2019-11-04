<?php
require "../auth/autenticacao.php";
require "../config/conexao.php";
// pegando id pela da url

//pegano valores do formulario
$titulo  = $_POST['title'];
$descricao  = $_POST['description'];
$sessao = $_POST['session'];
$tipo  = $_POST['type'];
$formato  = $_POST['format'];
$videoId = $_POST['idVideo'];
$sucess =  false;
// Check to ensure that the access token was successfully acquired.
if ($client->getAccessToken()) {
  $htmlBody = '';
  try {

    // Call the API's videos.list method to retrieve the video resource.
    $listResponse = $youtube->videos->listVideos(
      "snippet",
      array('id' => $videoId)
    );
    // If $listResponse is empty, the specified video was not found.
    if (empty($listResponse)) {
      $htmlBody .= sprintf('<h3>Can\'t find a video with video id: %s</h3>', $videoId);
    } else {
      // Since the request specified a video ID, the response only
      // contains one video resource.
      $video = $listResponse[0];
      $videoSnippet = $video['snippet'];
      $tags = $videoSnippet['tags'];

      if (is_null($tags)) {
        $tags = array("tag1", "tag2");
      } else {
        array_push($tags, "tag1", "tag2");
      }

      // Set the tags array for the video snippet
      $videoSnippet['tags'] = $tags;
      $videoSnippet['title'] = $titulo;
      $videoSnippet['description'] = $descricao;

      // Update the video resource by calling the videos.update() method.
      $updateResponse = $youtube->videos->update("snippet", $video);
      //$updateResponse['snippet']['tags'];

      $sucess =  true;
    }
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

  /*PDO PARA FAZER UPDATE NO BANCO DE DADOS*/
  if($sucess == true){
    try {
      $alterarVideo = $pdo->prepare("UPDATE video SET formato = :formato, tipo = :tipo,
      sessao = :sessao, titulo = :titulo, descricao = :descricao WHERE youtubeVideoId=:videoId");
      $alterarVideo->bindValue(":videoId", $videoId);
      $alterarVideo->bindValue(":titulo", $titulo);
      $alterarVideo->bindValue(":descricao", $descricao);
      $alterarVideo->bindValue(":formato", $formato);
      $alterarVideo->bindValue(":tipo", $tipo);
      $alterarVideo->bindValue(":sessao", $sessao);
      $alterarVideo->execute();
      
      header("Location: ../view/assistir.php?idVideo=".$videoId);
    } catch (PDOException  $e) {
      $errorMysql = $e->getMessage();
    }
  }else{
    header("Location: ../view/alterar.php?idVideo=".$videoId);
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
?>

<!doctype html>
<html>

<head>
  <title>Video Updated</title>
</head>

<body>
  <?= $htmlBody ?>
</body>

</html>