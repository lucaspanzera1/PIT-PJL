<?php

// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd_arenauser";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
//Inicia a sessão, para salvar a variável $nome
session_start();


// Obter os valores do formulário
$email = $_POST['email'];
$_SESSION['email'] = $email;
$password = $_POST['password'];

// Consulta SQL para verificar se o email e a senha estão corretos
$sql = "SELECT * FROM cadastro WHERE email='$email' AND senha='$password'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {

      // Salva o ID do usuário em uma sessão
      $email = $_POST['email'];
      $_SESSION['email'] = $email;

      $row = $result->fetch_assoc();

      $id_usuario = $row['id'];
      $_SESSION['id_usuario'] = $id_usuario;

  
      // Salva o nome do usuário em uma sessão
      $nome = $row['nome'];
      $_SESSION['nome'] = $nome;

    echo "Login bem-sucedido! Redirecionando...";
    //Altera de tela após o script rodar

    echo "
					<script type=\"text/javascript\">
						alert(\"Usuário válidado!\");
					</script>
				";

    header("refresh: 1; url=../../views/html/tela1.php");
    exit();
    
   
    
} else {
    echo "
					<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/ArenaRental/index.php'>
					<script type=\"text/javascript\">
						alert(\"Email ou senha incorretos!\");
					</script>
				";
}


$conn->close();
?>