<?php
require('../../controllers/conexao.php');
include '../../models/php/funcao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os dados do formulário
    $nome_quadra = $_POST["nome_quadra"];
    $esporte = $_POST["esporte"];
    $localizacao = $_POST["localizacao"];
    $descricao = $_POST["descricao"];
    $valor = $_POST["valor"];

    // Obtenha o id_user e nome_dono da sessão
    session_start();
    $id_user = $_SESSION['id'];
    $nome_dono = $_SESSION['nome'];

    function inserirQuadra($pdo, $nome_quadra, $esporte, $localizacao, $descricao, $valor, $id_user, $nome_dono) {
        $sql = "INSERT INTO quadra (nome_quadra, esporte, localizacao, descricao, valor, id_user, nome_dono) VALUES (:nome_quadra, :esporte, :localizacao, :descricao, :valor, :id_user, :nome_dono)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome_quadra', $nome_quadra, PDO::PARAM_STR);
        $stmt->bindParam(':esporte', $esporte, PDO::PARAM_STR);
        $stmt->bindParam(':localizacao', $localizacao, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':nome_dono', $nome_dono, PDO::PARAM_STR);
        return $stmt->execute();
    }

    if (inserirQuadra($pdo, $nome_quadra, $esporte, $localizacao, $descricao, $valor, $id_user, $nome_dono)) {
        echo "
            <script type=\"text/javascript\">
                alert(\"Quadra registrada com sucesso!.\");
                window.location.href = 'http://localhost/ArenaRental/views/html/registra.quadra2.php';
            </script>
        ";
        exit();
    } else {
        echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao registrar a quadra.\");
                window.location.href = 'http://localhost/ArenaRental/views/html/registra.quadra1.php';
            </script>
        ";
        exit();
    }
}
?>
