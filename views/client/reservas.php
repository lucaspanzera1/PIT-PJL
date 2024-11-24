<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas reservas | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel='shortcut icon' href="../../resources/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../resources/css/reservas.css?v=<?= time() ?>">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
</head>
<body>

<?php include '../layouts/header.php'; ?>
<?php include '../layouts/verification.php'; ?>

<div id="Info">
    <?php include '../layouts/mensagem.php'; ?>
    <h1>Minhas Reservas</h1>

    <div class="filtro-container">
        <label for="ordenacao" class="filtro-label">Ordenar por:</label>
        <select id="ordenacao" class="filtro-select">
            <option value="recente">Mais recente</option>
            <option value="antiga">Mais antiga</option>
        </select>
    </div>

    <?php if (!empty($reservas)): ?>
        <div id="reservas-container">
            <?php
                $reservasPorData = [];
                foreach ($reservas as $reserva) {
                    $dataFormatada = date('Y-m-d', strtotime($reserva['data']));
                    if (!isset($reservasPorData[$dataFormatada])) {
                        $reservasPorData[$dataFormatada] = [];
                    }
                    $reservasPorData[$dataFormatada][] = $reserva;
                }
                
                // Ordena as datas (inicialmente mais recente primeiro)
                krsort($reservasPorData);

                foreach ($reservasPorData as $data => $reservasDoDia):
                    $dataFormatadaDisplay = date('d/m/Y', strtotime($data));
            ?>
                <div class="reserva-container" data-date="<?= $data ?>">
                    <h2 class="data-titulo" data-id="data-<?= str_replace('/', '-', $dataFormatadaDisplay); ?>">
                        <?= htmlspecialchars($dataFormatadaDisplay); ?> 
                        <span class="seta">&#9654;</span>
                    </h2>
                    <div id="data-<?= str_replace('/', '-', $dataFormatadaDisplay); ?>" class="reserva-tabela">
                    <table>
    <thead>
        <tr>
            <th>Quadra</th>
            <th>Horário de Início</th>
            <th>Horário de Fim</th>
            <th>Valor</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservasDoDia as $reserva): ?>
            <tr>
                <td data-title="Quadra"><?= htmlspecialchars($reserva['nome_proprietario'] . ' ' . $reserva['nome_quadra']); ?></td>
                <td data-title="Horário de Início"><?= htmlspecialchars($reserva['horario_inicio']); ?></td>
                <td data-title="Horário de Fim"><?= htmlspecialchars($reserva['horario_fim']); ?></td>
                <td data-title="Valor">R$<?= htmlspecialchars($reserva['valor']); ?></td>
                <td data-title="Status"><?= htmlspecialchars($reserva['status']); ?></td>
                <td data-title="Ações" id="cancelar-btn">
                    <form onsubmit="return confirmarCancelamento(event, <?= $reserva['id']; ?>)">
                        <input type="hidden" name="reserva_id" value="<?= $reserva['id']; ?>">
                        <button type="submit" class="btn-cancelar">Cancelar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Você não tem reservas até o momento.</p>
    <?php endif; ?>
</div>
<script src="../../resources/js/reservas.js"></script>
</body>
</html>