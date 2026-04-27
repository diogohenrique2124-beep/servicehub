<?php 
include_once "class/Cliente.php";

$cliente = new Cliente();
$cli->buscarPorUsuario(182);

print_r($cliente->getTelefone());
?>