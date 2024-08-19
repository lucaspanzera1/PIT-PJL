<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindo! | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/registra.quadra3.css?v=<?= time() ?>">
</head>
<body>

<?php include '../../models/php/funcao.php'; ?>

<header>
    <a href="../../index.php"><h2 id="imgH2"></h2></a>
    <h1>ArenaRental©</h1>
    <div id="FotoPerfil">
        <div class="dropdown">
            <button class="mainmenubtn"><div id="ImgPerfil"><?php FotoPerfil(); ?></div></button>
            <div class="dropdown-child"><button class="logoff-btn">Logoff</button></div>
            <div class="dropdown-child"><button id="toggle-theme">Alterar tema</button></div>
        </div>
    </div>
</header>

<div id="QuadCinza"></div>

<!-- O formulário deve ter o método POST para segurança -->
<form action="../../models/php/insere_quadra2.php" method="POST">
    <section>
        <h1>Agora, dê um título e informe a localização da sua quadra.</h1>
        <input id="Titulo" name="Titulo" type="text" placeholder="Título" required>
        
        <select id="esporte" name="esporte" required>
            <option value="" disabled selected>Esporte</option>
            <option value="futebol">Futebol</option>
            <option value="basquete">Basquete</option>
            <option value="vôlei">Vôlei</option>
            <option value="natação">Natação</option>
            <option value="corrida">Corrida</option>
        </select>

        <input id="Localizacao" name="Localizacao" type="text" placeholder="Localização" required>

        <h1>Determine o preço por hora.</h1>
        <h2>Você pode alterar mais tarde.</h2>
        <div id="RS">
            <h1>R$ </h1>
            <input id="Valor" name="Valor" type="number" value="99" min="0" step="0.01" required>
        </div> 
        <h3 id="PrecoCliente">Preço para o cliente: R$109</h3>

        <button type="submit" id="Continuar">Continuar</button>
    </section>
</form>

<script>
    // Função para calcular e atualizar o preço
    function atualizarPreco() {
        // Obtém o valor do input
        const valorInput = parseFloat(document.getElementById('Valor').value);
        
        // Verifica se o valor é um número válido
        if (!isNaN(valorInput)) {
            // Calcula 103% do valor
            const precoCliente = valorInput * 1.03;
            
            // Atualiza o conteúdo do h3 com o novo valor
            document.getElementById('PrecoCliente').innerText = `Preço para o cliente: R$${precoCliente.toFixed(2)}`;
        }
    }

    // Adiciona um listener para atualizar o preço sempre que o valor do input mudar
    document.getElementById('Valor').addEventListener('input', atualizarPreco);

    // Chama a função uma vez ao carregar a página para definir o preço inicial
    atualizarPreco();
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../java/logoff.js"></script>
<script src="../java/dark.js"></script>
</body>
</html>
