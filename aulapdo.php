<?php
include_once "config/conexao.php";

$sql = "select * from usuarios";
$cmd = $pdo->prepare($sql);
$cmd->execute();

$servicos = $cmd->fetchAll(PDO::FETCH_ASSOC);

var_dump($servicos)
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Aula PDO PHP</title>
</head>
<body>
    <h2>Lista de Seriços</h2>
</body>
</html>