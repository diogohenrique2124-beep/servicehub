<?php
session_start();  
include "includes/header.php";
include "includes/menu.php";

?>



<main class="container mt-5">
  <div>

    <h3>Solicitação #</h3>
    <p><strong>Status:</strong> </p>
    <p><strong>Descrição:</strong> </p>
    <p><strong >Endereço:</strong> </p>
  </div>
  
 
    <div class="alert alert-info">
      <strong>Resposta do Admin:</strong><br>
      
    </div>
 
    <div class="alert alert-warning">Ainda não há resposta.</div>
  

  <a href="cliente_dashboard.php" class="btn btn-secondary">Voltar</a>
</main>

<?php 
include "include/footer.php";
?>