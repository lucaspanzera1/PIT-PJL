<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindo! | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel='shorcut icon' href="../../resources/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../resources/css/foto_perfil.css?v=<?= time() ?>">
</head>

<body>
    <?php include '../layouts/header.php'; ?>
    <?php include '../layouts/verification.php'; ?>

    <section>
        <div id="Quad">
            <h1>Quase lá!</h1>
            <div id="QuadCinza2"></div>
            <nav>
                <h2>Bem-vindo a ArenaRental!</h2>
                <h2>Primeiro, adicione uma foto no seu perfil!</h2>
            </nav>
            <form method="POST" action="../../controllers/ClientController.php?action=FotoPerfil"
                enctype="multipart/form-data">

                <label class="picture" for="picture__input" tabIndex="0">
                    <span class="picture__image"></span>
                </label>
                <input name="arquivo" type="file" name="picture__input" id="picture__input">
                <input type="submit" id="Continuar" value="Enviar">
        </div>
        </form>
        <?php include '../layouts/mensagem.php'; ?>
    </section>
    <script src="../../resources/js/foto_perfil.js"></script>
    </form>

</body>

</html>