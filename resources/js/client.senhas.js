function validateForm() {
    var novaSenha = document.getElementById("nova_senha").value;
    var confirmaSenha = document.getElementById("confirma_senha").value;

    if (novaSenha.length < 8) {
      alert("A nova senha deve ter pelo menos 8 caracteres.");
      return false;
    }

    if (novaSenha !== confirmaSenha) {
      alert("As senhas não coincidem.");
      return false;
    }

    return true;
  }