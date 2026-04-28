  <!-- CLIENTE DASHBOARD É O PAINEL DO CLIENTE -->



  <!-- conectar o arquivo header.php -->
  <?php  
  // Iniciar a sessão para permitir o uso de $_SESSION
  session_start();




  //inclui o arquivo de conexão com o banco de dados
  require_once "config/conexao.php";
  // Inclui funções auxiliares do sistema
  require_once "includes/funcoes.php";
  // Verifica se o usuário está logsdo e se é do tipo cliente = 2
  if(!isset($_SESSION['usuario_id']) || $_SESSION["tipo"]!=2){
    header("location: login.php");
  }

  //cria um objeto da classe cliente
  $cliente = new Cliente;

  // Busca os dados do cliente usando o ID do usuário logado
  if(!$cliente->buscarPorId($_SESSION["usuario_id"])){
  //Se não encontrar o cliente
    die("Cliente não encontrado");
  }
  // Consulta SQL para buscar as solicitações do cliente
  // Também busca os serviços vinculados a cada solicitação
  $sql = "SELECT s.id,s.status,s.data_cad, GROUP_CONCAT(se.nome SEPARADOR '.')AS servicos FROM solicitações s
  INNER JOIN servico_solucitacao ss ON ss.solicitacoes_id WHERE s.cliente_id=?
  GROUP BY s.id, s.status, s.data_cad ORDER BY s.data_cad DESC";

  //prepara a consulta 
  $stmt = $pdo->prepare($sql);
  //execute
  $stmt->execute([$cliente["id"]]);
  //busca todas as solicitações encontradas no banco
  $solicitacoes = $stmt->fetchAll((PDO::FETCH_ASSOC));


  include "includes/header.php";
  include "includes/menu.php";
  ?>

  <main class="container mt-5">
    <h2>Bem-vindo, <?= $_SESSION["nome"] ?></h2>
    <p><a href="logout.php" class="btn btn-danger btn-sm">Sair</a></p>
    <a href="cliente_perfil.php" class="btn btn-warning btn-sm">Meu Perfil</a>
    <h4 class="mt-4">Minhas Solicitações</h4>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Serviços</th>
          <th>Status</th>
          <th>Data</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody>
      <!-- percorre todas as solicitações retornadas do banco -->
        <?php foreach($solicitacoes as $s): ?>      
      <tr>
      <td><?= $a["id"] ?></td>
          
            <td>
              <?php 
              //divide a lista de serviços em um array
              $lista = explode(", ", $s["servicos"]);
              // Percorre
              foreach($lista as $nomeServico){
              // htmlspecialchars evita execução de código HTML/JS malicioso 
                echo '<span class = "badge bg-primary me-1 mb-1>'. 
                htmlspecialchars($nomeServico).'</span>';
              }
              ?>
            </td>
            <!-- Exibe o status em formato de texto usando função -->
            <td>
              <?php statusTexto($s["status"]) ?>
            </td>

            <td>
              <!-- Formata a data para o padrão brasileiro -->
              <?= date("d/m/Y H:i", strtotime($s["data_cad"]))  ?>
            </td>
              <!-- Link para ver os datalhes da solicitação -->
              <td>

              <a href="cliente_detalhes.php?id=<?= $s["id"] ?>"></a>
              </td>

            <td>
              <a href="cliente_detalhes.php?id=" class="btn btn-primary btn-sm"
              class="btn-primary btn-sm">Detalhes</a>
            </td>
          </tr>
          <?php endforeach;?>
      </tbody>
    </table>
  </main>

  <?php 
  include "includes/footer.php";
  ?>