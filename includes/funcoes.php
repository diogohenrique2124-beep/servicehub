<?php 
function statusTexto($status){
    switch($status){
        case 1: return "Pendente";
        case 2: return "EM andamento";
        case 3: return "Finalizado";
        case 4: return "Cancelado";
        case 5: return "Recusada";
        default: return "Desconhecido";
    }
}