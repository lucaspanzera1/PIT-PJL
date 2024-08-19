<?php
require('../../controllers/conexao.php');
include '../../models/php/funcao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os dados do formulário
    $descricao = $_POST["descricao"];

    $id_user = $_SESSION['id'];
    $nome_dono = $_SESSION['nome'];

    function inserirQuadra($pdo, $descricao, $id_user, $nome_dono) {
        $sql = "INSERT INTO quadra ( descricao, id_user, nome_dono) VALUES (:descricao, :id_user, :nome_dono)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':nome_dono', $nome_dono, PDO::PARAM_STR);
        return $stmt->execute();
    }

    if (inserirQuadra($pdo, $descricao, $id_user, $nome_dono)) {
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
