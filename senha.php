<?php 
// $senha = password_hash("123456",PASSWORD_DEFAULT);
// echo $senha;

// require_once "class/Usuario.php";

// $usuario = new Usuario();
// $usuario->setNome('Milharino Santos');
// $usuario->setEmail('mil@harino.sa');
// $usuario->setSenha('mI2026@TV');
// $usuario->setTipo(2);

// if($usuario->inserir()){
//     echo "Usuario".$usuario->getNome()."inserido com sucesso com o ID".$usuario->getId();
//}
ini_set('display_erros', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once "class/Usuario.php";
// testando update
$usuario = new Usuario();//objeto vazio
//     if($usuario->buscarPorId(211)){
//         echo"<pre>";
//         print_r($usuario);
//     }else{
//         echo"Usuário não cadastrado";
//         die(); //dd(")
//     }
//     $usuario->setNome("Milhonário Santos");
//     echo "<hr>";
//     echo "<pre>";
//     if($usuario->atualizar())
//     print_r($usuario);

if($usuario->buscarPorId(211)){
    echo "Senha atualizada com sucesso!";
}
?>