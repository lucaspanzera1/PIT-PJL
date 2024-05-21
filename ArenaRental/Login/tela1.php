<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela 1 © 2024 Arena Rental, Inc.</title>
    <link rel="stylesheet" type="text/css" href="tela1.css" media="screen" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

</head>
<body>
<?php
session_start(); // Inicia a sessão (se ainda não foi iniciada)

// Verifica se a variável $nome está definida na sessão
if(isset($_SESSION['nome'])) {
    $nome = $_SESSION['nome'];
} else {
    $nome = "usuário";
}
?>

<div id="Quad"> 
       <h1>Bem vindo <?php echo $nome; ?>!</h1>

       <div id="QuadCinza"></div>

       
        
    

</div>
</body>
</html>