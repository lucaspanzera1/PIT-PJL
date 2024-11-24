<?php
session_start();
require_once '../models/Conexao.php';
require_once '../models/Chat.php';

header('Content-Type: application/json');

if (!isset($_SESSION['client']['id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Não autorizado']);
    exit;
}

$chat = new Chat();
$total = $chat->getConversasNaoLidas($_SESSION['client']['id']);
echo json_encode(['total' => $total]);

?>