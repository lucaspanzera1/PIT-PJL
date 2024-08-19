<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindo! | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/registra.quadra2.css?v=<?= time() ?>">
</head>
<body>

<?php include '../../models/php/funcao.php'; ?>

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

<section>
  <div>
<h1>Adicione algumas fotos do seu espaço.</h1>
<h2>Você deve ter pelo menos 1 foto para publicar seu anúncio. Você pode adicionar ou alterar mais tarde.</h2>

<?php if(isset($_SESSION['nome'])) {
    $nome = $_SESSION['nome'];
} else {
    $nome = "usuário";
}

if(isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
    }
?>

    <form method="POST" action="../../models/php/upload.quadra.php" enctype="multipart/form-data">

    <label class="picture" for="picture__input" tabIndex="0">
        <span class="picture__image"></span>
      </label>
      
      <input name="arquivo" type="file" name="picture__input" id="picture__input">

      <button type="submit" id="Continuar">Continuar</button>

        </div>
        </form>
    

      <script>
        const inputFile = document.querySelector("#picture__input");
const pictureImage = document.querySelector(".picture__image");
const pictureImageTxt = "Foto";

inputFile.addEventListener("change", function (e) {
  const inputTarget = e.target;
  const file = inputTarget.files[0];

  if (file) {
    const reader = new FileReader();

    reader.addEventListener("load", function (e) {
      const readerTarget = e.target;

      const img = document.createElement("img");
      img.src = readerTarget.result;
      img.classList.add("picture__img");

      pictureImage.innerHTML = "";
      pictureImage.appendChild(img);
    });

    reader.readAsDataURL(file);
  } else {
    // Se não houver arquivo selecionado, mostra o texto padrão
    pictureImage.innerHTML = pictureImageTxt;
  }
});
      </script>
       </form>

       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../java/logoff.js"></script>
<script src="../java/dark.js"></script>
</body>
</html>