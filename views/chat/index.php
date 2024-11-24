<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat | Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel='shorcut icon' href="../../resources/images/favicon.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
</head>

<body>
    <?php include '../layouts/header.php'; ?>
    <?php include '../layouts/verification.php'; ?>
    <style>
    <?php include '../../resources/css/chat.css';
    ?>
    </style>
    <?php
if (!isset($_SESSION['client']['id'])) {
    header('Location: /login.php');
    exit;
}

$destinatario_id = $_GET['destinatario'] ?? null;
?>

    <div class="chat-container">
        <div class="conversas-lista" id="conversas-lista">
            <!-- Será preenchido via JavaScript -->
        </div>
        <div class="chat-mensagens">
            <div class="mensagens-container" id="mensagens-container">
                <!-- Será preenchido via JavaScript -->
            </div>
            <div id="media-preview-container"></div>
            <form class="form-envio" id="form-mensagem">
                <input type="file" id="media-input" accept="image/*,video/*" multiple style="display: none">
                <button type="button" onclick="document.getElementById('media-input').click()">
                    <i class="fas fa-paperclip"></i>
                </button>
                <input type="text" id="mensagem-input" placeholder="Digite sua mensagem..." required>
                <button type="submit"><i class="fas fa-paper-plane"></i>Enviar</button>
            </form>
        </div>

        <div class="media-modal" id="media-modal" onclick="this.style.display='none'">
            <div class="media-content"></div>
        </div>

        <script>
        const usuarioId = <?php echo $_SESSION['client']['id']; ?>;
        let destinatarioAtualId = <?php echo $destinatario_id ? $destinatario_id : 'null'; ?>;
        </script>
        <script src="../../resources/js/chat.js"></script>
</body>

</html>