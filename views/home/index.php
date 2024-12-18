<?php
require_once '../../models/User.php';

$esporte = isset($_GET['esporte']) && $_GET['esporte'] !== 'todos' ? $_GET['esporte'] : null;
$regiao = isset($_GET['regiao']) && $_GET['regiao'] !== 'todos' ? $_GET['regiao'] : null;
$valor_min = isset($_GET['valor_min']) ? floatval($_GET['valor_min']) : null;
$valor_max = isset($_GET['valor_max']) ? floatval($_GET['valor_max']) : null;

// Para depuração
error_log("Filtros aplicados - Região: " . ($regiao ?? 'todas') . ", Esporte: " . ($esporte ?? 'todos') . 
          ", Valor Min: " . ($valor_min ?? 'não definido') . ", Valor Max: " . ($valor_max ?? 'não definido'));

// Chamada da função atualizada
$quadras = User::getAllQuadras($esporte, $valor_min, $valor_max, $regiao);

// Verificação de erros
if ($quadras === false) {
    echo "Ocorreu um erro ao buscar as quadras.";;
} else {
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel='shorcut icon' href="../../resources/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../resources/css/index.css?v=<?= time() ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php include '../layouts/header.php'; ?>

    <div id="search-container">
        <?php include '../layouts/search.php'; ?>
        <?php include '../layouts/slider.php'; ?>
        <?php include '../layouts/map-btn.php'; ?>
    </div>

    <section class="quadra-list-container">
        <?php if (!empty($quadras)): ?>
        <div class="quadra-list">
            <?php foreach ($quadras as $quadra): ?>
            <div class="quadra-item">
                <a href="quadra_detalhes.php?id=<?php echo htmlspecialchars($quadra['id']); ?>" target="_blank">
                    <?php if (!empty($quadra['imagem_quadra'])): ?>
                    <img src="../<?php echo htmlspecialchars($quadra['imagem_quadra']); ?>"
                        alt="<?php echo htmlspecialchars($quadra['nome']); ?>" class="quadra-image">
                    <?php else: ?>
                    <div class="quadra-image">Sem imagem disponível</div>
                    <?php endif; ?>
                    <h2><?php echo htmlspecialchars($quadra['nome_proprietario']);?>
                        <b><?php echo htmlspecialchars($quadra['nome']); ?></b>
                    </h2>
                    <p><?php echo htmlspecialchars($quadra['esporte']); ?>,
                        <?php echo $quadra['coberta'] ? 'coberta' : 'descoberta'; ?></p>
                    <p><b>R$<?php echo number_format($quadra['valor'], 2, ',', '.'); ?></b>/<?php echo $quadra['tipo_aluguel'] == 'por hora' ? 'por hora' : 'dia'; ?>
                    </p>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p>Nenhuma quadra disponível no momento.</p>
        <?php endif; ?>
    </section>

    <script src="../../resources/js/animacao.index.js"></script>

    <?php include '../layouts/footer.php'; ?>
</body>

</html>