<?php
// Verifica os filtros aplicados (caso existam) usando a URL
$regiaoSelecionada = isset($_GET['regiao']) ? $_GET['regiao'] : 'todos';
$esporteSelecionado = isset($_GET['esporte']) ? $_GET['esporte'] : 'todos';
$minPrice = isset($_GET['valor_min']) ? $_GET['valor_min'] : 0;
$maxPrice = isset($_GET['valor_max']) ? $_GET['valor_max'] : 1000;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtros de Quadras - Popup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css">
    <link rel="stylesheet" href="../../resources/css/slider.css?v=<?= time() ?>">
</head>

<body>

    <a href="../home/mapa.php" target="_blank">
        <button id="filter-button">
            <svg width="96" height="96" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink">
                <mask id="mask0_577_10" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="96"
                    height="96">
                    <rect width="96" height="96" fill="url(#pattern0_577_10)" />
                </mask>
                <g mask="url(#mask0_577_10)">
                    <rect x="-2" y="-2" width="100" height="100" fill="white" />
                </g>
                <defs>
                    <pattern id="pattern0_577_10" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image0_577_10" transform="scale(0.0104167)" />
                    </pattern>
                    <image id="image0_577_10" width="96" height="96"
                        xlink:href="data:image/png;base64,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" />
                </defs>
            </svg>
        </button>
    </a>
</body>

</html>