<?php 
include_once "config/conexao.php";

class Cliente{
private $id=0;
private $usuario_id;
private $telefone;
private $cpf;
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
    public function getUsuario_id(){
        return $this->usuario_id;
    }

    public function setUsuario_id(string $usuario_id){
        $this->usuario_id = $usuario_id;
    }
    public function getTelefone(){
        return $this->telefone;
    }
    
    public function setTelefone(string $telefone){
        $this->telefone = $telefone;
    }

    public function getCpf(){
        return $this->cpf;
    }

    public function setCpf(string $cpf){
        $this->cpf = $cpf;
    }
 // inserir --------------
 public function inserir():bool{
        $sql = "INSERT clientes (id, usuario_id, telefone, cpf) values (:id, :usuario_id, :telefone, :cpf)";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $this->id);
        $cmd->bindValue(":usuario_id", $this->usuario_id);
        $cmd->bindValue(":telefone", $this->telefone);
        $cmd->bindValue(":cpf", $this->cpf);
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
        $sql = "UPDATE clientes set id = :id, usuario_id= :usuario_id, telefone = :telefone, cpf = :cpf";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $this->id );
        $cmd->bindValue(":usuario_id", $this->usuario_id );
        $cmd->bindValue(":telefone", $this->telefone );
        $cmd->bindValue(":cpf", $this->cpf );
        return $cmd->execute();
    }
 //listar -----------------
 public static function listar():array{
        $cmd = obterPdo()->query("select * from clientes order by id desc");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    //Buscar por id ------------------------
public function buscarPorId(int $id):array{
        $sql = "SELECT * FROM clientes WHERE id = :id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        if($cmd->rowCount() > 0){
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
            var_dump($dados);
            $this->setId($dados['id']);
            $this->setUsuario_id($dados['usuario_id']);
            $this->setTelefone($dados['telefone']);
            $this->setCpf($dados['cpf']);
        }
        return [];
    }

       //Buscar por usuario ------------------------
public function buscarPorUsuario(int $usuario_id):array{
    
    $sql = "SELECT * FROM usuarios";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":usuario_id", $usuario_id);
        $cmd->execute();
        if($cmd->rowCount() > 0){
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
            var_dump($dados);
            $this->setId($dados['id']);
            $this->setUsuario_id($dados['usuario_id']);
            $this->setTelefone($dados['telefone']);
            $this->setCpf($dados['cpf']);
        }
        return [];
    }

}
?>