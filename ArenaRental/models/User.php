<?php
require_once 'Client.php';

class User
{
    // Função para login
    public function login($data)
    {
        $pdo = Conexao::getInstance();
        $sql = "SELECT id, nome, email, tipo, data_registro FROM cadastro WHERE cpf = :cpf AND senha = :senha";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(":cpf", $data['cpf'], PDO::PARAM_STR);
        $statement->bindValue(":senha", $data['password'], PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            session_start();
            session_regenerate_id(true);

            $client = Client::fromUserData($user);
            $client->saveToSession();

            echo "<script type=\"text/javascript\">
            alert(\"Login bem-sucedido, " . htmlspecialchars($user['nome']) . "!\");
                </script>";
            header("refresh: 0.4; url=../index.php");
            exit();
        } else {
            echo "<script type=\"text/javascript\">
            alert(\"Usuário ou senha incorretos!\");
                </script>";
            header("refresh: 0.4; url=../views/auth/login.php");
            exit();
        }
    }

    // Função para validação de CPF
    private function validaCPF($cpf)
    {
        // Limpa caracteres especiais do CPF
        $cpf = preg_replace('/\D/', '', $cpf);

        // Verifica se o CPF tem 11 dígitos ou é uma sequência repetida
        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Cálculo para validar os dígitos verificadores do CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    // Função para verificar se o usuário já existe no banco de dados
    private function usuarioExiste($pdo, $campo, $valor)
    {
        $sql = "SELECT COUNT(*) AS total FROM cadastro WHERE $campo = :valor";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }

    // Função para registro de novo usuário
    public function register($data)
{
    $pdo = Conexao::getInstance();

    // Validação do CPF
    $cpf = preg_replace('/\D/', '', $data['cpf']);
    if (!$this->validaCPF($cpf)) {
        echo "<script type=\"text/javascript\">
            alert(\"CPF inválido.\");
            window.location.href = '../views/auth/registrar.php';
            </script>";
        exit();
    }

    $cpfFormatado = vsprintf('%s.%s.%s-%s', str_split($cpf, 3));
    // Verifica se o CPF já está cadastrado
    if ($this->usuarioExiste($pdo, 'cpf', $cpf)) {
        echo "<script type=\"text/javascript\">
            alert(\"CPF já cadastrado.\");
            window.location.href = '../views/auth/registrar.php';
            </script>";
        exit();
    }

    // Verifica se o email já está cadastrado
    if ($this->usuarioExiste($pdo, 'email', $data['email'])) {
        echo "<script type=\"text/javascript\">
            alert(\"Email já cadastrado.\");
            window.location.href = '../views/auth/registrar.php';
            </script>";
        exit();
    }
    
    // Captura o tipo do usuário a partir do formulário
    $tipo = isset($data['tipo']) ? $data['tipo'] : 'cliente';
    $cpfFormatado = vsprintf('%s.%s.%s-%s', str_split($cpf, 3));

    // Inserção dos dados do usuário no banco de dados
    $sql = "INSERT INTO cadastro (cpf, nome, email, senha, tipo, data_registro) 
            VALUES (:cpf, :nome, :email, :senha, :tipo, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":cpf", $cpfFormatado, PDO::PARAM_STR);
    $stmt->bindValue(":nome", $data['nome'], PDO::PARAM_STR);
    $stmt->bindValue(":email", $data['email'], PDO::PARAM_STR);
    $stmt->bindValue(":senha", $data['senha'], PDO::PARAM_STR);
    $stmt->bindValue(":tipo", $tipo, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Pega os dados do usuário recém-registrado
        $userId = $pdo->lastInsertId();
        $sqlUser = "SELECT id, nome, email, tipo, data_registro FROM cadastro WHERE id = :id";
        $stmtUser = $pdo->prepare($sqlUser);
        $stmtUser->bindValue(":id", $userId, PDO::PARAM_INT);
        $stmtUser->execute();
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            session_start();
            session_regenerate_id(true);

            $client = Client::fromUserData($user);
            $client->saveToSession();

            echo "<script type=\"text/javascript\">
            alert(\"Registro bem-sucedido, " . htmlspecialchars($user['nome']) . "!\");
                </script>";
            header("refresh: 0.4; url=../views/client/foto_perfil.php");
            exit();
        }
    } else {
        echo "<script type=\"text/javascript\">
        alert(\"Erro ao registrar. Tente novamente.\");
            </script>";
        header("refresh: 0.4; url=../views/auth/registrar.php");
        exit();
    }
}

}
?>