<?php
session_start();
require_once '../../models/Conexao.php';
require_once '../../models/Chat.php';

// Obter a conexão usando sua classe
$conn = Conexao::getInstance();
$chat = new Chat();

// Simula login como cliente
if (!isset($_SESSION['client']) && isset($_GET['login_as'])) {
    $stmt = $conn->prepare("SELECT * FROM cliente WHERE id = ?");
    $stmt->execute([$_GET['login_as']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($usuario) {
        $_SESSION['client'] = $usuario;
    }
}

// Logout
if (isset($_GET['logout'])) {
    unset($_SESSION['client']);
    header('Location: teste.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste do Chat</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .user-select { margin-bottom: 20px; }
        .chat-frame { width: 100%; height: 600px; border: 1px solid #ddd; }
        .user-card {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 5px 0;
            border-radius: 4px;
        }
        .user-card:hover {
            background-color: #f5f5f5;
        }
        .login-status {
            background-color: #e3f2fd;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .chat-list {
            display: grid;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-select">
            <h2>Teste do Sistema de Chat</h2>
            
            <?php if (!isset($_SESSION['client'])): ?>
                <h3>Selecione um usuário para teste:</h3>
                <div class="chat-list">
                <?php
                $stmt = $conn->query("SELECT id, nome, tipo FROM cliente");
                while ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                    <div class="user-card">
                        <a href="?login_as=<?php echo $usuario['id']; ?>">
                            Login como <?php echo $usuario['nome']; ?> (<?php echo $usuario['tipo']; ?>)
                        </a>
                    </div>
                <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="login-status">
                    <p>
                        Logado como: <strong><?php echo $_SESSION['client']['nome']; ?></strong>
                        (<a href="?logout=1">Sair</a>)
                    </p>
                </div>
                
                <h3>Iniciar conversa com:</h3>
                <div class="chat-list">
                <?php
                $stmt = $conn->prepare("
                    SELECT c.id, c.nome, c.tipo 
                    FROM cliente c 
                    WHERE c.id != ?
                ");
                $stmt->execute([$_SESSION['client']['id']]);
                while ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                    <div class="user-card">
                        <a href="index.php?destinatario=<?php echo $usuario['id']; ?>" target="chat-frame">
                            Conversar com <?php echo $usuario['nome']; ?> (<?php echo $usuario['tipo']; ?>)
                        </a>
                    </div>
                <?php endwhile; ?>
                </div>
                
                <iframe name="chat-frame" class="chat-frame"></iframe>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>