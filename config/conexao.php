<?php

$host = "10.91.47.39";
$db = "servicehub01";
$user = "root";
$pass = "P@ssw0rd";


try{
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=uft8",$user,$pass);
    //
}catch(PDOException $e){
    die("Erro na conexão: ".$e->getMessage());
}