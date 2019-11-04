<?php
require "../auth/autenticacao.php";
require "../controller/listarController.php";
$idVideo = $_GET['idVideo'];





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <title>Assistindo</title>
</head>

<body>

    <?php include "header.php" ?>
    <main>
        <?= $htmlBody ?>
    <div class="videoPlay">

    
        
        
            <?php
        
        foreach ($channelsResponse['items'] as $channel) :
                $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];
                $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
                    'playlistId' => $uploadsListId,
                ));
                foreach ($playlistItemsResponse['items'] as $video) :
                    if ($video['snippet']['resourceId']['videoId'] == $idVideo) :?>
        
                <div class="iframe">
                    <iframe width="718" height="404" src="https://www.youtube.com/embed/<?= $idVideo ?>" 
                    frameborder="1" allow="accelerometer; autoplay; encrypted-media; gyroscope; 
                    picture-in-picture" allowfullscreen>
                    </iframe>
                </div>

        
       
        <div class="videoInfo">
            <span>
                <h3><?= nl2br($video['snippet']['title']); ?></h3>
                <label>Descrição</label>
                <p><?= nl2br($video['snippet']['description']); ?></p>
            </span>
            <span>
            </span>

        </div>

<?php endif;
    endforeach;
endforeach; ?>
</div>  
    </main>

    <?php include "footer.php" ?>
</body>

</html>