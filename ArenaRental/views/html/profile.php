<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/profile.css?v=<?= time() ?>">
</head>
<body>
<?php include '../../models/php/funcao.php'; ?>

<?php
if(isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
} 
?>

<header>
<h2><a><img src="../img/LOGO1.png" width="100px"></a></h2>
<div>
</div>
</header>

<div id="QuadCinza"></div>


<section>
    <h1>Olá, <?php SalvaNome();?>!</h1>
    <h2>Edite seu perfil aqui!</h2>
</section>

<div id="QuadCinza"></div>

<div id="ImgPerfil"><?php FotoPerfil() ?></div>


<div id="fundo"> 
    <div id="fundobranco">
  
        <?php
            require('../../controllers/conexao.php');

            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];

                $registro = buscarRegistro($pdo, $email);

                if ($registro) {
        ?>

        <form action="../../models/php/update.php" method="post">
            <label>CPF:</label>
            <input type="text" name="cpf" id="data" maxlength="14" oninput="formatarCPF()"  value="<?php echo $registro['cpf']; ?>" required>
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
            <label>Senha:</label>
            <input type="text" name="senha" value="<?php echo $registro['senha']; ?>" required>
            <br>
            <div></div>

            <nav>
            <input type="submit" id="" value="Salvar alterações">
        </form>
        <form id="deleteForm" action="../../models/php/delete.php" method="post">
    <input type="hidden" name="cpf" value="<?php echo $registro['cpf']; ?>">
    <input type="submit" value="Deletar conta" onclick="return confirm('Tem certeza que deseja deletar a conta?');">
</form>

        </nav>

        <?php
            } else {
                echo "<p>Usuário não encontrado.</p>";
            }
        }
        ?>

        <script src="cpf.js"></script>
        <script src="../java/script1.js"></script>
    </div>


    
</div>
</body>
</html>
