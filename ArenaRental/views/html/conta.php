<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conta! | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel='shorcut icon' href="../../../resources/favicon.png" type="image/x-icon">
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

 $tipo = SalvaTipo();
?>

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

<?php 
$nome = SalvaNome();
?>

<div id="TT">
    <h1>Conta</h1>
    <h2><?php echo $nome; ?>, <?php echo $registro['email']; ?></h2>
</div>

<section id="Quadrados">
<div class="quadrado">
  <a href="perfil.php">
  <svg width="96" height="96" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg">
    <g clip-path="url(#clip0_214_45)">
    <path d="M48.5 23C51.25 23 53.5 25.25 53.5 28C53.5 30.75 51.25 33 48.5 33C45.75 33 43.5 30.75 43.5 28C43.5 25.25 45.75 23 48.5 23ZM71 40.5H56V73H51V58H46V73H41V40.5H26V35.5H71V40.5Z" fill="black"/>
    </g>
    <defs>
    <clipPath id="clip0_214_45">
    <rect width="96" height="96"/>
</clipPath>
</defs>
</svg>
    <h5>Acessar perfil</h5>
    <h6>Seu perfil.</h6>
  </a>
</div>

<?php if ($tipo == "Dono"): ?>
<div>
  <a href="quadra.php">
    <img src="../img/Vetor(1).png" alt="">
    <h5>Acessar quadra</h5>
    <h6>Minha quadra.</h6>
  </a>
</div>
<?php endif; ?>

<div class="quadrado">
<a href="profile.php">
<svg width="96" height="96" viewBox="0 0 96 96" fill="white" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_220_2)">
<path d="M66 26H31C28.25 26 26 28.25 26 31V66C26 68.75 28.25 71 31 71H66C68.75 71 71 68.75 71 66V31C71 28.25 68.75 26 66 26ZM48.5 33.5C53.325 33.5 57.25 37.425 57.25 42.25C57.25 47.075 53.325 51 48.5 51C43.675 51 39.75 47.075 39.75 42.25C39.75 37.425 43.675 33.5 48.5 33.5ZM66 66H31V65.425C31 63.875 31.7 62.425 32.9 61.475C37.175 58.05 42.6 56 48.5 56C54.4 56 59.825 58.05 64.1 61.475C65.3 62.425 66 63.9 66 65.425V66Z" fill="black"/>
</g>
<defs>
<clipPath id="clip0_220_2">
<rect width="96" height="96" fill="white"/>
</clipPath>
</defs>
</svg>
    <h5>Informações pessoais</h5>
    <h6>Detalhes e informações pessoais.</h6>
</a>
</div>

<div class="quadrado">
    <a href="senha.php">
    
    <svg width="96" height="96" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_220_2)">
<path d="M28.0455 56.4545H68.9545V60.5455H28.0455V56.4545ZM30.3977 48.1705L32.1364 45.1432L33.875 48.1705L36.5341 46.6364L34.7955 43.6091H38.2727V40.5409H34.7955L36.5341 37.5341L33.875 36L32.1364 39.0068L30.3977 36L27.7386 37.5341L29.4773 40.5409H26V43.6091H29.4773L27.7386 46.6364L30.3977 48.1705ZM44.1023 46.6364L46.7614 48.1705L48.5 45.1432L50.2386 48.1705L52.8977 46.6364L51.1591 43.6091H54.6364V40.5409H51.1591L52.8977 37.5341L50.2386 36L48.5 39.0068L46.7614 36L44.1023 37.5341L45.8409 40.5409H42.3636V43.6091H45.8409L44.1023 46.6364ZM71 40.5409H67.5227L69.2614 37.5341L66.6023 36L64.8636 39.0068L63.125 36L60.4659 37.5341L62.2045 40.5409H58.7273V43.6091H62.2045L60.4659 46.6364L63.125 48.1705L64.8636 45.1432L66.6023 48.1705L69.2614 46.6364L67.5227 43.6091H71V40.5409Z" fill="black"/>
</g>
<defs>
<clipPath id="clip0_220_2">
<rect width="96" height="96" fill="white"/>
</clipPath>
</defs>
</svg>

    <h5>Alterar senha</h5>
    <h6>Altere sua senha.</h6>
    </a>
</div>
<div class="quadrado">
    <a href="deletar.php">
    <svg width="96" height="96" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_221_5)">
<path d="M68 32.0286L63.9714 28L48 43.9714L32.0286 28L28 32.0286L43.9714 48L28 63.9714L32.0286 68L48 52.0286L63.9714 68L68 63.9714L52.0286 48L68 32.0286Z" fill="black"/>
</g>
<defs>
<clipPath id="clip0_221_5">
<rect width="96" height="96" fill="white"/>
</clipPath>
</defs>
</svg>
    <h5>Desativar conta</h5>
    <h6>Excluir conta.</h6>
    </a>
</div>
</section>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../java/logoff.js"></script>
<script src="../java/dark.js"></script>
</body>
</html>