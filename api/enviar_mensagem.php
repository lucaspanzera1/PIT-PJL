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
    $remetente_id = $_SESSION['client']['id'];
    $destinatario_id = $_POST['destinatario_id'];
    $mensagem = $_POST['mensagem'];
    
    // Processar múltiplos arquivos
    if (isset($_FILES['arquivos'])) {
        foreach ($_FILES['arquivos']['tmp_name'] as $key => $tmp_name) {
            $arquivo = [
                'name' => $_FILES['arquivos']['name'][$key],
                'type' => $_FILES['arquivos']['type'][$key],
                'tmp_name' => $tmp_name,
                'error' => $_FILES['arquivos']['error'][$key],
                'size' => $_FILES['arquivos']['size'][$key]
            ];
            
            $chat->enviarMensagem($remetente_id, $destinatario_id, $mensagem, null, $arquivo);
        }
        
        echo json_encode(['success' => true]);
    } else {
        // Enviar apenas mensagem de texto
        $resultado = $chat->enviarMensagem($remetente_id, $destinatario_id, $mensagem);
        echo json_encode(['success' => $resultado]);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

?>