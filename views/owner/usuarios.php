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
    <link rel="stylesheet" href="../../resources/css/reservas.totais.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

    <?php include '../layouts/header.php'; ?>
    <?php include '../layouts/verification.php'; ?>

    <div id="Info">
        <div class="chart-container">
            <div class="chart-card">
                <canvas id="usuariosChart" height="400"></canvas>
                <script src="../../resources/js/metrica.usuarios.js"></script>
            </div>
        </div>
    </div>


    <script src="../java/dark.js"></script>
</body>

</html>