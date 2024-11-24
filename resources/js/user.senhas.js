function validateForm() {
    var username = document.getElementById("nomeuser").value;
    var senha = document.getElementById("senha").value;
    var confirmarSenha = document.getElementById("confirmarsenha").value;

    if (username.length < 3) {
        alert("O nome de usuário deve ter pelo menos 3 caracteres.");
        return false;
    }

    if (senha.length < 8) {
        alert("A senha deve ter pelo menos 8 caracteres.");
        return false;
    }

    if (senha !== confirmarSenha) {
        alert("As senhas não coincidem.");
        return false;
    }

    return true;
}