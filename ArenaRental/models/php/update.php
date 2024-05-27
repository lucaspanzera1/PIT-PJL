<?php
echo "Atualizando dados abaixo... <br>";
require('../../controllers/conexao.php');

session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST["cpf"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    echo "<hr>";
 
    // Função para Atualizar o registro no banco de dados
    function atualizarRegistro($pdo, $cpf, $nome, $email, $senha) {
        $sql = "UPDATE cadastro SET nome = :nome, email = :email, senha = :senha WHERE cpf = :cpf";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':cpf', $cpf);
        return $stmt->execute();
    }

    // Verifica se os campos obrigatórios não estão vazios
    if (!empty($cpf) && !empty($nome) && !empty($email) && !empty($senha)) {
        if (atualizarRegistro($pdo, $cpf, $nome, $email, $senha)) {
             echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/ArenaRental/views/html/tela1.php'>
            <script type=\"text/javascript\">
                alert(\"Informações alteradas com sucesso.\");
            </script>
        ";	
        header("refresh: 1; url=../land/page1.php");
        exit();
        } else {
            echo 'Erro ao atualizar o registro.';
        }
    } else {
        echo 'Todos os campos são obrigatórios.';
    }
}

if(isset($_SESSION['nome'])) {
    $nome = $_SESSION['nome'];
} else {
    $nome = "usuário";
}

if(isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
} 
else{
    $id_usuario = "";
}
?>
