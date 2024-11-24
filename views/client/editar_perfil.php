<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações pessoais | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel='shorcut icon' href="../../resources/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../resources/css/editar_perfil.css?v=<?= time() ?>">
</head>

<body>

    <?php include '../layouts/header.php'; ?>
    <?php include '../layouts/verification.php'; ?>

    <section>
        <?php include '../layouts/mensagem.php'; ?>
        <h1>Olá, <?php  $nomeCompleto = htmlspecialchars($client->getName());
                $primeiroNome = explode(' ', $nomeCompleto)[0];
                echo $primeiroNome; ?>!</h1>
        <h2>Edite seu perfil aqui.</h2>
        <div id="QuadCinza2"></div>

        <nav>
            <div id="ImgPerfil1">
                <form method="POST" action="../../controllers/ClientController.php?action=FotoPerfil"
                    enctype="multipart/form-data" id="flex-pfp">
                    <input type="hidden" name="origem" value="editar_perfil">
                    <input type="hidden" name="redirect_to" value="alterar">
                    <label class="picture" for="picture__input" tabIndex="0">
                        <span class="picture__image"></span>
                    </label>

                    <input name="arquivo" type="file" name="picture__input" id="picture__input">

                    <button id="Continuar" type="submit">Atualizar foto</button>

                    <script>
                    // Passando a string PHP como valor JavaScript
                    var nomeImagem = "<?php echo htmlspecialchars($client->getProfilePicture()); ?>";
                    </script>
                    <script src="../../resources/js/perfil.img.js"></script>

            </div>
            </form>

            <div class="form-container">
                <form action="../../controllers/clientcontroller.php?action=update" method="POST">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" required
                            value="<?php echo isset($_SESSION['client']['nome']) ? $_SESSION['client']['nome'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required
                            value="<?php echo isset($_SESSION['client']['email']) ? $_SESSION['client']['email'] : ''; ?>">
                    </div>

                    <div class="form-group">
                        <button id="Continuar" type="submit">Atualizar</button>
                    </div>
                </form>
            </div>
        </nav>
    </section>
</body>

</html>