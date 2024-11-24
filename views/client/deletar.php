<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desativar conta | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel='shorcut icon' href="../../resources/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../resources/css/deletar.css?v=<?= time() ?>">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
</head>
<body>

<?php include '../layouts/header.php'; ?>
<?php include '../layouts/verification.php'; ?>

<section>
   <div> 
    <h1>Olá, <?php 
        $nomeCompleto = htmlspecialchars($client->getName());
        $primeiroNome = explode(' ', $nomeCompleto)[0];
        echo $primeiroNome; 
    ?>!</h1>
    <h2>Lamentamos ver você partir!</h2>
   </div> 

<div id="QuadCinza2"></div>

    <div id="div-delete">
        <h1>Desativar a conta?</h1>
        <h2><?php echo htmlspecialchars($_SESSION['client']['email']); ?></h2>
        <form id="deleteForm" action="../../controllers/ClientController.php?action=delete" method="post" onsubmit="return confirmarDelete(event)">
            <input id="Continuar" type="submit" value="Deletar conta">
        </form>
    </div>
</section>
<script src="../../resources/js/deletar.confirmar.js"></script>


</body>
</html>