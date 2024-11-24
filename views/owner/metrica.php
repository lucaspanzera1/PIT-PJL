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
    <link rel="stylesheet" href="../../resources/css/metrica.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <?php include '../layouts/header.php'; ?>
    <?php include '../layouts/verification.php'; 
?>

    <div id="Info">
        <h1>Métricas</h1>
        <?php $ownerId =  $_SESSION['client']['id'];  ?>
        <section class="section-container">
            <div class="scroll-container">
                <div class="card-wrapper">
                    <a href="analise.ocupacao.php" class="ocupacao">
                        <div class="filter-section animated" id="primeira-ocupacao">
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
                    </a>
                    <script src="../../resources/js/metrica.diasdasemana.js"></script>


                    <a href="distribuicao.reservas" class="ocupacao">
                        <h3 class="filter-title">⏰ Horários mais reservados</h3>
                        <div class="dashboard-container p-4 bg-white rounded-lg shadow-lg">

                            <div class="filtros-container bg-gray-50 p-4 rounded-lg mb-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Filtro Tipo de Visualização -->
                                    <div class="filter-group">
                                        <label for="tipoVisualizacao"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Tipo de Visualização
                                        </label>
                                        <select id="tipoVisualizacao"
                                            class="form-select w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                            <option value="ano">Ano Inteiro</option>
                                            <option value="mes">Por Mês</option>
                                            <option value="semana">Por Semana</option>
                                        </select>
                                    </div>

                                    <!-- Filtro Mês -->
                                    <div class="filter-group" id="mesContainer" style="display: none;">
                                        <label for="mesSelecionado"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Mês
                                        </label>
                                        <select id="mesSelecionado"
                                            class="form-select w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
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
                                    </div>

                                    <!-- Filtro Semana -->
                                    <div class="filter-group" id="semanaContainer" style="display: none;">
                                        <label for="semanaSelecionada"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Semana
                                        </label>
                                        <select id="semanaSelecionada"
                                            class="form-select w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                            <!-- Preenchido via JavaScript -->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Container do gráfico com loading state -->
                            <div class="chart-container relative bg-white rounded-lg shadow p-4" style="height: 400px;">
                                <div id="loadingIndicator"
                                    class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center"
                                    style="display: none;">
                                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
                                </div>
                                <canvas id="horariosChart"></canvas>
                            </div>

                            <!-- Legenda e informações adicionais -->
                            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="stat-card bg-blue-50 p-4 rounded-lg">
                                    <h3 class="text-sm font-semibold text-blue-800">Total de Reservas</h3>
                                    <p class="text-2xl font-bold text-blue-600" id="totalReservas">-</p>
                                </div>
                                <div class="stat-card bg-green-50 p-4 rounded-lg">
                                    <h3 class="text-sm font-semibold text-green-800">Horário Mais Popular</h3>
                                    <p class="text-2xl font-bold text-green-600" id="horarioPopular">-</p>
                                </div>
                                <div class="stat-card bg-purple-50 p-4 rounded-lg">
                                    <h3 class="text-sm font-semibold text-purple-800">Média por Dia</h3>
                                    <p class="text-2xl font-bold text-purple-600" id="mediaDia">-</p>
                                </div>
                            </div>
                        </div>
                        <script src="../../resources/js/metrica.horarios.js"></script>
                    </a>

                    <a href="usuarios.php" class="ocupacao">
                        <h3 class="filter-title">👥Usuário</h3>
                        <div class="chart-container">
                            <div class="chart-card">
                                <canvas id="usuariosChart" height="400"></canvas>
                            </div>
                            <script src="../../resources/js/metrica.usuarios.js"></script>
                        </div>
                    </a>


                    <a href="reservas.totais.php" class="ocupacao">
                        <h3 class="filter-title">💸Valores</h3>
                        <div class="dashboard-card">
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
                </a>
            </div>
    </div>
    </section>

    <script src="../java/dark.js"></script>
</body>

</html>