<?php
echo "Inserindo dados abaixo... <br>";
require ('conexao.php');

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
}

if (inserirRegistro($pdo, $cpf, $nome, $email, $senha)) {
    header("Location: bemvindo.php");

    die();
} else {
    echo 'Erro ao inserir o registro.';
}
?>
