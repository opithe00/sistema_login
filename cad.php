<?php
// Código para receber as informações do HTML e fazer algo
// Captura o que q usário digitou e cadastra no bd

// chama arquivo de conexão
include 'conexao.php';

// Vwrifica se existe alguma informação chegando pela Rede 
if($_SERVER["REQUEST_METHOD"] == "POST"){

   // Recebe o e-mail, filtra e armazena na variavel
   $email = htmlspecialchars($_POST['email']);

   // Recebe a senha, criptografa e armazena em uma variavel
   $senha = password_hash($_POST['senha'],PASSWORD_DEFAULT);

   // Exibe a Variavel para testar
   //var_dump($senha);

   //Bloco tente para cadastrar no banco de dados
   try{
    // prepara o comando SQL para inserir no banco de dados
    // Utilizar o Prepered para preverir injetar SQL
    $stmt = $conn->prepare("INSERT INTO Usuarios (email,senha) VALUES (:email, :senha)");

    
    // Associa os valores das variaveis : email e :senha
    $stmt->bindParam(":email",$email); // Vincula o e-mail e limpa
    $stmt->bindParam(":senha",$senha);

    // Executa o código
    $stmt->execute();

    echo "Cadastrado com Sucesso";

  }catch(PDOException $e){
    echo "Erro ao cadastrar o usuário ;".$e->getMessage();
  }
}