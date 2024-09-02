<?php

require_once '../models/Conexao.php';
require_once '../models/User.php';

// Verifica se uma ação foi solicitada (login ou registro)
$action = isset($_GET['action']) ? $_GET['action'] : '';

$user = new User();

// Verifica qual ação deve ser executada
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'login') {
        // Processar login
        $user->login($_POST);
        header("Location: ../index.php?cod=1");
        exit();
    } elseif ($action === 'register') {
        // Processar registro
        $user->register($_POST);
        header("Location: ../views/auth/login.php?success=1");
        exit();
    }
}

?>
