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
      
      <li><a href="../index.php">Página Inicial</a></li>
      <li><a href="#">Fazer Upload</a></li>
      <li><a href="#">Gerenciar Meus Vídeos</a></li>
    </ul>
  </nav>
</header>
<main>
<?= $htmlBody?>
<form class="frmUpload"  action="../controller/uploadController.php" method="POST">
    <span class="inptBlock">
        <label for="file">Selecione o arquivo</label>
        <input name="file" type="file">
    </span>
    <span class="inptBlock">
        <label for="format">Selecione o formato</label>
        <select name="format">
            <option value="1">Video</option>
            <option value="2">Áudio</option>
        </select>
    </span>
       <br><br>
    <span class="inptBlock">
        <label for="title">Titlulo</label>
        <input name="title" type="text">
    </span>
    <br><br>
    <span class="inptBlock">
        <label for="description">Descrição</label>
        <input name="description" type="text">
    </span>
    <br><br>
    <span class="inptBlock">
        <label for="session">Sessão</label>
        <input name="session" type="text">
    </span>
    <br><br>
    <span class="inptBlock">
        <label for="type">tipo</label>
        <input name="type" type="text">
    </span>
    <br><br>
   
    <input name="btnUpload" type="submit"  value="Enviar!">
        
</form>
       


    

  
      
</main> 
<footer>
  <p>Marcos M. Junior &copy; 2019</p>
</footer>
</body>
</html>