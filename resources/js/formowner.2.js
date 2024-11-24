document.getElementById('cep').addEventListener('input', function (event) {
    let cep = event.target.value;

    // Remove qualquer caractere que não seja dígito
    cep = cep.replace(/\D/g, '');

    // Adiciona o hífen no formato XXXXX-XXX
    if (cep.length > 5) {
        cep = cep.replace(/(\d{5})(\d)/, '$1-$2');
    }

    // Limita o tamanho para 9 caracteres (XXXXX-XXX)
    if (cep.length > 9) {
        cep = cep.substring(0, 9);
    }

    // Atualiza o valor do input
    event.target.value = cep;
});