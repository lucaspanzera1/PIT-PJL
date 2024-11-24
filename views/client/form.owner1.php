<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre sua quadra! | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel='shorcut icon' href="../../resources/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../resources/css/form.owner1.css?v=<?= time() ?>">
</head>

<body>
    <?php include '../layouts/header.php'; ?>
    <?php include '../layouts/verification.php'; ?>

    <section>
        <h2>Etapa 1</h2>
        <h1>Fale um pouco sobre seu espaço.</h1>
        <form action="../../controllers/ClientController.php?action=registerOwner" method="POST" id="registerForm">
            <input type="text" id="nome" name="nome" placeholder="Nome do Espaço" required>
            <div id="inputform">
                <input type="text" id="loc" name="loc" placeholder="Localização" required>
                <input type="text" id="cep" name="cep" placeholder="CEP" required maxlength="9">
            </div>
            <input type="text" id="Desc" name="Desc" placeholder="Descrição" required>
            <input type="hidden" id="bairro" name="bairro">
            <input type="hidden" id="regiao" name="regiao">
            <div id="cepError" style="color: red; display: none;">CEP inválido ou fora da região metropolitana de Belo
                Horizonte.</div>
            <button type="submit">Registrar</button>
        </form>
    </section>

    <script src="../../resources/js/formowner.cep.js"></script>
</body>

</html>