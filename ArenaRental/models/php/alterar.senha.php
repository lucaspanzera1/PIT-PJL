<?php
echo "Atualizando dados abaixo... <br>";
require('../../controllers/conexao.php');

session_start(); 

// Função para verificar se a senha atual está correta
function verificarSenha($pdo, $id, $senha) {
    $sql = "SELECT COUNT(*) AS total FROM cadastro WHERE id = :id AND senha = :senha"; // Verifica se a senha está correta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] > 0; // Retorna true se a senha estiver correta
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_SESSION["id"]; // Obtém o ID do usuário da sessão
    $senhaAtual = $_POST["senha_atual"]; // Captura a senha atual do formulário
    $novaSenha = $_POST["nova_senha"]; // Captura a nova senha do formulário
    $confirmaSenha = $_POST["confirma_senha"]; // Captura a confirmação da nova senha do formulário

    // Verifica se a senha atual está correta
    if (verificarSenha($pdo, $id, $senhaAtual)) {
        // Verifica se as senhas nova e de confirmação são iguais
        if ($novaSenha === $confirmaSenha) {
            // Atualiza a senha no banco de dados
            $sql = "UPDATE cadastro SET senha = :senha WHERE id = :id"; // Atualiza a senha usando o ID
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':senha', $novaSenha); // Liga o parâmetro senha
            $stmt->bindParam(':id', $id); // Liga o parâmetro ID
            if ($stmt->execute()) {
                echo "
                <META HTTP-EQUIV=REFRESH CONTENT='0;URL=http://localhost/ArenaRental/views/html/conta.php'>
                <script type=\"text/javascript\">
                    alert(\"Senha alterada com sucesso.\");
                </script>
                ";
            } else {
                echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=http://localhost/ArenaRental/views/html/senha.php'>
                <script type=\"text/javascript\">
                    alert(\"Erro ao alterar a senha.\");
                </script>";
            }
        } else {
            echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=http://localhost/ArenaRental/views/html/senha.php'>
            <script type=\"text/javascript\">
                alert(\"As senhas não coincidem\");
            </script>";
        }
    } else {
        echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=http://localhost/ArenaRental/views/html/senha.php'>
        <script type=\"text/javascript\">
            alert(\"A senha atual esta incorreta.\");
        </script>";
    }
} else {
    echo 'Método inválido.';
}
?>
