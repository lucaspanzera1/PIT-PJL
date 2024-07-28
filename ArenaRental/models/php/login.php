<?php
// Verificar se houve uma solicitação POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados
    require('../../controllers/conexao.php'); // Incluindo o arquivo de conexão

    session_start();

    // Receber os dados do formulário
    $cpf = $_POST["cpf"];
    $senha = $_POST["password"];

    // Consulta SQL para verificar se o CPF e senha correspondem a um registro na tabela cadastro
    $sql = "SELECT id, nome, email, tipo, data_registro FROM cadastro WHERE cpf = :cpf AND senha = :senha";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Salvando as informações do usuário na sessão
        $_SESSION['id'] = $user['id'];
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['tipo'] = $user['tipo'];
        $_SESSION['data_registro'] = $user['data_registro'];

        echo "<script type=\"text/javascript\">alert(\"Login bem-sucedido!\");</script>";

        // Redirecionando para a tela desejada após o login
        header("refresh: 1; url=http://localhost/ArenaRental/index.php");
        exit();
    } else {
        echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=http://localhost/ArenaRental/index.php'>
              <script type=\"text/javascript\">alert(\"CPF ou senha incorretos!\");</script>";
    }
}
?>
