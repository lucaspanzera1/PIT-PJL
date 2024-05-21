<?php

// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd_arenarental";

$conn = new mysqli($servername, $username, $password, $dbname);

session_start();

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Obter os valores do formulário
$email = $_POST['email'];
$password = $_POST['password'];

// Consulta SQL para verificar se o email e a senha estão corretos
$sql = "SELECT * FROM cadastro WHERE email='$email' AND senha='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login bem-sucedido

    $row = $result->fetch_assoc();
    $nome = $row['nome'];
    $_SESSION['nome'] = $nome;
    echo "Login bem-sucedido! Bem vindo $nome";


    header("Location: tela1.php");

    die();
   
} else {
    header("Location: ErroLogin.php");

    die();
}

$_SESSION['nome'] = $nome;

$conn->close();
?>