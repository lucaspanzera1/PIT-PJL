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

<h2><a href="conta.php"><img src="../img/LOGO1.png" width="100px"></a></h2>
<h1>ArenaRental©</h1>

<div id="FotoPerfil"><?php FotoPerfil() ?></div>

</header>

<div id="QuadCinza"></div>

<section>
    <h1>Olá, <?php 
    $nome = SalvaNome();
    echo $nome;
    ;?>!</h1>
    <h2>Altere sua senha aqui!</h2>
</section>

<div id="QuadCinza"></div>

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



</body>
</html>