<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindo! | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/page1.css?v=<?= time() ?>">
</head>
<body>

    <div id="Quad"> 
       <h1>Quase lá!</h1>

       <div id="QuadCinza"></div>
       
       <header>
       <h2>Bem-vindo a ArenaRental!</h2>
       <h2>Primeiro, adicione uma foto no seu perfil!</h2>
       </header>

       <?php
session_start();


if(isset($_SESSION['nome'])) {
    $nome = $_SESSION['nome'];
} else {
    $nome = "usuário";
}

if(isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
    }
?>

    <form method="POST" action="../../models/php/proc_upload.php" enctype="multipart/form-data">

    <label class="picture" for="picture__input" tabIndex="0">
        <span class="picture__image"></span>
      </label>
      
      <input name="arquivo" type="file" name="picture__input" id="picture__input">

      <input type="submit" id="Continuar" value="Enviar">

        </div>
        </form>
    

      <script src="../java/script.js"></script>
       </form>

     
       
    </div>
</body>
</html>