

<!-- conectar o arquivo header.php -->
<?php  
include "includes/header.php";
include "includes/menu.php";
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow p-4 col-md-5 mx-auto">
    <h3 class="text-center">Área Restrita</h3>


    <form method="POST">
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Senha</label>
        <input type="password" name="senha" class="form-control" required>
      </div>

      <button class="btn btn-dark w-100">Entrar</button>
    </form>

    <p class="text-center mt-3">
      <a href="index.php">Voltar ao site</a>
    </p>
  </div>
</div>
</body>
</html>