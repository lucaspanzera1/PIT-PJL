<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindo! | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/tela1.css?v=<?= time() ?>">
</head>
<body>

<?php include '../../models/php/funcao.php'; ?>

<header>

<h2><img src="../img/LOGO1.png" width="100px"></h2>
<h1>ArenaRental©</h1>

<div class="dropdown">
    <button class="mainmenubtn"><?php FotoPerfil() ?></button>
    <div class="dropdown-child"><a href="profile.php">Perfil</a></div>
  </div>

</header>

<div id="QuadCinza"></div>




</body>
</html>