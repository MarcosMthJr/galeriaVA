<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete</title>
</head>
<body>
    <?php include "header.php"?>
    <?php 
        $idVideo =  $_GET['idVideo'];
    ?>
    <main>
        <section class="confirm">
            <a class="excluirSim" href="../controller/deleteController.php?idVideo=<?= $idVideo?>">
                Sim, excluir!
            </a>
            <a class="excluirNao" href="listar.php">
                Não quero excluir
            </a>
            
        </section>
    </main>
    <?php include "footer.php";?>
</body>
</html>