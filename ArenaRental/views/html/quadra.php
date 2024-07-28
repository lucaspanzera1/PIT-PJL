<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindo! | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/quadra.css?v=<?= time() ?>">
</head>
<body>

<?php
include_once("../../controllers/conexaoimg.php");
 require('../../controllers/conexao.php');
include '../../models/php/funcao.php';

$id_user = SalvaID(); // Chama a função SalvaID() e atribui o valor retornado à variável $id_user

if (isset($_SESSION['id'])) {
    $id_user = $_SESSION['id'];

    $quadra = buscarQuadra($pdo, $id_user);
}
?>




<header>
<a href="conta.php"><h2 id="imgH2"></h2></a>
<h1>ArenaRental©</h1>
<div id="FotoPerfil">
<div class="dropdown">
    <button class="mainmenubtn"><div id="ImgPerfil"><?php FotoPerfil1($conn); ?></div></button>
    <div class="dropdown-child"><button class="logoff-btn">Logoff</button></div>
    <div class="dropdown-child"><button id="toggle-theme">Alterar tema</button></div>
  </div></div>

</header>

<div id="QuadCinza"></div>

<section>
<h3><?php FotoQuadra($conn) ?></h3>
<h1><?php echo $quadra['nome_quadra']; ?></h1>
    <h2><?php echo $quadra['esporte']; ?></h2>
    <h3>R$<?php echo $quadra['valor']; ?>/por hora</h3>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../java/logoff.js"></script>
<script src="../java/dark.js"></script>
</body>
</html>