<?php

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Pagina nao encontrada!<br>");
}

$host = HOST;
$user = USER;
$password = PASS;
$dbname = DBNAME;
$port = PORT;

$conn = mysqli_connect($host . ":" . $port, $user, $password, $dbname);

if ($conn) {
    //echo "Conexão realizada com sucesso!";
} else {
    die("Erro: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM . "!<br>");
}



