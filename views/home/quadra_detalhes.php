<?php
require_once '../../models/Owner.php';
require_once '../../models/Client.php';
require_once '../../models/User.php';

$jaAvaliou = false;

// Verifica se o ID foi fornecido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die('ID da quadra não fornecido ou inválido.');
}

$id_quadra = (int) $_GET['id'];

// Busca os detalhes da quadra
$quadra = User::getQuadraById($id_quadra);

if (!$quadra) {
  die('Quadra não encontrada.');
}

$reviews = User::getQuadraReviews($id_quadra);

// Calcula a média das avaliações
$totalReviews = count($reviews);
$totalScore = 0;
foreach ($reviews as $review) {
    $totalScore += $review['nota'];
}
$averageRating = $totalReviews > 0 ? round($totalScore / $totalReviews, 1) : 0;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($quadra['nome_espaco']); ?> <?php echo htmlspecialchars($quadra['nome']); ?> | ©
        2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel='shorcut icon' href="../../resources/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../resources/css/detalhes_quadra.css?v=<?= time() ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <?php include '../layouts/header.php'; ?>
    <section>
        <?php include '../layouts/mensagem.php'; ?>
        <h1><?php echo htmlspecialchars($quadra['nome_espaco']); ?> <?php echo htmlspecialchars($quadra['nome']); ?>
        </h1>

        <div class="container">
            <div id="images-container" class="images-container">
                <div class="slider-container">
                    <div class="slider">
                        <?php if (!empty($quadra['imagem_quadra'])): ?>
                        <div class="slide">
                            <img src="../<?php echo htmlspecialchars($quadra['imagem_quadra']); ?>"
                                alt="<?php echo htmlspecialchars($quadra['nome']); ?>" onclick="openModal(this)"
                                class="quadra-image-large">
                        </div>
                        <?php endif; ?>
                        <div class="slide">
                            <img src="../<?php echo htmlspecialchars($quadra['imagem1']); ?>"
                                alt="<?php echo htmlspecialchars($quadra['nome']); ?>" onclick="openModal(this)"
                                class="quadra-image-large">
                        </div>
                        <div class="slide">
                            <img src="../<?php echo htmlspecialchars($quadra['imagem2']); ?>"
                                alt="<?php echo htmlspecialchars($quadra['nome']); ?>" onclick="openModal(this)"
                                class="quadra-image-large">
                        </div>
                        <div class="slide">
                            <img src="../<?php echo htmlspecialchars($quadra['imagem3']); ?>"
                                alt="<?php echo htmlspecialchars($quadra['nome']); ?>" onclick="openModal(this)"
                                class="quadra-image-large">
                        </div>
                        <div class="slide">
                            <img src="../<?php echo htmlspecialchars($quadra['imagem4']); ?>"
                                alt="<?php echo htmlspecialchars($quadra['nome']); ?>" onclick="openModal(this)"
                                class="quadra-image-large">
                        </div>
                    </div>
                    <div class="slider-nav">
                        <button class="prev-btn">&lt;</button>
                        <button class="next-btn">&gt;</button>
                    </div>
                    <div class="dots-container"></div>
                </div>
            </div>

            <script src="../../resources/js/quadradetalhes.modalmobile.js"></script>

            <div id="imageModal" class="modal">
                <span class="close" onclick="closeModal()">&times;</span>
                <span class="prev" onclick="changeImage(-1)">&#10094;</span>
                <span class="next" onclick="changeImage(1)">&#10095;</span>
                <img class="modal-content" id="modalImage">
            </div>

            <script src="../../resources/js/quadradetalhes.modalpc.js"></script>

            <div id="container-quadra">
                <h2 id="container-info"><?php echo htmlspecialchars($quadra['esporte']); ?>, bairro
                    <?php echo htmlspecialchars($quadra['bairro']); ?>, região
                    <?php echo htmlspecialchars($quadra['regiao']); ?></h2>
                <b id="recursos"></b>
            </div>

            <h3 id="info-quadra">
                <div><?php echo $quadra['coberta'] ? 'Quadra coberta' : 'Quadra descoberta'; ?>, com </div>
                <p id="recursos-texto"></p>
            </h3>

            <?php
    // Defina a variável $recursos com os dados da quadra
    $recursos = json_decode(htmlspecialchars_decode($quadra['recursos']), true);
    ?>
            <script>
            const recursos = <?php echo json_encode($recursos); ?>;
            </script>
            <script src="../../resources/js/quadradetalhes.recursos.js"></script>


            <div>
                <div id="grid-reserva">
                    <nav class="nav-grid-owner-review">
                        <div id="dono-container">
                            <a href="perfil_dono.php?id=<?php echo htmlspecialchars($quadra['proprietario_id']); ?>">
                                <img src="../<?php echo htmlspecialchars($quadra['imagem_proprietario']); ?>"
                                    alt="Imagem de perfil de <?php echo htmlspecialchars($quadra['nome_proprietario']); ?>"
                                    class="imagem-perfil">
                                <a href="perfil_dono.php?id=<?php echo htmlspecialchars($quadra['proprietario_id']); ?>"
                                    id="client-container">
                                    <div>
                                        <h4>Anfitriã(o): <?php $nomeCompleto = htmlspecialchars($quadra['nome_proprietario']); 

                                            // Divide o nome completo em partes usando espaço como delimitador
                                                $partesNome = explode(' ', $nomeCompleto);

                                            // Obtém o primeiro e o último nome
                                            $primeiroNome = $partesNome[0];
                                            $ultimoNome = $partesNome[count($partesNome) - 1];

                                            // Exibe o primeiro e o último nome
                                            echo $primeiroNome . ' ' . $ultimoNome; ?></h4>

                                        <h5>Entrou em <?php 
                                            $data_registro = new DateTime($quadra['data_registro_proprietario']);
                                            $data_atual = new DateTime();
                                            $intervalo = $data_atual->diff($data_registro);
                                            
                                            if ($intervalo->y > 0) {
                                                echo $intervalo->y . ($intervalo->y == 1 ? ' ano' : ' anos');
                                            } elseif ($intervalo->m > 0) {
                                                echo $intervalo->m . ($intervalo->m == 1 ? ' mês' : ' meses');
                                            } else {
                                                echo $intervalo->d . ($intervalo->d == 1 ? ' dia' : ' dias');
                                            }
                                            echo " atrás"; ?>
                                        </h5>
                                    </div>
                                </a>
                        </div>

                        <?php if (isset($_SESSION['client'])): ?>
                        <?php if ($_SESSION['client']['id'] != $quadra['proprietario_id']): ?>
                        <!-- Botão para cliente iniciar chat com proprietário -->
                        <button
                            onclick="iniciarChat(<?php echo $quadra['proprietario_id']; ?>, <?php echo $quadra['id']; ?>)"
                            class="btn btn-primary">
                            <i class="fas fa-comments"></i> Fale com o Dono
                        </button>
                        <?php endif; ?>
                        <?php endif; ?>

                        <script src="../../resources/js/quadradetalhes.iniciar.chat.js"></script>
                        </a>

                        <section class="reviews">
                            <div class="review-summary">
                                <nav class="grid-rating">
                                    <div class="review-rating">
                                        <p class="review-average"><?php echo number_format($averageRating, 1); ?></p>
                                        <?php 
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $averageRating) {
                                                    echo '<span class="star filled">★</span>';
                                                } else {
                                                    echo '<span class="star empty">☆</span>';
                                                } } ?>
                                    </div>
                                </nav>

                                <nav class="grid-rating">
                                    <p class="review-count"><?php echo $totalReviews; ?></br> avaliações</p>
                                    <?php if (isset($_SESSION['client'])): ?>
                                    <button class="btn reserve-button" onclick="toggleRatingForm()">Avaliar esta
                                        quadra</button>
                                    <?php endif; ?>
                                </nav>
                            </div>

                            <?php if (isset($_SESSION['client'])): ?>
                            <div class="rating-container" id="rating-form" style="display: none;">
                                <h2>Avalie esta quadra</h2>
                                <form action="../../controllers/ClientController.php?action=avaliarQuadra" method="POST"
                                    class="rating-form">
                                    <div class="star-rating">
                                        <input type="radio" id="star5" name="nota" value="5" />
                                        <label for="star5" title="5 estrelas">★</label>

                                        <input type="radio" id="star4" name="nota" value="4" />
                                        <label for="star4" title="4 estrelas">★</label>

                                        <input type="radio" id="star3" name="nota" value="3" />
                                        <label for="star3" title="3 estrelas">★</label>

                                        <input type="radio" id="star2" name="nota" value="2" />
                                        <label for="star2" title="2 estrelas">★</label>

                                        <input type="radio" id="star1" name="nota" value="1" />
                                        <label for="star1" title="1 estrela">★</label>
                                    </div>
                                    <input type="hidden" name="id_quadra" value="<?= $id_quadra ?>">
                                    <button type="submit" class="btn-submit">Enviar avaliação</button>
                                </form>
                            </div>
                            <?php endif; ?>
                            <script src="../../resources/js/quadradetalhes.abrir.avaliacoes.js"></script>
                            <?php include '../layouts/mensagem.avaliacao.php'; ?>
                        </section>
                    </nav>


                    <form action="../../controllers/ClientController.php?action=reservarQuadra" method="POST">
                        <div class="container-reserva">
                            <h2>Verificar horário</h2>
                            <div class="date-time">
                                <input type="date" id="data_reserva" name="data_reserva" min="<?= date('Y-m-d') ?>">
                                <select id="horario_inicio" name="horario_inicio">
                                    <option value="">Início</option>
                                </select>
                                <select id="horario_fim" name="horario_fim">
                                    <option value="">Fim</option>
                                </select>
                            </div>
                            <button class="btn reserve-button" type="submit">
                                <i class="fas fa-calendar-alt"></i>Reservar</button>
                            <div class="price-info">
                                <span>Duração: <span id="duracao">0</span> hora(s)</span>
                                <span>R$<span
                                        id="preco_hora"><?= htmlspecialchars($quadra['valor']) ?></span>/hora</span>
                            </div>
                            <div>
                                <label class="price-info">Taxa adicional (3%): <div>R$<span id="taxa_adicional">0</span>
                                    </div></label>
                            </div>
                            <div class="total">
                                <span>Total a pagar</span>
                                <span>R$<span id="total_pagar">0</span></span>
                            </div>
                            <input type="hidden" name="id_quadra" value="<?= $id_quadra ?>">
                            <input type="hidden" id="valor_total" name="valor_total">
                        </div>
                    </form>
                </div>


                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const dataReserva = document.getElementById('data_reserva');
                    const horarioInicio = document.getElementById('horario_inicio');
                    const horarioFim = document.getElementById('horario_fim');
                    const btnReservar = document.getElementById('btn_reservar');
                    const duracaoSpan = document.getElementById('duracao');
                    const totalPagarSpan = document.getElementById('total_pagar');
                    const taxaAdicionalSpan = document.getElementById('taxa_adicional');
                    const precoHora = parseFloat(document.getElementById('preco_hora').textContent);

                    let horarioIntervaloInicio = null;
                    let horarioIntervaloFim = null;
                    const fimDoExpediente = '22:00'; // Ajuste conforme necessário

                    dataReserva.addEventListener('change', function() {
                        const dataSelecionada = this.value;

                        fetch(
                                `../../controllers/AuthController.php?action=getHorariosDisponiveis&quadra_id=<?= $id_quadra ?>&data=${dataSelecionada}`
                            )
                            .then(response => response.json())
                            .then(data => {
                                if (data.length === 0) {
                                    alert('Nenhum horário disponível para essa data.');
                                    return;
                                }
                                identificarIntervalo(data);
                                preencherHorarios(data);
                            })
                            .catch(error => console.error('Erro ao buscar horários:', error));
                    });

                    function identificarIntervalo(data) {
                        horarioIntervaloInicio = null;
                        horarioIntervaloFim = null;
                        data.forEach(periodo => {
                            if (periodo.tipo === 'intervalo') {
                                horarioIntervaloInicio = periodo.horario_inicio;
                                horarioIntervaloFim = periodo.horario_fim;
                            }
                        });
                        console.log("Intervalo identificado:", horarioIntervaloInicio, horarioIntervaloFim);
                    }

                    function preencherHorarios(data) {
                        horarioInicio.innerHTML = '<option value="">Início</option>';
                        horarioFim.innerHTML = '<option value="">Fim</option>';

                        data.forEach(periodo => {
                            if (periodo.tipo === 'disponível') {
                                let inicio = new Date(`2000-01-01T${periodo.horario_inicio}`);
                                let fim = new Date(`2000-01-01T${periodo.horario_fim}`);

                                while (inicio < fim) {
                                    let horaFormatada = inicio.toTimeString().slice(0, 5);
                                    let optionInicio = document.createElement('option');
                                    optionInicio.value = horaFormatada;
                                    optionInicio.textContent = horaFormatada;
                                    horarioInicio.appendChild(optionInicio);

                                    inicio.setMinutes(inicio.getMinutes() + 30);
                                }
                            }
                        });

                        btnReservar.disabled = true;
                    }

                    horarioInicio.addEventListener('change', function() {
                        horarioFim.innerHTML = '<option value="">Fim</option>';

                        if (this.value) {
                            let inicioSelecionado = new Date(`2000-01-01T${this.value}`);
                            let limiteFim = new Date(`2000-01-01T${fimDoExpediente}`);

                            // Se há um intervalo e o início selecionado é antes do intervalo,
                            // o limite de fim é o início do intervalo
                            if (horarioIntervaloInicio && inicioSelecionado < new Date(
                                    `2000-01-01T${horarioIntervaloInicio}`)) {
                                limiteFim = new Date(`2000-01-01T${horarioIntervaloInicio}`);
                            }

                            let atual = new Date(inicioSelecionado.getTime() + 30 *
                                60000); // 30 minutos após o início

                            while (atual <= limiteFim) {
                                let horaFormatada = atual.toTimeString().slice(0, 5);
                                let optionFim = document.createElement('option');
                                optionFim.value = horaFormatada;
                                optionFim.textContent = horaFormatada;
                                horarioFim.appendChild(optionFim);

                                atual.setMinutes(atual.getMinutes() + 30);
                            }
                        }

                        atualizarCalculo();
                    });

                    horarioFim.addEventListener('change', atualizarCalculo);

                    function atualizarCalculo() {
                        if (horarioInicio.value && horarioFim.value) {
                            const duracao = calcularDuracao(horarioInicio.value, horarioFim.value);
                            duracaoSpan.textContent = duracao.toFixed(2);
                            const total = (duracao * precoHora).toFixed(2);
                            const taxaAdicional = (parseFloat(total) * 0.03).toFixed(2);
                            const totalComTaxa = (parseFloat(total) + parseFloat(taxaAdicional)).toFixed(2);

                            totalPagarSpan.textContent = totalComTaxa;
                            taxaAdicionalSpan.textContent = taxaAdicional;

                            document.getElementById('valor_total').value = totalComTaxa;
                            btnReservar.disabled = false;
                        } else {
                            duracaoSpan.textContent = '0';
                            totalPagarSpan.textContent = '0';
                            taxaAdicionalSpan.textContent = '0';
                            document.getElementById('valor_total').value = '0';
                            btnReservar.disabled = true;
                        }
                    }

                    function calcularDuracao(inicio, fim) {
                        const [horaInicio, minInicio] = inicio.split(':').map(Number);
                        const [horaFim, minFim] = fim.split(':').map(Number);
                        return ((horaFim * 60 + minFim) - (horaInicio * 60 + minInicio)) / 60;
                    }

                    btnReservar.addEventListener('click', function(event) {
                        if (!dataReserva.value || !horarioInicio.value || !horarioFim.value) {
                            alert('Por favor, selecione uma data e horários válidos.');
                            event.preventDefault();
                        }
                    });
                });
                </script>


                <div>
                    <h2>Localização</h2>
                    <h2 id="container-info"><?php echo htmlspecialchars($quadra['localizacao']); ?> -
                        <?php echo htmlspecialchars($quadra['bairro']); ?>,
                        <?php echo htmlspecialchars($quadra['cep']); ?>
                </div>
                </h2>
            </div>
            <div id="map" style="width: 100%; height: 600px;"></div>

            <script
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuO6-uyUy4EvyjJnMiLynUXnrOZamCvmI&callback=initMap"
                async defer></script>
            <script>
            function initMap() {
                var searchQuery =
                    "<?php echo htmlspecialchars($quadra['nome_espaco'] . ' ' . $quadra['nome'] . ', ' . $quadra['localizacao'] . ' - ' . $quadra['cep']); ?>";
                var geocoder = new google.maps.Geocoder();

                var mapStyle = [{
                        "featureType": "all",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#f5f5f5"
                        }]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#ffffff"
                        }]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#c9c9c9"
                        }]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#e8e8e8"
                        }]
                    }
                ];

                geocoder.geocode({
                    'address': searchQuery
                }, function(results, status) {
                    if (status === 'OK') {
                        var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 19,
                            center: results[0].geometry.location,
                            styles: mapStyle,
                            zoomControl: true,
                            mapTypeControl: false,
                            scaleControl: true,
                            streetViewControl: false,
                            rotateControl: false,
                            fullscreenControl: true
                        });

                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location,
                            title: "<?php echo htmlspecialchars($quadra['nome_espaco'] . ' ' . $quadra['nome']); ?>"
                        });

                        // Adiciona um listener de clique no mapa para permitir ajuste manual
                        map.addListener('click', function(e) {
                            marker.setPosition(e.latLng);
                            map.panTo(e.latLng);
                        });

                        // Realizar geocodificação reversa para obter informações sobre o bairro
                        geocoder.geocode({
                            'location': results[0].geometry.location
                        }, function(results, status) {
                            if (status === 'OK') {
                                if (results[0]) {
                                    var addressComponents = results[0].address_components;
                                    var bairro = '';
                                    var cidade = '';

                                    for (var i = 0; i < addressComponents.length; i++) {
                                        var types = addressComponents[i].types;
                                        if (types.indexOf('sublocality_level_1') > -1) {
                                            bairro = addressComponents[i].long_name;
                                        }
                                        if (types.indexOf('administrative_area_level_2') > -1) {
                                            cidade = addressComponents[i].long_name;
                                        }
                                    }

                                    if (cidade === 'Belo Horizonte') {
                                        var regiao = mapearRegiaoBH(bairro);
                                        var locationInfo = document.getElementById('container-info');
                                        locationInfo.innerHTML += bairro + ', região ' + regiao;
                                    }
                                }
                            }
                        });

                    } else {
                        console.error('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }
            </script>
            <?php include '../layouts/footer.php'; ?>
</body>

</html>