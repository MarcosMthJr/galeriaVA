<?php require "../controller/listarController.php";

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/estilo.css">
  <title>GaleriaVA</title>
</head>

<body>
  <?php include "header.php" ?>

  <main>
    <?= $htmlBody ?>
    <div class="container-fluid">
<div class="row">
    <div class="videoGroup">
      <?php
      // foreach pecorrendo os items da resposta
      foreach ($channelsResponse['items'] as $channel) :
        // query para busacar os videos na lista de upload
        $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];
        // aplicando query e delimitando quantidade de resultado
        $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
          'playlistId' => $uploadsListId,
          'maxResults' => 10
        ));
        // pegando cada video retornado
        foreach ($playlistItemsResponse['items'] as $video) :

          ?>
            <div class="video" >
            <a class="videoLink" href="assistir.php?idVideo=<?= $video['snippet']['resourceId']['videoId']; ?>">
          
            <img src="<?= $video['snippet']['thumbnails']['high']['url']; ?>" class="card-img-top" alt="...">
              <div class="videoContent">
                <p><?= $video['snippet']['thumbnails']['high']['url']; ?></p>
                <h5 class="card-title"><?= nl2br($video['snippet']['title']); ?></h5>
                <p class="card-text"><?= nl2br($video['snippet']['description']); ?></p>
              </div>
              </a>
            </div>
        
         








         





      <?php endforeach;
      endforeach; ?>


</div>
</div>
    </div>
  </main>
  <?php include "footer.php" ?>
</body>

</html>