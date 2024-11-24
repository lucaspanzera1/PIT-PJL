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
        <div class="dashboard-card">
            <h3 class="filter-title">💸Valores</h3>
            <div class="filter-container">
                <select id="mesSelect" class="filter-select">
                    <option value="">Todos os Meses</option>
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>
                <select id="anoSelect" class="filter-select">
                    <option value="">Todos os Anos</option>
                    <!-- Anos serão preenchidos via JavaScript -->
                </select>
            </div>
            <div class="stat-cards">
                <div class="stat-card" id="siteCard">
                    <div class="stat-card-title">Reservas pelo Site</div>
                    <div class="stat-card-value" id="siteTotalValue">Carregando...</div>
                </div>
                <div class="stat-card" id="offSiteCard">
                    <div class="stat-card-title">Reservas Fora do Site</div>
                    <div class="stat-card-value" id="offSiteTotalValue">Carregando...</div>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="distribuicaoChart"></canvas>
            </div>
            <div class="total-valor">
                <div class="total-label">Valor Total em Reservas</div>
                <div class="total-amount" id="totalAmount">Carregando...</div>
            </div>
        </div>
        <script src="../../resources/js/metrica.distribuicao.js"></script>
    </div>


    <script src="../java/dark.js"></script>
</body>

</html>