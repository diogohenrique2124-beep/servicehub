<?php 
include_once "config/conexao.php";

class Servico{
private $id;
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
        $sql = "INSERT servicos (id, nome, descricao, preco, descontinuado) VALUES 
        (:id, :nome, :descricao, :preco, :b'0')";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":nome", $this->nome);
        $cmd->bindValue(":descricao", $this->descricao);
        $cmd->bindValue(":preco", $this->preco);

        if($cmd->execute()){
            $this->id = $this->pdo->lastInsertId();
            return true;
        }
        return false;
    }

      //Atualizar -------------------
     public function atualizar():bool{

        if(!$this->id) return false;
        // var_dump($this->id);
        // die();
        $sql = "UPDATE servicos SET id = :id, nome= :nome, descricao = :descricao, preco = 
        :preco, descontinuado = :descontinuado";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $this->id , PDO::PARAM_INT);
        $cmd->bindValue(":nome", $this->nome );
        $cmd->bindValue(":descricao", $this->descricao );
        $cmd->bindValue(":preco", $this->preco );
        return $cmd->execute();
    }
 //listar -----------------
 public static function listar():array{
        $cmd = obterPdo()->query("SELECT * FROM servicos ORDER BY id DESC");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }
//listar Ativos -------------------

    public static function listarAtivos(): array {
        $cmd = obterPdo()->query("SELECT * FROM servicos WHERE descontinuado=b'0' 
        ORDER BY nome ASC");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }


 //Buscar por id ------------------------
public function buscarPorId(int $id):bool{
        $sql = "SELECT * FROM servicos WHERE id = :id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":id", $id, PDO::PARAM_INT);
        $cmd->execute();
        if($cmd->rowCount() > 0){
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
            var_dump($dados);
            $this->id = $dados['id'];
            $this->nome = $dados['nome'];
            $this->descricao = $dados['descricao'];
            $this->preco = $dados['preco'];
            $this->descontinuado = $dados['descontinuado'];
        return true;
        }
        return false;
    }

//Excluir
public static function excluir(int $id): bool {
        $sql = "UPDATE servicos SET descontinuado=b'1' WHERE id = :id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":id", $id, PDO::PARAM_INT);
        return $cmd->execute();

}
}
 ?>