<?php
require ('../../controllers/conexao.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST["cpf"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    function inserirRegistro($pdo, $cpf, $nome, $email, $senha) {
        $sql = "INSERT INTO cadastro (cpf, nome, email, senha) VALUES (:cpf, :nome, :email, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        return $stmt->execute();
    }

    if (inserirRegistro($pdo, $cpf, $nome, $email, $senha)) {
        // Obtendo o ID gerado
        $id = $pdo->lastInsertId();
        
        // Salvando o ID na sessão
        $_SESSION['nome'] = $nome;
        $_SESSION['email'] = $email;

        echo "
            <script type=\"text/javascript\">
                alert(\"Registrado com sucesso!.\");
            </script>
        ";
        header("refresh: 1; url=../../views/html/page1.php");
        exit();
    } else {
        echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/Uploud/cadastrar.php'>
            <script type=\"text/javascript\">
                alert(\"Erro ao registrar.\");
            </script>
        ";
    }
}
?>

