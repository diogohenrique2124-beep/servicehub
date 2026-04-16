<?php 
// $senha = password_hash("123456",PASSWORD_DEFAULT);
// echo $senha;

require_once "class/Usuario.php";

$usuario = new Usuario();
$usuario->setNome('Milharino Santos');
$usuario->setEmail('mil@harino.sa');
$usuario->setSenha('mI2026@TV');
$usuario->setTipo(2);

if($usuario->inserir()){
    echo "Usuario".$usuario->getNome()."inserido com sucesso com o ID".$usuario->getId();
}
?>