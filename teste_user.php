<?php 
include_once "class/Cliente.php";

$cliente = new Cliente();
$cli=$cliente->buscarPorUsuario(1);

print_r($cliente->getTelefone());
?>