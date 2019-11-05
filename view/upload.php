<?php session_start(); ?>
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
  <?php include "header.php"; ?>
  <main>

    <form enctype="multipart/form-data" class="uploadForm" action="../controller/uploadController.php" method="POST" >
    <div class="form-group col-md-6">
        <label>Arquivo</label>
        <input type="file" name="file" class="form-control" required>
       
      </div>


      <div class="form-group col-md-6">
        <label>Título</label>
        <input type="text" name="title" class="form-control" required placeholder="Título do vídeo" <?php
                                                                                                    if (!empty($_SESSION['value-title'])) {
                                                                                                      echo "value='" . $_SESSION['value-title'] . "'";
                                                                                                      unset($_SESSION['value-title']);
                                                                                                    }
                                                                                                    ?>>
        <?php
        if (!empty($_SESSION['empty-title'])) {
          echo "<p style='color: red;'>" . $_SESSION['empty-title'] . "</p>";
          unset($_SESSION['empty-title']);
        }
        ?>
      </div>
      <div class="form-group col-md-6">
        <label>Descrição</label>
        <textarea name="description" class="form-control" required name="description" rows="3" placeholder="Descrição do vídeo">
        <?php
        if (!empty($_SESSION['value-description'])) {
          echo  $_SESSION['value-description'];
          unset($_SESSION['value-description']);
        }
        ?>
        </textarea>
        <?php
        if (!empty($_SESSION['empty-description'])) {
          echo "<p style='color: red;'>" . $_SESSION['empty-description'] . "</p>";
          unset($_SESSION['empty-description']);
        }
        ?>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Número da sessão</label>
          <input name="session" required type="text" class="form-control">
        </div>
        <div class="form-group">
          <label>Tipo</label>
          <input type="text" required name="type" class="form-control" <?php
                                                                        if (!empty($_SESSION['value-type'])) {
                                                                          echo "value='" . $_SESSION['value-type'] . "'";
                                                                          unset($_SESSION['value-type']);
                                                                        }
                                                                        ?>>
          <?php
          if (!empty($_SESSION['empty-type'])) {
            echo "<p style='color: red;'>" . $_SESSION['empty-type'] . "</p>";
            unset($_SESSION['empty-type']);
          }
          ?>
        </div>
      </div>
      <div class="form-group col-md-2">
        <label for="inputState">Formato</label>
        <select id="inputState" name="format" class="form-control">
          <option value="1" selected>Vídeo</option>
          <option value="2">Áudio</option>
        </select>
        <?php
        if (!empty($_SESSION['empty-format'])) {
          echo "<p style='color: red;'>" . $_SESSION['empty-format'] . "</p>";
          unset($_SESSION['empty-format']);
        }
        ?>
      </div>

      <button type="submit" class="btn btn-primary">Enviar</button>
    </form>



    <?= $htmlBody ?>

    <!-- barra de progresso --->

  </main>
  <?php include "footer.php"; ?>


</body>

</html>