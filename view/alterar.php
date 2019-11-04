<?php
require "../auth/autenticacao.php";
require "../controller/listarController.php";
require "../config/conexao.php";
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
        <div class="videoBox">




            <?php

foreach ($channelsResponse['items'] as $channel) :
    $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];
    $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
        'playlistId' => $uploadsListId,
    ));
    foreach ($playlistItemsResponse['items'] as $video) :
        if ($video['snippet']['resourceId']['videoId'] == $idVideo) :
            $selecionarVideo = $pdo->prepare("SELECT * FROM video WHERE youtubeVideoId = :idVideo");
            $selecionarVideo->bindValue(":idVideo", $idVideo);
            $selecionarVideo->execute();
            $bdVideo = $selecionarVideo->fetch(PDO::FETCH_ASSOC);

            ?>

                        <div class="iframe">
                            <iframe width="718" height="404" src="https://www.youtube.com/embed/<?= $idVideo ?>" frameborder="1" allow="accelerometer; autoplay; encrypted-media; gyroscope; 
                    picture-in-picture" allowfullscreen>
                            </iframe>
                        </div>

                        <form class="frmAlterar" action="../controller/updateController.php" method="POST">

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="title">Título</label>
                                    <input type="text" class="form-control" name="title" value="<?= nl2br($video['snippet']['title']); ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">Número da Sessão</label>
                                    <input type="text" class="form-control" name="session" value="<?=$frm = $bdVideo['sessao'] ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="description">Descrição</label>
                                    <textarea class="form-control" name="description" rows="3"><?= nl2br($video['snippet']['description']); ?></textarea>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Tipo</label>
                                    <input type="text" class="form-control" name="type" value="<?=$frm = $bdVideo['tipo'] ?>">
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-4">
                                <?php $frm = $bdVideo['formato'] == 1 ? "Vídeo" : "Áudio"; ?>
                                    <label>Formato: <?= $frm ?></label>
                                    <select name="format" class="form-control">
                                        <option  value="1" selected>Vídeo</option>
                                        <option value="2" >Áudio</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="idVideo" value="<?= $idVideo ?>">
                            <button type="submit" class="btn btn-primary">Sign in</button>
                        </form>

            <?php endif;
                endforeach;
            endforeach; ?>
    </main>

    <?php include "footer.php" ?>
</body>

</html>