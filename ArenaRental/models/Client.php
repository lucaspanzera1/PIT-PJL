<?php
require_once 'User.php';
require_once 'Conexao.php';

class Client extends User
{
    private $id;
    private $name;
    private $email;
    private $type;
    private $registrationDate;

    public function __construct($id, $name, $email, $type, $registrationDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->type = $type;
        $this->registrationDate = $registrationDate;
    }

    public static function fromUserData($userData)
    {
        return new self(
            $userData['id'],
            $userData['nome'],
            $userData['email'],
            $userData['tipo'],
            $userData['data_registro']
        );
    }

    public function saveToSession()
    {
        $_SESSION['client'] = [
            'id' => $this->id,
            'nome' => $this->name,
            'email' => $this->email,
            'tipo' => $this->type,
            'data_registro' => $this->registrationDate
        ];
    }
    // Função para obter a primeira palavra do nome
    public function getFirstName()
    {
        // Divide o nome em palavras e retorna a primeira
        return explode(' ', $this->name)[0];
    }

    public function getProfilePicture()
    {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT nome_imagem FROM imagem WHERE id_user = :id_user");
        $stmt->bindParam(':id_user', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $nome_imagem = $result['nome_imagem'];
            echo "<img src='../../upload/user_pfp/$nome_imagem' alt='Imagem de perfil'>";
            return $nome_imagem;
        } else {
            echo "<img src='../../upload/user_pfp/userpfp.png' alt='Imagem Padrão'>";
            return null;
        }
    }

    public function logoff()
    {
        session_unset();
        session_destroy();
        echo "Redirecionando...";
        header("refresh: 1.5; url=../../index.php");
        exit();
    }

    public function deleteAccount()
    {
        $pdo = Conexao::getInstance();

        try {
            $pdo->beginTransaction();

            // Deleta as imagens associadas ao usuário
            $sql_imagens = "DELETE FROM imagem WHERE id_user = :id_user";
            $stmt_imagens = $pdo->prepare($sql_imagens);
            $stmt_imagens->bindParam(':id_user', $this->id, PDO::PARAM_INT);
            $stmt_imagens->execute();

            // Deleta a conta do usuário
            $sql = "DELETE FROM cadastro WHERE id = :id_user";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_user', $this->id, PDO::PARAM_INT);
            $stmt->execute();

            $pdo->commit();

            // Removendo informações da sessão
            $this->logoff();

            echo "
                <script type=\"text/javascript\">
                    alert(\"Conta deletada com sucesso!\");
                </script>
            ";

            header("refresh: 1; url=../../views/html/index.php");
            exit();

        } catch (Exception $e) {
            $pdo->rollBack();
            echo "
                <script type=\"text/javascript\">
                    alert(\"Erro ao deletar conta.\");
                </script>
            ";
        }
    }

    public function uploadFotoPerfil()
    {
        // Configurações de upload
        $_UP['pasta'] = '../upload/user_pfp/';
        $_UP['tamanho'] = 1024 * 1024 * 100; // 100MB
        $_UP['extensoes'] = array('png', 'jpg', 'jpeg', 'gif');

        // Verifica se houve algum erro no upload
        if ($_FILES['arquivo']['error'] != 0) {
            die("Não foi possível fazer o upload, erro: " . $_FILES['arquivo']['error']);
        }

        // Verifica o tamanho do arquivo
        if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
            echo "
                <script type=\"text/javascript\">
                    alert(\"Arquivo muito grande.\");
                    window.location.href = '../../views/html/tela1.php';
                </script>
            ";
            return;
        }

        // Verifica a extensão do arquivo
        $extensao = strtolower(pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION));
        if (!in_array($extensao, $_UP['extensoes'])) {
            echo "
                <script type=\"text/javascript\">
                    alert(\"Extensão não permitida.\");
                    window.location.href = '../../views/html/tela1.php';
                </script>
            ";
            return;
        }

        // Define o nome do arquivo
        $nome_final = $_FILES['arquivo']['name'];

        // Tenta mover o arquivo para a pasta de upload
        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
            $pdo = Conexao::getInstance();
            $stmt_delete = $pdo->prepare("DELETE FROM imagem WHERE id_user = :id_user");
            $stmt_delete->bindParam(':id_user', $this->id, PDO::PARAM_INT);
            $stmt_delete->execute();

            $stmt = $pdo->prepare("INSERT INTO imagem (nome_imagem, id_user) VALUES (:nome_imagem, :id_user)");
            $stmt->bindParam(':nome_imagem', $nome_final);
            $stmt->bindParam(':id_user', $this->id, PDO::PARAM_INT);
            $stmt->execute();
            
            echo "<script type=\"text/javascript\">
            alert(\"Imagem cadastrada!\");
                </script>";
            header("refresh: 0.4; url=../index.php");
            exit();
        } else {
            echo "
                <script type=\"text/javascript\">
                    alert(\"Não foi possível cadastrar a imagem.\");
                    window.location.href = '../../views/html/tela1.php';
                </script>
            ";
        }
    }

    public function updateClient($name, $email)
{
    $pdo = Conexao::getInstance();

    // Verifica se o email já está em uso por outro usuário
    if ($this->isEmailInUse($pdo, $email, $this->id)) {
        echo "<script>alert('O email já está em uso.'); window.location.href = '../../views/html/profile.php';</script>";
        exit();
    }

    // Atualiza os dados do cliente
    $sql = "UPDATE cadastro SET nome = :nome, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $this->id);

    if ($stmt->execute()) {
        // Atualiza os dados da instância do cliente
        $this->name = $name;
        $this->email = $email;

        // Atualiza os dados da sessão
        $this->saveToSession(); // Chama a função que salva as informações atualizadas na sessão

        echo "<script type=\"text/javascript\">
            alert(\"Informações alteradas com sucesso!\");
            </script>";
        header("refresh: 0.4; url=../index.php");
        exit();
    } else {
        echo "<script type=\"text/javascript\">
            alert(\"Erro ao alterar!\");
            </script>";
        header("refresh: 0.4; url=../index.php");
        exit();
    }
}
    // Função para verificar se o email está em uso por outro usuário
    public function isEmailInUse($pdo, $email, $id)
    {
        $sql = "SELECT COUNT(*) AS total FROM cadastro WHERE email = :email AND id != :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }
}
?>

