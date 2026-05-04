<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
 
require_once "class/Cliente.php";
require_once "class/Usuario.php";
require_once "class/Solicitacao.php";
require_once "class/Servico.php";
require_once "class/ServicoSolicitacao.php";
 
if ($_SERVER['REQUEST_METHOD'] !== "POST"){
    header("location: contratar.php?erro=Invalid Request.");
    exit();
}
 
// verificação de segurança (se quem está logado tem direito de carregar esta página)
// CSRF
$token = $_POST['csrf_token']?? "";
if(!$token || !isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token'] ){
    header("location: contratar.php?erro=Falha de segurança CSRF detectada.");
    exit();
}
// inputs (são os campos do formulário)
$nome = filter_input(INPUT_POST,'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL);
$telefone = filter_input(INPUT_POST,'telefone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 
$endereco = filter_input(INPUT_POST,'endereco', FILTER_UNSAFE_RAW);
$descricao = filter_input(INPUT_POST,'descricao', FILTER_UNSAFE_RAW);
 
$data_preferida = filter_input(INPUT_POST,'data_preferida', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 
$cpf = preg_replace('/\D/','',$_POST['cpf'] ?? "");
$servicos_ids = $_POST['servicos_ids'] ?? []; // array de serviçoes
 
// validação dos serviços:
if(!is_array($servicos_ids)){
    header("location: contratar.php?erro=Selecione ao menos um serviço.");
    exit();
}
$servicos_validos = [];
 
foreach($servicos_ids as $id){
    $id = filter_var($id, FILTER_VALIDATE_INT);
    $servicos_validos[] = $id;
}
// Validações gerais
if(!$nome || strlen($nome) < 3){
    header("location: contratar.php?erro=Nome inválido.");
    exit();
}
if(!$email){
    header("location: contratar.php?erro=Email inválido.");
    exit();
}
if(!$telefone || strlen($telefone) < 8){
    header("location: contratar.php?erro=Telefone inválido.");
    exit();
}
if(!$endereco || strlen($endereco) < 5){
    header("location: contratar.php?erro=Endereço inválido.");
    exit();
}
if(!$descricao || strlen($descricao) < 10){
    header("location: contratar.php?erro=Descreva melhor o problema (mínimo 10 caracteres).");
    exit();
}
if(!$cpf && strlen($cpf) != 11){
    header("location: contratar.php?erro=Cpf Inválido. Digite 11 números.");
    exit();
}
 
if(count($servicos_validos) < 1){
    header("location: contratar.php?erro=Selecione ao menos um serviço válido.");
    exit();
}
if($data_preferida){
    $ts = strtotime($data_preferida);
    if($ts === false){
        header("location: contratar.php?erro=Data Inválida.");
        exit();
    }
    if($ts < strtotime(date('Y-m-d'))){
        header("location: contratar.php?erro=A data não pode ser anterior a hoje.");
        exit();
    }
}
try {
// verificar se o usuário existe
    $usuarioBanco = new Usuario();
    if ($usuarioBanco->buscarPorEmail($email)==false){
        // se retornou falso é por que não tem usuário com este email no banco
        // então gravamos!!!!!!!!!!!!
        $usuario = new Usuario();
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $usuario->setSenha("123456");
        $usuario->setTipo(2);
        $usuario->setAtivo(true);
        $usuario->setPrimeiroLogin(true);
        if (!$usuario->inserir()){
            header("location: contratar.php?erro=Erro ao cadastrar o Usuário");
            exit();
        }
        $usuario_id = $usuario->getId();
    }else{
        $usuario_id = $usuarioBanco->getId();
    }
    // verificar se o cliente existe
    $cliente = new Cliente();
    if ($cliente->buscarPorUsuario($usuario_id)==false){
        // gravamos o cliente
        $cliente->setUsuarioId($usuario_id);
        $cliente->setTelefone($telefone);
        $cliente->setCpf($cpf);
        if(!$cliente->inserir()){
            header("location: contratar.php?erro=Erro ao cadastrar o Cliente");
            exit();
        }
    }
    $cliente_id = $cliente->getId();
    // cadastrar solicitação:
    $solicitacao = new Solicitacao();
    $solicitacao->setClienteId($cliente_id);
    $solicitacao->setDescricaoProblema($descricao);
    $solicitacao->setDataPreferida($data_preferida ?: null);
    $solicitacao->setEndereco($endereco);
 
    if(!$solicitacao->inserir()){
        header("location: contratar.php?erro=Erro ao cadastrar a solicitação");
        exit();
    }
    $solicitacao_id = $solicitacao->getId();
   
    //Associar os serviços à solicitação. (valeu como aula de hoje?????)
    // vamos....
    foreach($servicos_validos as $servico_id){
        // print_r($solicitacao_id);die();
        $assoc = new ServicoSolicitacao();
        $assoc->setServicoId($servico_id);
        $assoc->setSolicitacaoId($solicitacao_id);
        if (!$assoc->associar()) {
            header("Location: contratar.php?erro=Erro ao vincular serviço.");
            exit;
        }
    }
    header("location: contratar.php?sucesso=1");
}
catch (Exception $e) {
 
    header("Location: contratar.php?erro=".$e->getMessage());
    exit;
}
 