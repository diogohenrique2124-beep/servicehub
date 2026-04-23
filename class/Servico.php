<?php 
include_once "config/conexao.php";

class Servico{
private $id=0;
private $nome;
private $descricao;
private $preco;
private $descontinuado;
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
    public function getNome(){
        return $this->nome;
    }

    public function setNome(string $nome){
        $this->nome = $nome;
    }
    public function getDescricao(){
        return $this->descricao;
    }
    
    public function setDescricao(string $descricao){
        $this->descricao = $descricao;
    }

    public function getPreco(){
        return $this->preco;
    }

    public function setPreco(string $preco){
        $this->preco = $preco;
    }

     public function getDescontinuado(){
        return $this->descontinuado;
    }

    public function setDescontinuado(string $descontinuado){
        $this->preco = $descontinuado;
    }

     // inserir --------------
 public function inserir():bool{
        $sql = "INSERT servicos (id, nome, descricao, preco, descontinuado) values (:id, :nome, :descricao, :preco, :descontinuado)";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $this->id);
        $cmd->bindValue(":nome", $this->nome);
        $cmd->bindValue(":descricao", $this->descricao);
        $cmd->bindValue(":preco", $this->preco);
        $cmd->bindValue(":descontinuado", $this->descontinuado);
        if($cmd->execute()){
            $this->id = $this->pdo->lastInsertId();
            return true;
        }
        return true;
    }

      //Atualizar -------------------
     public function atualizar():bool{

        if(!$this->id) return false;
        // var_dump($this->id);
        // die();
        $sql = "UPDATE servicos set id = :id, nome= :nome, descricao = :descricao, preco = :preco, descontinuado = :descontinuado";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $this->id );
        $cmd->bindValue(":nome", $this->nome );
        $cmd->bindValue(":descricao", $this->descricao );
        $cmd->bindValue(":preco", $this->preco );
         $cmd->bindValue(":descontinuado", $this->descontinuado );
        return $cmd->execute();
    }
 //listar -----------------
 public static function listar():array{
        $cmd = obterPdo()->query("select * from servicos order by id desc");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }
//listar Ativos -------------------


 //Buscar por id ------------------------
public function buscarPorId(int $id):array{
        $sql = "SELECT * FROM servicos WHERE id = :id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        if($cmd->rowCount() > 0){
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
            var_dump($dados);
            $this->setId($dados['id']);
            $this->setNome($dados['nome']);
            $this->setDescricao($dados['descricao']);
            $this->setPreco($dados['preco']);
            $this->setDescontinuado($dados['descontinuado']);
        }
        return [];
    }

//Excluir


}
 ?>