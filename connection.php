<?php

if(!defined('ACCESS')) {
    header("Location: /");
    die("Erro: Pagina nao encontrada!<br>");
}

$host = "172.20.0.2"; 
$user = "root";
$pass = "webstoredoce"; 
$dbname = "webstore";
$port = 3309;

try {
    //Conexao com o BD utilizando a porta
    //$conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $pass);
    //Conexao com o BD nao utilizando a porta
    $conn = new PDO("mysql:host=$host;dbname=".$dbname, $user, $pass);
    //echo "Conexão com banco de dados realizado com sucesso!<br>";
} catch (Exception $ex) {
    //echo "Erro: Conexão com banco de dados não realizada com sucesso.<br>";
    die("Erro: Por favor tente novamente. Caso o problema persista, entre em contato o administrador: <br>");
}

