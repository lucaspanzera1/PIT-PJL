<?php
require('../../controllers/conexao.php');
include('../../models/php/funcao.php');


$id_user = SalvaID();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    function deletarImagens($pdo, $id_user) {
        $sql_imagens = "DELETE FROM imagem WHERE id_user = :id_user";
        $stmt_imagens = $pdo->prepare($sql_imagens);
        $stmt_imagens->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt_imagens->execute();
    }

    function deletarConta($pdo, $id_user) {
        $sql = "DELETE FROM cadastro WHERE id = :id_user";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Deletar imagens
    deletarImagens($pdo, $id_user);

    if (deletarConta($pdo, $id_user)) {
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
