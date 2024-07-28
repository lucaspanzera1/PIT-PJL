<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações pessoais | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/profile.css?v=<?= time() ?>">
</head>
<body>
<?php include '../../models/php/funcao.php'; ?>



<header>
<a href="conta.php"><h2 id="imgH2"></h2></a>
<h1>ArenaRental©</h1>
<div id="FotoPerfil">
<div class="dropdown">
    <button class="mainmenubtn"></button>
    <div class="dropdown-child"><button class="logoff-btn">Logoff</button></div>
    <div class="dropdown-child"><button id="toggle-theme">Alterar tema</button></div>
  </div></div>

</header>

<div id="QuadCinza"></div>


<section>
    <h1>Olá, <?php 
    $nome = SalvaNome();
    echo $nome;
    ;?>!</h1>
    <h2>Edite seu perfil aqui.</h2>
</section>

<div id="QuadCinza2"></div>

<div id="ImgPerfil">
<form method="POST" action="../../models/php/proc_upload.php" enctype="multipart/form-data">

<label class="picture" for="picture__input" tabIndex="0">
    <span class="picture__image"></span>
  </label>
  
  <input name="arquivo" type="file" name="picture__input" id="picture__input">

  <input type="submit" id="Continuar" value="Alterar foto">

    </div>
    </form>


    <?php $nome_imagem = Foto() ?>
    <script>
        var nomeImagem = "<?php echo $nome_imagem; ?>";
    </script>
  <script src="../java/foto.js"></script>
   </form>
</div>


<div id="fundo"> 
    <div id="fundobranco">
        <?php
            require('../../controllers/conexao.php');
            require_once '../../models/php/funcao.php'; // Use require_once em vez de include_once para garantir que o arquivo seja incluído apenas uma vez

            $id = SalvaID(); // Chama a função SalvaID() e atribui o valor retornado à variável $id
            
            if (isset($_SESSION['id'])) {
                $id = $_SESSION['id'];
        
                $registro = buscarRegistro($pdo, $id);

                if ($registro) {
        ?>
<form action="../../models/php/update.php" method="post">
    <label>CPF:</label>
    <input   type="text" id="cpf" oninput="mascararCPF()" maxlength="14"  name="cpf"  value="<?php echo $registro['cpf']; ?>" required>
    <br>
    <div></div>
    <label>Nome:</label>
    <input type="text" name="nome" value="<?php echo $registro['nome']; ?>" required>
    <br>
    <div></div>
    <label>Email: </label>
    <input type="text" name="email" value="<?php echo $registro['email']; ?>" required>
    <br>
    <div></div>
    <input type="submit" id="" value="Salvar alterações">
</form>

        <?php
            } else {
                echo "<p>Usuário não encontrado.</p>";
            }
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../java/logoff.js"></script>
<script src="../java/dark.js"></script>
</body>
</html>
