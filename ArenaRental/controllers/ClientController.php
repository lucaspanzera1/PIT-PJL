<?php
include '../models/Conexao.php';
include '../models/Client.php';

session_start();

// Verifica se uma ação foi solicitada (ex: delete, FotoPerfil, update)
$action = isset($_GET['action']) ? $_GET['action'] : '';

$client = null;

// Verifica se o cliente está logado, ou seja, se a sessão possui um cliente
if (isset($_SESSION['client'])) {
    // Recupera os dados do cliente armazenados na sessão
    $clientData = $_SESSION['client'];
    // Cria uma instância de Client a partir dos dados da sessão
    $client = Client::fromUserData($clientData);
}

// Verifica se o método da requisição é POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($action === 'delete' && $client) {
        // Chama o método para deletar a conta
        $client->deleteAccount();
        header("Location: ../index.php?cod=1"); // Redireciona após deletar a conta
        exit();
    } elseif ($action === 'FotoPerfil' && $client) {
        // Chama o método para fazer upload da foto de perfil
        $client->uploadFotoPerfil();
        header("Location: ../index.php?cod=1"); // Redireciona após o upload da foto
        exit();
    } elseif ($action === 'update' && $client) {
        $name = $_POST['nome'];
        $email = $_POST['email'];

        $client->updateClient($name, $email);
        header("Location: ../index.php?cod=1");
    } else {
        // Se o cliente não estiver logado ou a ação for desconhecida, redireciona com erro
        header("Location: ../views/html/index.php?error=not_logged_in_or_invalid_action");
        exit();
    }
}
?>



