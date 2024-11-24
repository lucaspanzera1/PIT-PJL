<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Bem-vindo</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: linear-gradient(45deg, #f3f4f6, #ffffff);
        font-family: 'Arial', sans-serif;
    }

    body.dark-mode {
        background: #262626;
        color: white;
    }

    .loading-container {
        text-align: center;
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    body.dark-mode .loading-container {
        background: black;
        color: #fafafa;
    }

    .loading-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, transparent, #FFA500, transparent);
        animation: loading-line 2s linear infinite;
    }

    @keyframes loading-line {
        0% {
            left: -100%;
        }

        100% {
            left: 100%;
        }
    }

    .logo {
        width: 120px;
        height: 120px;
        margin-bottom: 30px;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0) scale(1);
        }

        50% {
            transform: translateY(-10px) scale(1.05);
        }
    }

    .welcome-text {
        color: #1f2937;
        font-size: 24px;
        margin-bottom: 15px;
        opacity: 0;
        animation: fadeIn 0.5s ease-out forwards;
    }

    body.dark-mode .welcome-text {
        color: #fafafa;
    }

    .loading-text {
        color: #6b7280;
        font-size: 16px;
        margin-top: 20px;
    }

    .loading-spinner {
        margin: 20px auto;
        width: 40px;
        height: 40px;
        position: relative;
    }

    .loading-spinner::before {
        content: '';
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 3px solid #e5e7eb;
        border-top-color: #FFA500;
        animation: spin 1s linear infinite;
        position: absolute;
        top: 0;
        left: 0;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .progress-bar {
        width: 200px;
        height: 4px;
        background: #e5e7eb;
        border-radius: 2px;
        margin: 20px auto;
        position: relative;
        overflow: hidden;
    }

    .progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 0;
        background: #FFA500;
        animation: progress 3s linear forwards;
    }

    @keyframes progress {
        to {
            width: 100%;
        }
    }
    </style>
</head>

<body>
    <?php
require_once '../../models/Owner.php';
require_once '../../models/Client.php';
require_once '../../models/User.php';

session_start(); // Iniciar sessão

// Verifique se há dados de cliente na sessão
if (isset($_SESSION['client'])) {
    // Crie uma instância da classe Client com os dados da sessão
    $client = new Client(
        $_SESSION['client']['id'],
        $_SESSION['client']['nome'],
        $_SESSION['client']['email'],
        $_SESSION['client']['tipo'],
        $_SESSION['client']['data_registro']
    );
} else {
    //echo "Bem-vindo!";
}
?>
    <div class="loading-container">
        <img src="../../resources/images/logo.png" alt="Logo" class="logo">
        <div class="welcome-text">
            Bem-vindo, <?php  $nomeCompleto = htmlspecialchars($client->getName());
                $primeiroNome = explode(' ', $nomeCompleto)[0];
                echo $primeiroNome; ?>!
        </div>
        <div class="loading-spinner"></div>
        <div class="progress-bar"></div>
        <div class="loading-text">Preparando seu ambiente...</div>
    </div>

    <script>
    // Array com mensagens de loading
    const loadingMessages = [
        "Preparando seu ambiente...",
        "Carregando seus dados...",
        "Quase lá...",
    ];

    // Função para atualizar a mensagem de loading
    let messageIndex = 0;
    const loadingText = document.querySelector('.loading-text');

    const updateLoadingMessage = () => {
        if (messageIndex < loadingMessages.length) {
            loadingText.style.opacity = 0;
            setTimeout(() => {
                loadingText.textContent = loadingMessages[messageIndex];
                loadingText.style.opacity = 1;
                messageIndex++;
            }, 300);
        }
    };

    // Atualiza a mensagem a cada 1 segundo
    setInterval(updateLoadingMessage, 1000);

    // Redireciona após 3 segundos
    setTimeout(function() {
        window.location.href = '../../index.php';
    }, 3000);
    </script>
    <script src="../../resources/js/dark.js"></script>
</body>

</html>