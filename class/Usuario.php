<?php 
//incluir a conexão
include_once "config/conexao.php";
//declarae a classe
class Usuario{
    //atributos 
    private $id=0;
    private $nome;
    private $email;
    private $senha;
    private $tipo;
    private $ativo;
    private $primeiro_login;
    private $pdo;
    //construtor
    public function __construct()
    {
       $this->pdo = obterPdo();
    }
    //Getters / Setters
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
    public function getEmail(){
        return $this->email;
    }
    
    public function setEmail(string $email){
        $this->email = $email;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setSenha(string $senha){
        $this->senha = $senha;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function setTipo(string $tipo){
        $this->tipo = $tipo;
    }

    public function getAtivo(){
        return $this->ativo;
    }

     public function setAtivo(string $ativo){
        $this->ativo = $ativo;
    }

    public function getPrimeiroLogin(){
        return $this->primeiro_login;
    }

    public function setPrimeiroLogin(string $primeiro_login){
        $this->primeiro_login = $primeiro_login;
    }

    //metodos (functions)

    //efetuar login
    public static function efetuarLogin(string $email, string $senha):array{
        $sql = "select * from usuarios where email = :email and ativo = b'1'";
        $cmd = obterPdo()->prepare($sql) ; //o "pdo" é um atributo da classe usuario
        $cmd->bindValue(":email", $email);
        $cmd->execute();
        $dados = $cmd->fetch(PDO::FETCH_ASSOC);
        if($dados && password_verify($senha, $dados['senha'])){
            return $dados;
        }else{
            return$dados = [];
        }
    }

    // inserir --------------
    public function inserir():bool{
        $sql = "INSERT usuarios (nome, email, senha, tipo) values (:nome, :email, :senha, :tipo)";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":nome", $this->nome);
        $cmd->bindValue(":email", $this->email);
        $cmd->bindValue(":senha", password_hash( $this->senha, PASSWORD_DEFAULT));
        $cmd->bindValue(":tipo", $this->tipo);
        if($cmd->execute()){
            $this->id = $this->pdo->lastInsertId();
            return true;
        }
        return true;
    }
    //listar -----------------
    public static function listar():array{
        $cmd = obterPdo()->query("select * from usuarios order by id desc");
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }

    //Buscar por id ------------------------
    public function buscarPorId(int $id):array{
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        if($cmd->rowCount() > 0){
            $dados = $cmd->fetch(PDO::FETCH_ASSOC);
            var_dump($dados);
            $this->setId($dados['id']);
            $this->setNome($dados['nome']);
            $this->setEmail($dados['email']);
            $this->setSenha($dados['senha']);
            $this->setTipo($dados['tipo']);
            $this->setAtivo($dados['ativo']);
            $this->primeiro_login = ($dados['primeiro_login']);
        }
        return [];
    }

    //Atualizar -------------------
    public function atualizar():bool{

        if(!$this->id) return false;
        // var_dump($this->id);
        // die();
        $sql = "UPDATE usuarios set nome = :nome, email= :email, tipo = :tipo, ativo = :ativo, primeiro_login = :primeiro_login WHERE id = :id";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindValue(":id", $this->id );
        $cmd->bindValue(":nome", $this->nome );
        $cmd->bindValue(":email", $this->email );
        $cmd->bindValue(":tipo", $this->tipo );
        $cmd->bindValue(":ativo", $this->ativo, PDO::PARAM_BOOL);
        $cmd->bindValue(":primeiro_login", $this->primeiro_login, PDO::PARAM_BOOL);
        return $cmd->execute();
    }
}