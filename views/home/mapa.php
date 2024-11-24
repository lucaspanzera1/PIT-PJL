<?php
require_once '../../models/Owner.php';
require_once '../../models/Client.php';
require_once '../../models/User.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa | ©
        2024 Arena Rental, Inc.</title>
    <link rel='shorcut icon' href="../../resources/images/favicon.png" type="image/x-icon">
</head>

<body>
    <?php include '../layouts/header.php'; ?>
    <div id="map" style="width: 100vw; height: 100vh;"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuO6-uyUy4EvyjJnMiLynUXnrOZamCvmI&callback=initMap"
        async defer></script>
    <script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: {
                lat: -19.9167,
                lng: -43.9333
            }, // Coordenadas de Belo Horizonte
            styles: [{
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [{
                        visibility: "off"
                    }] // Oculta os pontos de interesse
                },
                {
                    featureType: "transit",
                    elementType: "labels",
                    stylers: [{
                        visibility: "off"
                    }] // Oculta os pontos de transporte
                }
            ],
            mapTypeControl: false,
            zoomControl: false
        });

        // Buscar todas as quadras do sistema
        var quadras = <?php echo json_encode(User::getMapaQuadras()); ?>;

        // Caminho para o ícone personalizado
        var customIcon = {
            url: '../../resources/images/pin2.png', // Substitua pelo caminho do seu ícone
            scaledSize: new google.maps.Size(25, 42) // Tamanho personalizado
        };

        // Criar marcadores para cada quadra
        quadras.forEach(function(quadra) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'address': `${quadra.nome_espaco}, ${quadra.localizacao}, ${quadra.cep}`
            }, function(results, status) {
                if (status === 'OK') {
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        title: quadra.nome_espaco,
                        icon: customIcon // Aplicar o ícone personalizado
                    });

                    // Adicionar janela de informações ao marcador
                    var infoWindow = new google.maps.InfoWindow({
                        content: `
                            <div class="card">
                                <img src="../${quadra.imagem_quadra}" alt="${quadra.nome_espaco}" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">${quadra.nome_espaco}</h5>
                                    <p class="card-text">
                                        Localização: ${quadra.localizacao}<br>
                                        CEP: ${quadra.cep}<br>
                                        Bairro: ${quadra.bairro}<br>
                                        Região: ${quadra.regiao}
                                    </p>
                                </div>
                            </div>
                        `
                    });
                    marker.addListener('click', function() {
                        infoWindow.open(map, marker);
                    });
                } else {
                    console.error('Geocodificação não obteve sucesso devido a: ' + status);
                }
            });
        });
    }
    </script>
</body>

</html>
<style>
body {
    padding: 0;
    margin: 0;
}

.card-img-top {
    width: 300px;
    height: 200px;
    object-fit: cover;
}

header {
    z-index: 3;
    position: absolute;
    background-color: transparent;
}
</style>