<?php require"../controller/listarController.php";

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/normalize.css">
  <link href="/fontawesome/css/fontawesome.css" rel="stylesheet">
  <link href="/fontawesome/css/brands.css" rel="stylesheet">
  <link href="/fontawesome/css/solid.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilo.css">
  <title>GaleriaVA</title>
</head>
<body>

<header>
  <div class="logo">
    <i>X</i>

    <h1 class="linhaLogo"> <a href="#">GaleriaVA</a></h1>
    <i>O</i>
  </div>
  <nav>
    <ul>
      
      <li><a href="#">Página Inicial</a></li>
      <li><a href="#">Fazer Upload</a></li>
      <li><a href="#">Gerenciar Meus Vídeos</a></li>
    </ul>
  </nav>
</header>
<main>
<?= $htmlBody?>
<section class="listaVideo">

<?php 
 foreach ($channelsResponse['items'] as $channel):
           $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];
           $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
             'playlistId' => $uploadsListId,
             'maxResults' => 3
           ));
           foreach ($playlistItemsResponse['items'] as $video):

      ?>
       <article class="video">
  <a class="videoLink" href="https://www.youtube.com/watch?v=<?=$video['snippet']['resourceId']['videoId'];?>"> 
    <img class="thumb" src="<?= $video['snippet']['thumbnails']['high']['url']; ?>">
    <p class="videoTitle"><?=  nl2br($video['snippet']['title']);?></p>
    <p><?=  nl2br($video['snippet']['description']);?></p>
  </a>
  </article>




       
        <?php endforeach; endforeach; ?>
 


</section>

    

  
      
        </main> 
        <footer>
  <p>Marcos M. Junior &copy; 2019</p>
</footer>
</body>
</html>