<?php 

require_once "config/conexao.php";
ini_set('display_erros', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    if($_SERVER['REQUEST_METHOD']=="POST"){

    $nome = $_POST['txtnome'];
    $idade = $_POST['txtidade'];
    $turma = $_POST['txtturma'];

    $sql = "insert servicos (nome, idade, turma) values(:nome, :idade, :turma)";
    $cmd = $pdo->prepare($sql);
    $cmd->execute([':nome'=>$nome,':idade'=>$idade, ':turma'=>$turma]);
    $id = $pdo->lastInsertId();
    $alunos = $cmd->fetchAll(PDO::FETCH_ASSOC);

    if(isset($id)){
        echo "Aluno cadastrado com sucesso, com ID".$id;
        }else{
            echo "Falha ao cadastro do Aluno";
        }
    }
    ?>

     <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Formulario de Cadastro dos Alunos</title>
    </head>
    <body>
        <form action="formalunos.php" method="post">
            <input type="number" name="txtid" id="" hidden>
            <label for="txtnome">Nome</label>
            <input type="text" name="txtnome">
            <label for="txtidade">Idade</label>
            <input type="number" name="txtidade" >
            <label for="txtturma">Turma</label>
            <input type="text" name="txtturma">
            <button type="submit">Gravar</button>
    </form>

     <h2>Lista dos alunos cadastrados</h2>
    <table border="1" cellpadding = 10>
        <tr>
           <th>ID</th>
           <th>Nome</th>
           <th>Idade</th>
           <th>Turma</th>
        </tr>
        <?php foreach($alunos as $aluno): ?>
        <tr>
            <td><?= $aluno['id']?></td>
            <td><?= $aluno['nome']?></td>
            <td><?= $aluno['idade']?></td>
            <td><?= $aluno['turma']?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>