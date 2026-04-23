<?php 
include_once "config/conexao.php";

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
private $pdo;

 public function __construct()
    {
       $this->pdo = obterPdo();
    }

 public function getId(){
        return $this->id;
    }

    public function setId(string $id){
        $this->id = $id;
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

    public function setStatus(string $status){
        $this->id = $status;
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

        public function getRespostaAdmin(){
        return $this->resposta_admin;
    }
    
    public function setRespostaAdmin(string $resposta_admin){
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
        $cmd->bindValue(":id", $this->id);
        $cmd->bindValue(":cliente_id", $this->cliente_id);
        $cmd->bindValue(":descricao_problema", $this->descricao_problema);
        $cmd->bindValue(":data_preferida", $this->data_preferida);
        $cmd->bindValue(":data_cad", $this->data_cad);
        $cmd->bindValue(":data_atualizacao", $this->data_atualizacao);
        $cmd->bindValue(":data_resposta", $this->data_resposta);
        $cmd->bindValue(":resposta_admin", $this->resposta_admin);
        $cmd->bindValue(":endereco", $this->endereco);

        if($cmd->execute()){
            $this->id = $this->pdo->lastInsertId();
            return true;
        }
        return true;
    }

    //listar -----------------
 public static function listar():array{
        $cmd = obterPdo()->query("select * from solicitacoes order by id desc");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    //listar Cliente-----------------
 public static function listarPorCliente(int $cliente_id): array{
        $cmd = obterPdo()->query("select * from clientes_id order by id desc");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

//Buscar por id ------------------------
public function buscarPorId(int $id):array{
        $sql = "SELECT * FROM solicitacoes WHERE id = :id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        if($cmd->rowCount() > 0){
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
            var_dump($dados);
            $this->setId($dados['id']);
            $this->setClienteId($dados['cliente_id']);
            $this->setDescricaoProblema($dados['descricao_problema']);
            $this->setDataPreferida($dados['data_preferida']);
            $this->setStatus($dados['status']);
            $this->setDataCad($dados['data_cad']);
            $this->setDataAtualizacao($dados['data_atualizacao']);
            $this->setDataResposta($dados['data_resposta']);
            $this->setRespostaAdmin($dados['resposta_admin']);
            $this->getEndereco($dados['endereco']);
        }
        return [];
    }

}