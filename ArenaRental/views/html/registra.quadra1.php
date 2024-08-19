<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindo! | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/registra.quadra1.css?v=<?= time() ?>">
</head>
<body>

<?php include '../../models/php/funcao.php'; ?>

<header>
<a href="../../index.php"><h2 id="imgH2"></h2></a>
<h1>ArenaRental©</h1>
<div id="FotoPerfil">
<div class="dropdown">
    <button class="mainmenubtn"><div id="ImgPerfil"><?php FotoPerfil() ?></div></button>
    <div class="dropdown-child"><button class="logoff-btn">Logoff</button></div>
    <div class="dropdown-child"><button id="toggle-theme">Alterar tema</button></div>
  </div></div>
</header>

<div id="QuadCinza"></div>

<section>
    <div>
    <h2>Etapa 1</h2>
    <h1> Descreva sua quadra</h1>

    <form action="../../models/php/insere_quadra.php" method="post">
    <input id="Desc" name="descricao" type="text" placeholder="Descrição"></br>
    <button type="submit" id="Continuar ">Continuar</button>
</form>

    </div>

    <div>
  </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../java/logoff.js"></script>
<script src="../java/dark.js"></script>
</body>
</html>