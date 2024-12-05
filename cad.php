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
   $nome = htmlspecialchars($_POST['nome']);
   $navegador = obterUserAgent();
   $Ip = obterIp();
   $Lingua = obtemIdiomaNavegador();
   // Exibe a Variavel para testar
   //var_dump($senha);

   //Bloco tente para cadastrar no banco de dados
   try{
    // prepara o comando SQL para inserir no banco de dados
    // Utilizar o Prepered para preverir injetar SQL
    $stmt = $conn->prepare("INSERT INTO Usuarios (email,senha,nome,navegador,Ip,Lingua) VALUES (:email, :senha, :nome, :navegador, :Ip, :Lingua)");

    
    // Associa os valores das variaveis : email e :senha
    $stmt->bindParam(":email",$email); // Vincula o e-mail e limpa
    $stmt->bindParam(":senha",$senha);
    $stmt->bindParam(":nome",$nome);
    $stmt->bindParam(":navegador",$navegador);
    $stmt->bindParam("Ip",$Ip);
    $stmt->bindParam("Lingua",$Lingua);
    
    

    // Executa o código
    $stmt->execute();

    echo "Cadastrado com Sucesso";
  }catch(PDOException $e){
    echo "Erro ao cadastrar o usuário ;".$e->getMessage();
  }
}
function obterIp(){
  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      return $_SERVER['HTTP_CLIENT_IP'];
  } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
  return $_SERVER['HTTP_X_FORWARDED_FOR'];
  }else{
  return $_SERVER['REMOTE_ADDR'];
  }
}
echo obterIp();

// Obter idioma do navegador
function obtemIdiomaNavegador(){
  return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
}

echo obtemIdiomaNavegador();

// Função para obter o User-Agent completo (detalhes do navegador e sistema operacional)
function obterUserAgent() {
  // Captura o agente do usuário
  $userAgent = $_SERVER['HTTP_USER_AGENT'];

  // Inicializa a variável com "Desconhecido"
  $browser = "Desconhecido";

  // Verifica os navegadores mais comuns e algumas variações específicas
  if (strpos($userAgent, 'Firefox') !== false) {
      $browser = 'Mozilla Firefox';
  } elseif (strpos($userAgent, 'Edg') !== false) {
      $browser = 'Microsoft Edge';
  } elseif (strpos($userAgent, 'OPR') !== false || strpos($userAgent, 'Opera') !== false) {
      $browser = 'Opera';
  } elseif (strpos($userAgent, 'Chrome') !== false && strpos($userAgent, 'Chromium') === false && strpos($userAgent, 'Edg') === false && strpos($userAgent, 'OPR') === false) {
      $browser = 'Google Chrome';
  } elseif (strpos($userAgent, 'Safari') !== false && strpos($userAgent, 'Chrome') === false && strpos($userAgent, 'Chromium') === false) {
      $browser = 'Safari';
  } elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) {
      $browser = 'Internet Explorer';
  } elseif (strpos($userAgent, 'Chromium') !== false) {
      $browser = 'Chromium';
  } elseif (strpos($userAgent, 'Brave') !== false) {
      $browser = 'Brave';
  } elseif (strpos($userAgent, 'Vivaldi') !== false) {
      $browser = 'Vivaldi';
  } elseif (strpos($userAgent, 'Yandex') !== false) {
      $browser = 'Yandex Browser';
  } elseif (strpos($userAgent, 'Maxthon') !== false) {
      $browser = 'Maxthon';
  } elseif (strpos($userAgent, 'Sleipnir') !== false) {
      $browser = 'Sleipnir';
  } elseif (strpos($userAgent, 'UC Browser') !== false || strpos($userAgent, 'UCBrowser') !== false) {
      $browser = 'UC Browser';
  } elseif (strpos($userAgent, 'QQBrowser') !== false) {
      $browser = 'QQ Browser';
  } elseif (strpos($userAgent, 'Baidu') !== false || strpos($userAgent, 'BIDUBrowser') !== false) {
      $browser = 'Baidu Browser';
  } elseif (strpos($userAgent, 'SamsungBrowser') !== false) {
      $browser = 'Samsung Internet';
  } elseif (strpos($userAgent, 'Netscape') !== false) {
      $browser = 'Netscape Navigator';
  } elseif (strpos($userAgent, 'Konqueror') !== false) {
      $browser = 'Konqueror';
  } elseif (strpos($userAgent, 'SeaMonkey') !== false) {
      $browser = 'SeaMonkey';
  } elseif (strpos($userAgent, 'Epiphany') !== false) {
      $browser = 'Epiphany';
  } elseif (strpos($userAgent, 'PaleMoon') !== false) {
      $browser = 'Pale Moon';
  } elseif (strpos($userAgent, 'Comodo') !== false) {
      $browser = 'Comodo Dragon';
  } elseif (strpos($userAgent, 'Tor Browser') !== false || strpos($userAgent, 'TorBrowser') !== false){
      $browser = 'Tor Browser';
  }
  return $browser;
}