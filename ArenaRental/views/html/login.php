<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar ou cadastre-se | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css?v=<?= time() ?>">
</head>
<body>

    <div id="Quad"> 
       <h1>Entrar ou cadastre-se</h1>

       <div id="QuadCinza"></div>

       <h2>Bem vindo a ArenaRental!</h2>

       <form action="../../models/php/login.php" method="post">
        
       <input type="text" id="cpf"  placeholder="CPF" oninput="mascararCPF()" maxlength="14"  name="cpf"  required>
       <input type="password" id="numero" placeholder="Senha" name="password" required >

       <div id="QuadCinza2"></div>

       <input type="submit" id="Continuar" value="Continuar">
       <p>Ainda não tem cadastro? <a href="registrar.php">Registrar-se</a></p>
     </form>
    </div>


    <script src="../java/cpf.js"></script>
</body>
</html>
