<?php

ini_set('display_erros', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function obterPdo():PDO{

    
 
$host = "10.91.47.39";
$db = "servicehubdb01"; //Nome do banco de dados
$user = "root";
$pass = "Aa123456";
static $pdo;
 // php.net
try{
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo "conectado com sucesso!! <br>";
    // var_dump($pdo);
}catch(PDOException $e){
    // var_dump($e->getMessage());
    die("Erro na conexão: ".$e->getMessage());
}
return $pdo;
}