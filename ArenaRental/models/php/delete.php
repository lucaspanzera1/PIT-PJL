<?php
require ('../../controllers/conexao.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST["cpf"];

    function deletarImagens($pdo, $email) {
        $sql_imagens = "DELETE FROM imagem WHERE email_user = :email";
        $stmt_imagens = $pdo->prepare($sql_imagens);
        $stmt_imagens->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_imagens->execute();
    }

    function deletarConta($pdo, $cpf) {
        $sql = "DELETE FROM cadastro WHERE cpf = :cpf";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Obtém o email do usuário
    $sql_email = "SELECT email FROM cadastro WHERE cpf = :cpf";
    $stmt_email = $pdo->prepare($sql_email);
    $stmt_email->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $stmt_email->execute();
    $result = $stmt_email->fetch(PDO::FETCH_ASSOC);
    $email = $result['email'];

    // Deletar imagens
    deletarImagens($pdo, $email);

    if (deletarConta($pdo, $cpf)) {
        // Removendo informações da sessão
        unset($_SESSION['nome']);
        unset($_SESSION['email']);

        echo "
            <script type=\"text/javascript\">
                alert(\"Conta deletada com sucesso!.\");
            </script>
        ";
        header("refresh: 1; url=../../views/html/index.php"); // Redireciona para a página inicial
        exit();
    } else {
        echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/Uploud/page1.php'>
            <script type=\"text/javascript\">
                alert(\"Erro ao deletar conta.\");
            </script>
        ";
    }
}
?>
