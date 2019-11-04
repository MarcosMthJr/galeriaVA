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
      foreach ($channelsResponse['items'] as $channel) :
        $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];
        $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
          'playlistId' => $uploadsListId,
          'maxResults' => 10
        ));
        foreach ($playlistItemsResponse['items'] as $video) :

          ?>
            <div class="video" >
            
            <img src="<?= $video['snippet']['thumbnails']['high']['url']; ?>" class="card-img-top" alt="...">
              <div class="videoContent">
                <h5 class="card-title"><?= nl2br($video['snippet']['title']); ?></h5>
                <p class="card-text"><?= nl2br($video['snippet']['description']); ?></p>
              </div>
            <div class="row btnGerencia">
            <a class="videoLink" href="alterar.php?idVideo=<?= $video['snippet']['resourceId']['videoId']; ?>">
            <button type="button" class="btn-gerenciador btn btn-primary">Editar</button>
            </a>
            <a class="videoLink" href="confirmDelete.php?idVideo=<?= $video['snippet']['resourceId']['videoId']; ?>">
            <button type="button" class="btn-gerenciador btn btn-danger">Excluir</button>
            </a>
            </div>  

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