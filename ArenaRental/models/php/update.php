<?php
echo "Atualizando dados abaixo... <br>";
require('../../controllers/conexao.php');

include '../../models/php/funcao.php';

// Função para verificar se o email já está em uso
function verificarEmail($pdo, $email, $id) {
    $sql = "SELECT COUNT(*) AS total FROM cadastro WHERE email = :email AND id != :id"; // Verifica se o email já está em uso, excluindo o usuário atual
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] > 0; // Retorna true se o email já estiver em uso
}
// Função para verificar se o CPF já está em uso
function verifiqueCPF($pdo, $cpf, $id) {
    $sql = "SELECT COUNT(*) AS total FROM cadastro WHERE cpf = :cpf AND id != :id"; // Verifica se o CPF já está em uso, excluindo o usuário atual
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] > 0; // Retorna true se o CPF já estiver em uso
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_SESSION["id"]; // Obtém o ID do usuário da sessão
    $cpf = $_POST["cpf"]; // Captura o CPF do formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];

    validaCPF($cpf);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cpfInput = $_POST["cpf"];
        $cpfInput = preg_replace('/\D/', '', $cpfInput); // Remove todos os caracteres não numéricos
    
        if (validaCPF($cpfInput)) {
        } else {
            echo "
            <script type=\"text/javascript\">
                alert(\"CPF inválido.\");
                window.location.href = 'http://localhost/ArenaRental/views/html/profile.php';
            </script>
        ";
        exit();
        }
    }
}

    // Função para Atualizar o registro no banco de dados
    function atualizarRegistro($pdo, $id, $cpf, $nome, $email) {
        $sql = "UPDATE cadastro SET cpf = :cpf, nome = :nome, email = :email WHERE id = :id"; // Atualiza usando o ID
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cpf', $cpf); // Liga o parâmetro CPF
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id); // Liga o parâmetro ID
        return $stmt->execute();
    }

    if (!empty($id) && !empty($cpf) && !empty($nome) && !empty($email)) {
        if (!verificarEmail($pdo, $email, $id)) { // Verifica se o email não está em uso
            if (!verifiqueCPF($pdo, $cpf, $id)) { // Verifica se o CPF não está em uso
                if (atualizarRegistro($pdo, $id, $cpf, $nome, $email)) {
                    // Atualize os dados da sessão
                    $_SESSION['nome'] = $nome;
                    $_SESSION['cpf'] = $cpf;
                    echo "
                    <META HTTP-EQUIV=REFRESH CONTENT='0;URL=http://localhost/ArenaRental/views/html/conta.php'>
                    <script type=\"text/javascript\">
                        alert(\"Informações alteradas com sucesso.\");
                    </script>
                    ";  
                    exit();
                } else {
                    echo 'Erro ao atualizar o registro.';
                }
            } else {
                echo "
                <script type=\"text/javascript\">
                    alert(\"O CPF já está em uso.\");
                    window.location.href = 'http://localhost/ArenaRental/views/html/profile.php';
                </script>
                ";
                exit();
            }
        } else {
            echo "
            <script type=\"text/javascript\">
                alert(\"O email já está em uso.\");
                window.location.href = 'http://localhost/ArenaRental/views/html/profile.php';
            </script>
            ";
            exit();
        }
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Todos os campos são obrigatórios.\");
            window.location.href = 'http://localhost/ArenaRental/views/html/profile.php';
        </script>
        ";
        exit();
    }
    

if(isset($_SESSION['nome'])) {
    $nome = $_SESSION['nome'];
} else {
    $nome = "usuário";
}
?>
