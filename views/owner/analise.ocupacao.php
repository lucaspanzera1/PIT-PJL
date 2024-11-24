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
    <link rel="stylesheet" href="../../resources/css/ocupacao.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <?php include '../layouts/header.php'; ?>
    <?php include '../layouts/verification.php'; ?>

    <div id="Info">
        <?php $ownerId =  $_SESSION['client']['id'];  ?>
    </div>

    <div class="dashboard-container">
        <div class="filter-section animated">
            <h3 class="filter-title">📊 Análise de Ocupação</h3>
            <div class="filters-row">
                <div class="filter-item">
                    <label class="input-label" for="periodoFiltro">
                        <i class="fas fa-calendar-alt"></i> Período
                    </label>
                    <select id="periodoFiltro" class="form-select">
                        <option value="ano">Ano Inteiro</option>
                        <option value="mes">Mês Específico</option>
                        <option value="personalizado">Período Personalizado</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label class="input-label" for="dataInicio">
                        <i class="fas fa-calendar-plus"></i> Data Inicial
                    </label>
                    <input type="date" id="dataInicio" class="form-control">
                </div>

                <div class="filter-item">
                    <label class="input-label" for="dataFim">
                        <i class="fas fa-calendar-minus"></i> Data Final
                    </label>
                    <input type="date" id="dataFim" class="form-control">
                </div>

                <div class="filter-item button">
                    <button id="aplicarFiltro" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
            </div>
            <div class="chart-section animated">
                <canvas id="ocupacaoChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    </div>
    <script src="../../resources/js/metrica.diasdasemana.js"></script>
    <script src="../java/dark.js"></script>
</body>

</html>