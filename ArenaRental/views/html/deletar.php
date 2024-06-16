<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desativar conta. | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/deletar.css?v=<?= time() ?>">
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
   <div> 
    <h1>Olá, <?php  $nome = SalvaNome(); echo $nome;?>!</h1>
    <h2>Lamentamos ver você partir!</h2>
    </div>

 
</section>

<div id="QuadCinza"></div>

<div id="TT">

    <div><h1>Desativar a conta?</h1>
    <h2>
        <?php 
        $email = SalvaEmail();
        echo $email; ?>
    </h2>
    <form id="deleteForm" action="../../models/php/delete.php" method="post">
    <input type="submit" value="Deletar conta" onclick="return confirm('Tem certeza que deseja deletar a conta?');">
    </form> </div>


    <div>
    <img src="../img/JogadorDelete.png" width="800px">
    </div>

</div>


</body>
</html>