
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conta! | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel='shorcut icon' href="../../resources/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../resources/css/conta.css?v=<?= time() ?>">
</head>
<body>

<?php include '../layouts/header.php'; ?>
<?php include '../layouts/verification.php'; ?>

<div id="Info">
    <h1>Conta</h1>
    <h2><?php echo "" . htmlspecialchars($client->getFirstName()) . "," .  htmlspecialchars($_SESSION['client']['email']); ?></h2>
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
    <h5>Acessar Perfil</h5>
    <h6>Seu perfil.</h6>
  </a>
</div>

<div class="quadrado">
  <a href="perfil.php">
  <svg width="96" height="96" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M46.25 61C42.5 61 39.3125 59.6875 36.6875 57.0625C34.0625 54.4375 32.75 51.25 32.75 47.5C32.75 47.0875 32.7688 46.675 32.8063 46.2625C32.8438 45.85 32.9 45.4375 32.975 45.025C32.75 45.1 32.525 45.1563 32.3 45.1938C32.075 45.2313 31.85 45.25 31.625 45.25C30.05 45.25 28.7187 44.7062 27.6312 43.6187C26.5437 42.5312 26 41.2 26 39.625C26 38.05 26.516 36.7187 27.548 35.6312C28.5785 34.5437 29.8813 34 31.4563 34C32.6938 34 33.809 34.3472 34.802 35.0417C35.7965 35.7347 36.5 36.625 36.9125 37.7125C38.15 36.5875 39.566 35.6875 41.1605 35.0125C42.7535 34.3375 44.45 34 46.25 34H68.75C69.3875 34 69.9215 34.2153 70.352 34.6458C70.784 35.0778 71 35.6125 71 36.25V40.75C71 41.3875 70.784 41.9215 70.352 42.352C69.9215 42.784 69.3875 43 68.75 43H59.75V47.5C59.75 51.25 58.4375 54.4375 55.8125 57.0625C53.1875 59.6875 50 61 46.25 61ZM31.625 41.875C32.2625 41.875 32.7972 41.659 33.2292 41.227C33.6597 40.7965 33.875 40.2625 33.875 39.625C33.875 38.9875 33.6597 38.4527 33.2292 38.0207C32.7972 37.5902 32.2625 37.375 31.625 37.375C30.9875 37.375 30.4535 37.5902 30.023 38.0207C29.591 38.4527 29.375 38.9875 29.375 39.625C29.375 40.2625 29.591 40.7965 30.023 41.227C30.4535 41.659 30.9875 41.875 31.625 41.875ZM46.25 52C47.4875 52 48.5473 51.559 49.4293 50.677C50.3098 49.7965 50.75 48.7375 50.75 47.5C50.75 46.2625 50.3098 45.2027 49.4293 44.3207C48.5473 43.4402 47.4875 43 46.25 43C45.0125 43 43.9535 43.4402 43.073 44.3207C42.191 45.2027 41.75 46.2625 41.75 47.5C41.75 48.7375 42.191 49.7965 43.073 50.677C43.9535 51.559 45.0125 52 46.25 52Z" fill="black"/>
</svg>

    <h5>Acessar Quadra</h5>
    <h6>Sua Quadra.</h6>
  </a>
</div>

<div class="quadrado">
<a href="editar_perfil.php">
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



<script src="../java/dark.js"></script>
</body>
</html>