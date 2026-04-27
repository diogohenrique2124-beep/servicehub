<?php 
include_once "config/conexao.php";

class ServicosSolicitacao{
private $servico_id;
private $solicitacao_id;
private $data_assoc;
private $pdo;

 public function __construct()
    {
       $this->pdo = obterPdo();
    }

 public function getServicoId(){
        return $this->servico_id;
    }

    public function setServicoId(int $servico_id){
        $this->servico_id = $servico_id;
    }
    public function getSolicitacaoId(){
        return $this->solicitacao_id;
    }

    public function setSolicitacaoId(int $solicitacao_id){
        $this->solicitacao_id = $solicitacao_id;
    }
    public function getDataAssoc(){
        return $this->data_assoc;
    }


    //Associar 

     public static function associar(int $servico_id, int $solicitacao_id): bool{
        $sql = "insert servico_solicitacao values(:servico,:solicitacao_id, default)";
        $cmd = obterPdo()-> prepare($sql);
        $cmd->bindValue(":servico_id", $servico_id);
        $cmd->bindValue(":solicitacao_id", $solicitacao_id);
        return $cmd->execute();
    }

    //Listar Servicos Da Solicitacao
     public function listarServicosDaSolicitacao(int $solicitacao_id): array{
        $sql = "SELECT se.*, ss.data_assoc
                FROM servico_solicitacao ss
                INNER JOIN servicos se ON se.id = ss.servico_id
                WHERE ss.solicitacao_id = :solicitacao_id";
        $cmd = obterPdo()->prepare($sql);
        $cmd->bindValue(":solicitacao_id", $solicitacao_id, PDO::PARAM_INT);
        $cmd->execute();
        return $cmd->fetchAll(PDO::FETCH_ASSOC);
     }


}