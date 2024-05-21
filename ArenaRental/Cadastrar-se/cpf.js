function formatarCPF() {
    var cpf = document.getElementById("data").value;
    cpf = cpf.replace(/\D/g, ""); // Remove tudo que não é dígito

    // Adiciona os pontos e o traço conforme digitação do usuário
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");

    document.getElementById("data").value = cpf;
}
