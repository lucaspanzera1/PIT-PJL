function iniciarChat(proprietarioId, quadraId) {
    // Armazena o ID da quadra na sessão para contexto
    localStorage.setItem('quadra_contexto', quadraId);

    // Redireciona para o chat
    window.location.href = '../chat/index.php?destinatario=' + proprietarioId;
}

