<?php 

require_once "config/conexao.php";

ini_set('display_erros', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    if($_SERVER['REQUEST_METHOD']=="POST"){

    $nome = $_POST['txtnome'];
    $descricao = $_POST['txtdescricao'];
    $preco = $_POST['txtpreco'];

    $pdo = obterPdo();
    $sql = "insert servicos (nome, descricao, preco) values(:nome, :descricao, :preco)";
    $cmd = obterPdo()->prepare($sql);
    $cmd->execute([':nome'=>$nome,':descricao'=>$descricao, ':preco'=>$preco]);
    $id = $pdo->lastInsertId();

    if(isset($id)){
        echo "Serviço cadastrado com sucesso, com ID".$id;
        }else{
            echo "Falha ao cadastro do serviço";
        }
    }
    $sql = "select * from servicos";
$cmd = $pdo->prepare($sql);
$cmd->execute();
$servicos = $cmd->fetchAll(PDO::FETCH_ASSOC);




    ?>

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Formulario de Cadastro de Serviços</title>
    </head>
    <body>
        <form action="formservico.php" method="post">
            <input type="number" name="txtid" id="" hidden>
            <label for="txtnome">Nome</label>
            <input type="text" name="txtnome">
            <label for="txtnome">Descrição</label>
            <input type="number" name="txtdescricao" >
            <label for="txtnome">Preço</label>
            <input type="text" name="txtpreco">
            <button type="submit">Gravar</button>
    </form>
</body>
</html>