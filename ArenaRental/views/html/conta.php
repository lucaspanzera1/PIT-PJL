<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conta! | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/conta.css?v=<?= time() ?>">
</head>
<body>

<?php 
 require('../../controllers/conexao.php');
 include '../../models/php/funcao.php';

 $id = SalvaID(); // Chama a função SalvaID() e atribui o valor retornado à variável $id
            
 if (isset($_SESSION['id'])) {
     $id = $_SESSION['id'];

     $registro = buscarRegistro($pdo, $id);
 }
?>

<header>

<h2><a href="tela1.php"><img src="../img/LOGO1.png" width="100px"></a></h2>
<h1>ArenaRental©</h1>

<div id="FotoPerfil">
<div class="dropdown">
    <button class="mainmenubtn"><?php FotoPerfil() ?></button>
    <div class="dropdown-child"><button class="logoff-btn">Logoff</button></div>
  </div></div>

</header>

<div id="QuadCinza"></div>

<?php 
$nome = SalvaNome();
?>

<div id="TT">
    <h1>Conta</h1>
    <h2><a><?php echo $nome; ?>,</a> <?php echo $registro['email']; ?></h2>
</div>

<section id="Quadrados">
<div>
  <a href="perfil.php">
    <img src="../img/Vetor(1).png" alt="">
    <h5>Acessar perfil</h5>
    <h6>Seu perfil.</h6>
  </a>
</div>
<div>
<a href="profile.php">
    <img src="../img/Vetor(2).png" alt="">
    <h5>Informações pessoais</h5>
    <h6>Detalhes e informações pessoais.</h6>
</a>
</div>
<div>
    <a href="senha.php">
    <img src="../img/Vetor(3).png" alt="">
    <h5>Alterar senha</h5>
    <h6>Altere sua senha.</h6>
    </a>
</div>
<div>
    <a href="deletar.php">
    <img src="../img/Vetor(4).png" alt="">
    <h5>Desativar conta</h5>
    <h6>Excluir conta.</h6>
    </a>
</div>
</section>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../java/logoff.js"></script>
</body>
</html>