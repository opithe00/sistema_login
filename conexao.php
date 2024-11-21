<?php
/*
   Conexão com BD usando PDO : PDO permite acessar
   qualquer banco de dados.
   PDO = PHP Data Objects = PHP Objetos de dados 
*/
// Declara as variáveis com os dados de conxão 
$host = 'localhost';
$dbname = 't57_login';
$usuario = 'root';
$senha = "";

// Data Source Name = Nome da origem dos dados
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try{
    // Cria a conexão
    $conn = new PDO($dsn,$usuario,$senha);

    $conn->setAttribute(PDO::ATTR_AUTOCOMMIT,PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die("ERRO de Conexão ".$e->getMessage());
}