<?php 
include_once "config/conexao.php";

class Cliente{
private $id;
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
        $sql = "INSERT clientes (usuario_id, telefone, cpf) 
        values (:usuario_id, :telefone, :cpf)";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":usuario_id", $this->usuario_id, PDO::PARAM_INT);
        $cmd->bindValue(":telefone", $this->telefone);
        $cmd->bindValue(":cpf", $this->cpf);
        if($cmd->execute()){
            $this->id = $this->pdo->lastInsertId();
            return true;
        }
        return false;
    }

       //Atualizar -------------------
    public function atualizar(): bool {
        if (!$this->id) return false;

        $sql = "UPDATE clientes 
                SET telefone = :telefone, cpf = :cpf
                WHERE id = :id";

        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $this->id, PDO::PARAM_INT);
        $cmd->bindValue(":telefone", $this->telefone);
        $cmd->bindValue(":cpf", $this->cpf);

        return $cmd->execute();
    }
 //listar -----------------
 public static function listar():array{
        $cmd = obterPdo()->query("select * from clientes order by id desc");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    //Buscar por id ------------------------
public function buscarPorId(int $id):bool{
        $sql = "SELECT * FROM clientes WHERE id = :id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":id", $id, PDO::PARAM_INT);
        $cmd->execute();
        if($cmd->rowCount() > 0){
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
            var_dump($dados);
            $this->id = ($dados['id']);
            $this->usuario_id = ($dados['usuario_id']);
            $this->telefone = ($dados['telefone']);
            $this->cpf = ($dados['cpf']);
        return true;
        }
        return false;
    }

       //Buscar por usuario ------------------------
public function buscarPorUsuario(int $usuario_id): bool {
    
    $sql = "SELECT * FROM usuarios WHERE usuario_id = :usuario_id LIMIT 1";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":usuario_id", $usuario_id, PDO::PARAM_INT);
        $cmd->execute();
        if($cmd->rowCount() > 0){
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
            var_dump($dados);
            $this->id = ($dados['id']);
            $this->usuario_id = ($dados['usuario_id']);
            $this->telefone = ($dados['telefone']);
            $this->cpf = ($dados['cpf']);
            return true;
        }
        return false;
    }

}
?>