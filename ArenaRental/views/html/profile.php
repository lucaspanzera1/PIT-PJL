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
<h2><a href="conta.php"><img src="../img/LOGO1.png" width="100px"></a></h2>
<div>
</div>
</header>

<div id="QuadCinza"></div>


<section>
    <h1>Olá, <?php 
    $nome = SalvaNome();
    echo $nome;
    ;?>!</h1>
    <h2>Edite seu perfil aqui!</h2>
</section>

<div id="QuadCinza"></div>

<div id="ImgPerfil"><?php FotoPerfil() ?></div>


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

        <script src="../java/cpf.js"></script>
        <script src="../java/script1.js"></script>
    </div>


    
</div>
</body>
</html>
