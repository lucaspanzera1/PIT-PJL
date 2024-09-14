<?php
require_once 'Client.php';
require_once 'Conexao.php';

class Owner extends Client
{
    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::getInstance();
    }

    public function getQuadraInfo($userId)
{
    $sql = "SELECT id, nome_quadra, esporte, localizacao, descricao, valor, id_user, nome_dono, horario_abre, horario_fecha 
            FROM quadra 
            WHERE id_user = :userId";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getQuadraFoto()
{
    $pdo = Conexao::getInstance();
    $stmt = $pdo->prepare("SELECT imagem_quadra FROM imagem WHERE id_dono = :id_user");
    $stmt->bindParam(':id_user', $this->id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $nome_imagem = $result['nome_imagem'];
        echo "<img src='../../upload/quadra_img/$nome_imagem' alt='Imagem de perfil'>";
        return $nome_imagem;
    } else {
        echo "<img src='../../upload/user_pfp/userpfp.png' alt='Imagem Padrão'>";
        return null;
    }
}

    public function inserirEtapa1($descricao, $id_user, $nome_dono)
    {
        $sql = "INSERT INTO quadra (descricao, id_user, nome_dono) VALUES (:descricao, :id_user, :nome_dono)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':nome_dono', $nome_dono, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public function atualizarQuadra($titulo, $esporte, $localizacao, $descricao, $valor, $id_user, $nome_dono)
    {
        // Verifica se já existe um registro para o usuário atual
        $sql_check = "SELECT id, descricao FROM quadra WHERE id_user = :id_user AND nome_dono = :nome_dono";
        $stmt_check = $this->conn->prepare($sql_check);
        $stmt_check->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt_check->bindParam(':nome_dono', $nome_dono, PDO::PARAM_STR);
        $stmt_check->execute();
        $quadra = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($quadra) {
            // Se já existe uma quadra para este usuário, atualiza o registro
            if (empty($descricao)) {
                $descricao = $quadra['descricao'];
            }

            $sql_update = "UPDATE quadra 
                           SET nome_quadra = :titulo, esporte = :esporte, localizacao = :localizacao, descricao = :descricao, valor = :valor 
                           WHERE id_user = :id_user AND nome_dono = :nome_dono";
            $stmt_update = $this->conn->prepare($sql_update);
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
            $stmt_insert = $this->conn->prepare($sql_insert);
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

    public function uploadFotoQuadra()
    {
        // Configurações de upload
        $_UP['pasta'] = '../upload/quadra_img/';
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
                    window.location.href = '../views/owner/form.quadra2.php';
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
                    window.location.href = '../views/owner/form.quadra2.php';
                </script>
            ";
            return;
        }

        // Define o nome do arquivo
        $nome_final = $_FILES['arquivo']['name'];

        // Tenta mover o arquivo para a pasta de upload
        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
            $stmt_delete = $this->conn->prepare("DELETE FROM imagem_quadra WHERE id_dono = :id_user");
            $stmt_delete->bindParam(':id_user', $_SESSION['client']['id'], PDO::PARAM_INT);
            $stmt_delete->execute();

            $stmt = $this->conn->prepare("INSERT INTO imagem_quadra (nome_imagem, id_dono) VALUES (:nome_imagem, :id_user)");
            $stmt->bindParam(':nome_imagem', $nome_final);
            $stmt->bindParam(':id_user', $_SESSION['client']['id'], PDO::PARAM_INT);
            $stmt->execute();

            // Redireciona para a próxima etapa após o upload bem-sucedido
            echo "
                <script type=\"text/javascript\">
                    alert(\"Imagem cadastrada com sucesso!\");
                    window.location.href = '../views/owner/form.quadra3.php';
                </script>
            ";
            exit();
        } else {
            echo "
                <script type=\"text/javascript\">
                    alert(\"Não foi possível cadastrar a imagem.\");
                    window.location.href = '../views/owner/form.quadra2.php';
                </script>
            ";
        }
    }
    
}
?>
