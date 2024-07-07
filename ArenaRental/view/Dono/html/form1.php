<?php include '../../../model/Dono/funcao.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindo! | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel='shorcut icon' href="../../../resources/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../view/Dono/css/form1.css?v=<?= time() ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<header>
    <h2><img src="../../../resources/LOGO1.png" width="100px"></h2>
    <h1></h1>
        <div class="dropdown">
            <button class="mainmenubtn"><div id="ImgPerfil"><?php FotoPerfil() ?></div></button>
            <div class="dropdown-child"><button class="logoff-btn">Logoff</button></div>
            
        </div>
</header>

<div id="QuadCinza"></div>

<section>
    <h1>Etapa 1</h1>
    <h2>Descreva sua quadra</h2>
    <input type="text" id="descricao"  placeholder="Descrição" name="descricao" required>
</section>

<script src="view/User/java/script.js"></script>
</body>
</html>