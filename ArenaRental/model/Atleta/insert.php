<?php
require('../../controller/conexao.php');

include '../../model/User/funcao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST["cpf"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    validaCPF($cpf);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cpfInput = $_POST["cpf"];
        $cpfInput = preg_replace('/\D/', '', $cpfInput); // Remove todos os caracteres não numéricos
    
        if (validaCPF($cpfInput)) {
        } else {
            echo "
            <script type=\"text/javascript\">
                alert(\"CPF inválido.\");
                window.location.href = 'http://localhost/ArenaRental/views/html/registrar.atleta.php';
            </script>
        ";
        exit();
        }
    }
    
    function usuarioExiste($pdo, $campo, $valor) {
        $sql = "SELECT COUNT(*) AS total FROM cadastro WHERE $campo = :valor";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }

    if (usuarioExiste($pdo, 'cpf', $cpf)) {
        echo "
            <script type=\"text/javascript\">
                alert(\"CPF já cadastrado.\");
                window.location.href = 'http://localhost/ArenaRental/view/Atleta/html/registrar.php';
            </script>
        ";
        exit();
    }

    if (usuarioExiste($pdo, 'email', $email)) {
        echo "
            <script type=\"text/javascript\">
                alert(\"Email já cadastrado.\");
               window.location.href = 'http://localhost/ArenaRental/view/Atleta/html/registrar.php';
            </script>
        ";
        exit();
    }

    function inserirRegistro($pdo, $cpf, $nome, $email, $senha, $tipo = "Atleta") {
        $data_registro = date('Y-m-d H:i:s'); // Obtém apenas a data atual
        $sql = "INSERT INTO cadastro (cpf, nome, email, senha, tipo, data_registro) VALUES (:cpf, :nome, :email, :senha, :tipo, :data_registro)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        $stmt->bindParam(':data_registro', $data_registro, PDO::PARAM_STR);
        return $stmt->execute();
    }
    

    if (inserirRegistro($pdo, $cpf, $nome, $email, $senha)) {
        // Obtendo o ID gerado
        $id = $pdo->lastInsertId();
        // Salvando o ID na sessão
        $_SESSION['id'] = $id;
        $_SESSION['nome'] = $nome;
        $_SESSION['email'] = $email;
        

        // Obtendo data_registro e tipo do usuário
        $sql = "SELECT tipo, data_registro FROM cadastro WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Salvando data_registro e tipo na sessão
        $_SESSION['tipo'] = $user['tipo'];
        $_SESSION['data_registro'] = $user['data_registro'];

        echo "
            <script type=\"text/javascript\">
                alert(\"Registrado com sucesso!.\");
                window.location.href = 'http://localhost/ArenaRental/view/Atleta/html/inserir.foto.php';
            </script>
        ";
        exit();
    } else {
        echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao registrar.\");
                 window.location.href = 'http://localhost/ArenaRental/view/Atleta/html/registrar.php';
            </script>
        ";
        exit();
    }
}
?>
