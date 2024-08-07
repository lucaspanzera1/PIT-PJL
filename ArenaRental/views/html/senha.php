<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar senha! | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/senha.css?v=<?= time() ?>">
</head>
<body>

<?php include '../../models/php/funcao.php'; ?>

<header>
<a href="conta.php"><h2 id="imgH2"></h2></a>
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
    <h1>Olá, <?php 
    $nome = SalvaNome();
    echo $nome;
    ;?>!</h1>
    <h2>Altere sua senha aqui!</h2>
</section>

<div id="QuadCinza2"></div>

<div id="SenhaS">
    <form id="senhaForm" action="../../models/php/alterar.senha.php" method="POST">
        <div>Senha atual:</div>
        <input type="password" name="senha_atual" required>
        <div>Nova senha:</div>
        <input type="password" name="nova_senha" required>
        <div>Confirmar nova senha:</div>
        <input type="password" name="confirma_senha" required>
        <br>
        <input type="submit" value="Alterar senha">
    </form>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../java/logoff.js"></script>
<script src="../java/dark.js"></script>
</body>
</html>