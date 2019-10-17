<?php
try {
// configurando conexão
    $pdo =  new PDO("mysql:dbname=youtube; host=localhost", "root","1324");
    
} catch (PDOException $e) {
    echo"Erro com banco de dados: ".$e->getMessage();
}catch(Exception $e){
    echo "Erro genérico: ".$e->getMessage();
}



?>