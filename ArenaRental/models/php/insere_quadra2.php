<?php
require('../../controllers/conexao.php');
include '../../models/php/funcao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os dados do formulário
    $titulo = $_POST["Titulo"];
    $esporte = $_POST["esporte"];
    $localizacao = $_POST["Localizacao"];
    $descricao = $_POST["descricao"]; // Campo descrição, pode estar vazio
    $valor = $_POST["Valor"];

    // Obtenha o usuário atual
    $id_user = $_SESSION['id'];
    $nome_dono = $_SESSION['nome'];

    // Função para atualizar o registro da quadra existente com base no id_user e nome_dono
    function atualizarQuadra($pdo, $titulo, $esporte, $localizacao, $descricao, $valor, $id_user, $nome_dono) {
        // Verifica se já existe um registro para o usuário atual
        $sql_check = "SELECT id, descricao FROM quadra WHERE id_user = :id_user AND nome_dono = :nome_dono";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt_check->bindParam(':nome_dono', $nome_dono, PDO::PARAM_STR);
        $stmt_check->execute();
        $quadra = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($quadra) {
            // Se já existe uma quadra para este usuário, atualiza o registro
            // Se o campo descrição estiver vazio, mantenha a descrição atual
            if (empty($descricao)) {
                $descricao = $quadra['descricao'];
            }

            $sql_update = "UPDATE quadra 
                           SET nome_quadra = :titulo, esporte = :esporte, localizacao = :localizacao, descricao = :descricao, valor = :valor 
                           WHERE id_user = :id_user AND nome_dono = :nome_dono";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $stmt_update->bindParam(':esporte', $esporte, PDO::PARAM_STR);
            $stmt_update->bindParam(':localizacao', $localizacao, PDO::PARAM_STR);
            $stmt_update->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt_update->bindParam(':valor', $valor, PDO::PARAM_STR);
            $stmt_update->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $stmt_update->bindParam(':nome_dono', $nome_dono, PDO::PARAM_STR);
            return $stmt_update->execute();
        } else {
            // Se não existe, insere um novo registro
            $sql_insert = "INSERT INTO quadra (nome_quadra, esporte, localizacao, descricao, valor, id_user, nome_dono) 
                           VALUES (:titulo, :esporte, :localizacao, :descricao, :valor, :id_user, :nome_dono)";
            $stmt_insert = $pdo->prepare($sql_insert);
            $stmt_insert->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $stmt_insert->bindParam(':esporte', $esporte, PDO::PARAM_STR);
            $stmt_insert->bindParam(':localizacao', $localizacao, PDO::PARAM_STR);
            $stmt_insert->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt_insert->bindParam(':valor', $valor, PDO::PARAM_STR);
            $stmt_insert->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $stmt_insert->bindParam(':nome_dono', $nome_dono, PDO::PARAM_STR);
            return $stmt_insert->execute();
        }
    }

    // Verifica se a função de atualização ou inserção foi bem-sucedida
    if (atualizarQuadra($pdo, $titulo, $esporte, $localizacao, $descricao, $valor, $id_user, $nome_dono)) {
        echo "
            <script type=\"text/javascript\">
                alert(\"Quadra registrada ou atualizada com sucesso!.\");
                window.location.href = 'http://localhost/ArenaRental/views/html/registra.quadra4.php';
            </script>
        ";
        exit();
    } else {
        echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao registrar ou atualizar a quadra.\");
                window.location.href = 'http://localhost/ArenaRental/views/html/registra.quadra3.php';
            </script>
        ";
        exit();
    }
}
?>
