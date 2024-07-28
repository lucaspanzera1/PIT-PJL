<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar ou cadastre-se | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/register.css?v=<?= time() ?>">
</head>
<body>

<header>
<a href="../../index.php"><h2 id="imgH2"></h2></a>
<h1>ArenaRental©</h1>
<div id="FotoPerfil">
<div class="dropdown">
<button class="mainmenubtn"></button>
<div class="dropdown-child"><button id="toggle-theme">Alterar tema</button></div>
</div></div>
</header>

    <div id="Quad"> 
       <h1>Registrar-se como:</h1>

       <div id="QuadCinza"></div>

       <section>
      <a href="registrar.dono.php"><button>Dono de Quadra</button></a>
        <a href="registrar.atleta.php"><button>Atleta</button></a>
       </section>
       
       <div id="QuadCinza2"></div>

       <div id="Cadastro">
        <div>Já tem cadasto? <a href="login.php">Login.</a></div>
       </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../java/cpf.js"></script>
    <script src="../java/dark.js"></script>
</body>
</html>
