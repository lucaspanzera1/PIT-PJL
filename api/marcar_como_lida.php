<?php
session_start();
require_once '../models/Conexao.php';
require_once '../models/Chat.php';

header('Content-Type: application/json');

if (!isset($_SESSION['client']['id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit;
}

try {
    $chat = new Chat();
    $remetente_id = $_POST['destinatario_id']; // ID de quem enviou as mensagens
    $destinatario_id = $_SESSION['client']['id']; // ID do usuário atual (quem está recebendo)
    
    $resultado = $chat->marcarComoLida($remetente_id, $destinatario_id);
    echo json_encode(['success' => $resultado]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>