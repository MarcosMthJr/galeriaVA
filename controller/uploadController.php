<?php
//carregando conexão com  banco e autenticação
require "../auth/autenticacao.php";
require "../config/conexao.php";

/* Informa o nível dos erros que serão exibidos */
error_reporting(E_ALL);
/* Habilita a exibição de erros */
ini_set("display_errors", 1);

$fileTitle = $_POST['title'];
$file = $_POST['file'];
$fileFormat = $_POST['format'];
$fileDescription = $_POST['description'];
$session = $_POST['session'];
$type = $_POST['type'];

// colocando diretório do arquivo manualmente para evitar erros 
$filePath = 'rua.mp4';

// recurando token de acesso do client
if ($client->getAccessToken()) {
  $htmlBody = '';
  try{
  //setando valores do arquivo
    $snippet = new Google_Service_YouTube_VideoSnippet();
    $snippet->setTitle($fileTitle);
    $snippet->setDescription($fileDescription);
    $snippet->setTags(array("Tag Padrão"));

    // Numeric video category. See
    // https://developers.google.com/youtube/v3/docs/videoCategories/list
    $snippet->setCategoryId("22");

    // Set the video's status to "public". Valid statuses are "public",
    // "private" and "unlisted".
    $status = new Google_Service_YouTube_VideoStatus();
    $status->privacyStatus = "private";

    // Associate the snippet and status objects with a new video resource.
    $video = new Google_Service_YouTube_Video();
    $video->setSnippet($snippet);
    $video->setStatus($status);

    // Specify the size of each chunk of data, in bytes. Set a higher value for
    // reliable connection as fewer chunks lead to faster uploads. Set a lower
    // value for better recovery on less reliable connections.
    $chunkSizeBytes = 1 * 1024 * 1024;

    // Setting the defer flag to true tells the client to return a request which can be called
    // with ->execute(); instead of making the API call immediately.
    $client->setDefer(true);
    // Create a request for the API's videos.insert method to create and upload the video.
    $insertRequest = $youtube->videos->insert("status,snippet", $video);
    // Create a MediaFileUpload object for resumable uploads.
    $media = new Google_Http_MediaFileUpload(
        $client,
        $insertRequest,
        'video/*',
        null,
        true,
        $chunkSizeBytes
    );
    $media->setFileSize(filesize($filePath));

    // lendo o arquivo e upando partes por parte 
    // Read the media file and upload it chunk by chunk.
    $status = false;
    $handle = fopen($filePath, "rb");
    
    while (!$status && !feof($handle)) {
      $chunk = fread($handle, $chunkSizeBytes);
      $status = $media->nextChunk($chunk);
     
    }
    // link com processo e progresso
    // https://developers.google.com/youtube/v3/docs/videos?hl=pt-br
// objeto responsavel por verificar o status do progresso (terminou, se deu falha ao upar e tal)
    $process =  new Google_Service_YouTube_VideoProcessingDetails(); 
// objeto Progress responsavél por recuperar informações sobre o progresso do vídeo no youtube    
    $progress =  new Google_Service_YouTube_VideoProcessingDetailsProcessingProgress();
    // continua verificando o processo do envio do arquivo no processamento do YT
    if( $process-> getProcessingStatus() != 'failed'){
      while( $process->getProcessingStatus() == 'processing'){
        if( $status->getUploadStatus() != 'failed'){
        // pegando informações de progresso de envio (tempo estimado, porcentagem, status)  
          $timeLeft =  $progress->getTimeLeftMs();
          $percentage = 100 *  $progress->getPartsProcessed() / $progress->getPartsTotal();
        
          
        }else{
          $ErrorAoUpar=  $process->getProcessingFailureReason();
        }
    }
    // se o status do upload for succeeded então ele foi realizado com sucesso
    // então podemos inserir em nosso banco de dados
    
    if($uploadStatus== 'succeeded'){
      $percentage = "Sucesso ao realiazar Upload";
         
      try{
          $inserirVideo = $pdo->prepare("INSERT INTO video 
          (formato, youtubeVideoID, tipo, dataUpload, sessao, titulo)
            VALUES(:f, :yvi, :t, :up, :ss, :title)");
      
          $inserirVideo->bindValue(":f",  $fileFormat);
          $inserirVideo->bindValue(":yvi", $videoId);
          $inserirVideo->bindValue(":t", $type);
          $inserirVideo->bindValue(":up", date("Y-m-d H:i:s"));
          $inserirVideo->bindValue(":ss", 245);
          $inserirVideo->bindValue(":title", $videoTitulo);
          $inserirVideo->execute();
      }catch (PDOException  $e){
        $errorMysql = $e->getMessage();
      }
    
    }
}else{
 $ErrorAoUpar=  $process->getProcessingFailureReason();;
}




    fclose($handle);

    // If you want to make other calls after the file upload, set setDefer back to false
    $client->setDefer(false);
    $videoId = $status['id'];
    $videoTitulo = $status['snippet']['title'];

  $htmlBody .= "<h3>Video Uploaded</h3><ul>";
    $htmlBody .= sprintf('<li>%s (%s)</li>',
        $status['snippet']['title'],
        $status['id']);

    $htmlBody .= '</ul>';

  } catch (Google_Service_Exception $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  }

  // se não ocorrer erro ao fazer upload, ele vai tentar inserir no banco de dados


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
<title>Video Uploaded</title>
</head>
<body>
  <?= $htmlBody?>
  <script>
    const percent= <?php $percentage?>
    const timeLeft= <?php $timeLeft ?>
    const processoStatus = <?php  $status->getUploadStatus();?>

    while (processoStatus == 'processing') {
      console.log(`tempo Restante: ${timeLeft}    ------ `);
      console.log(`-  ${percent}%`);
    }
    const statusFinal = <?php  $status->getUploadStatus();?>
    console.log(statusFinal);

</script>

</body>
</html>