<?php
session_start(); // Inicia a sessão

// Destroi todas as variáveis de sessão
$_SESSION = array();

// Se desejar destruir a sessão completamente, descomente a linha abaixo
session_destroy();

// Redireciona o usuário para o index.php
header("Location: ../../index.php");
exit();
?>
