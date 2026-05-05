<?php 
include_once "config/conexao.php";
include_once "class/ServicoSolicitacao.php";

class Solicitacao{
private $id=0;
private $cliente_id;
private $descricao_problema;
private $data_preferida;
private $status;
private $data_cad;
private $data_atualizacao;
private $data_resposta;
private $resposta_admin;
private $endereco;
public  $servicos = [];
private $pdo;

 public function __construct()
    {
       $this->pdo = obterPdo();
    }

 public function getId(){
        return $this->id;
    }
    public function getClienteId(){
        return $this->cliente_id;
    }

    public function setClienteId(string $cliente_id){
        $this->cliente_id = $cliente_id;
    }
    public function getDescricaoProblema(){
        return $this->descricao_problema;
    }
    
    public function setDescricaoProblema(string $descricao_problema){
        $this->descricao_problema = $descricao_problema;
    }

    public function getDataPreferida(){
        return $this->data_preferida;
    }

    public function setDataPreferida(string $data_preferida){
        $this->data_preferida = $data_preferida;
    }
     public function getStatus(){
        return $this->status;
    }

    public function setStatus(int $status){
        $this->status = $status;
    }
    public function getDataCad(){
        return $this->data_cad;
    }

    public function setDataCad(string $data_cad){
        $this->data_cad = $data_cad;
    }
    public function getDataAtualizacao(){
        return $this->data_atualizacao;
    }
    
    public function setDataAtualizacao(string $data_atualizacao){
        $this->data_atualizacao = $data_atualizacao;
    }

    public function getDataResposta(){
        return $this->data_resposta;
    }

    public function setDataResposta(string $data_resposta){
        $this->data_resposta = $data_resposta;
    }

        public function getResposta(){
        return $this->resposta_admin;
    }
    
    public function setResposta(string $resposta_admin){
        $this->resposta_admin = $resposta_admin;
    }

    public function getEndereco(){
        return $this->endereco;
    }

    public function setEndereco(string $endereco){
        $this->endereco = $endereco;
    }


    // inserir --------------
 public function inserir():bool{
        $sql = "INSERT solicitacoes (id, cliente_id, descricao_problema, data_preferida, data_cad, data_atualizacao, data_resposta, resposta_admin, endereco)
         values (:id, :cliente_id, :descricao_problema, :data_preferida, :data_cad, :data_atualizacao, :data_resposta, :resposta_admin, :endereco)";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":cliente_id", $this->cliente_id);
        $cmd->bindValue(":descricao_problema", $this->descricao_problema);
        $cmd->bindValue(":data_preferida", $this->data_preferida);
        $cmd->bindValue(":endereco", $this->endereco);

        if($cmd->execute()){
            $this->id = $this->pdo->lastInsertId();
            return true;
        }
        return false;
    }

    //listar -----------------
  public static function listar(): array {
          $sql = "SELECT s.id, s.status, s.data_cad,
            u.nome AS cliente_nome,
            u.email AS cliente_email,
            GROUP_CONCAT(se.nome SEPARATOR ', ') AS servicos
    FROM solicitacoes s
    INNER JOIN clientes c ON c.id = s.cliente_id
    INNER JOIN usuarios u ON u.id = c.usuario_id
    INNER JOIN servico_solicitacao ss ON ss.solicitacao_id = s.id
    INNER JOIN servicos se ON se.id = ss.servico_id
    GROUP BY s.id, s.status, s.data_cad, u.nome, u.email
    ORDER BY s.data_cad DESC";

        $cmd = obterPdo()->query($sql);
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }


    //listar Cliente-----------------
  public static function listarPorCliente(int $cliente_id): array {
        $sql = "SELECT * FROM solicitacoes WHERE cliente_id = :cliente_id ORDER BY data_cad DESC";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":cliente_id", $cliente_id, PDO::PARAM_INT);
        $cmd->execute();
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

//Buscar por id ------------------------
public function buscarPorId(int $id):bool{
        $sql = "SELECT * FROM solicitacoes WHERE id = :id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":id", $id, PDO::PARAM_INT);
        $cmd->execute();
        if($cmd->rowCount() > 0){
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
            var_dump($dados);
            $this->id = ($dados['id']);
            $this->cliente_id = $dados['cliente_id'];
            $this->descricao_problema = $dados['descricao_problema'];
            $this->data_preferida = $dados['data_preferida'];
            $this->status = $dados['status'];
            $this->data_cad = $dados['data_cad'];
            $this->data_resposta = $dados['data_resposta'];
            $this->resposta_admin = $dados['resposta_admin'];
            $this->endereco = $dados['endereco'];
            $this->servicos = ServicoSolicitacao::listarServicosDaSolicitacao($dados["id"]);
        return true;
        }
        return false;
}

    //Responder 
    public function responder(string $resposta, int $status): bool{

         
        $sql = "UPDATE solicitacoes 
                SET resposta_admin = :resposta,
                    status = :status,
                    data_resposta = NOW(),
                    data_atualizacao = NOW()
                WHERE id = :id";

        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":resposta", $resposta);
        $cmd->bindValue(":status", $status, PDO::PARAM_INT);
        $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $cmd->execute();
    }


//Atualizar Status-------------------
      public function atualizarStatus(int $status): bool {
        if (!$this->id) return false;

        $sql = "UPDATE solicitacoes 
                SET status = :status,
                    data_atualizacao = NOW()
                WHERE id = :id";

        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":status", $status, PDO::PARAM_INT);
        $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $cmd->execute();
    }
}