<?php
session_start();
require_once '../models/Conexao.php';
require_once '../models/Chat.php';

header('Content-Type: application/json');

if (!isset($_SESSION['client']['id'])) {
    echo json_encode(['error' => 'Usuário não autenticado']);
    exit;
}

try {
    $chat = new Chat();
    $remetente_id = $_SESSION['client']['id'];
    $destinatario_id = $_GET['destinatario_id'] ?? null;

    if (!$destinatario_id) {
        echo json_encode(['error' => 'Destinatário não especificado']);
        exit;
    }

    $mensagens = $chat->getMensagens($remetente_id, $destinatario_id);
    
    // Formatar as mensagens para incluir URLs completas para arquivos
    foreach ($mensagens as &$mensagem) {
        if ($mensagem['tipo_midia'] !== 'texto' && $mensagem['arquivo']) {
            $mensagem['arquivo_url'] = '../upload/chat/' . $mensagem['arquivo'];
        }
    }

    echo json_encode($mensagens);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}


?>