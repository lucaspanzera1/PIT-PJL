document.addEventListener('DOMContentLoaded', function() {
    // Preencher anos no select (do ano atual até 3 anos atrás)
    const anoSelect = document.getElementById('anoSelect');
    const anoAtual = new Date().getFullYear();
    for (let ano = anoAtual; ano >= anoAtual - 3; ano--) {
        const option = document.createElement('option');
        option.value = ano;
        option.textContent = ano;
        anoSelect.appendChild(option);
    }

    let chartInstance = null;

    function carregarDados(mes = '', ano = '') {
        // Mostrar indicador de carregamento
        document.getElementById('siteTotalValue').textContent = 'Carregando...';
        document.getElementById('offSiteTotalValue').textContent = 'Carregando...';
        document.getElementById('totalAmount').textContent = 'Carregando...';

        const url = new URL('../../api/getReservasTotais.php', window.location.href);
        if (mes) url.searchParams.append('mes', mes);
        if (ano) url.searchParams.append('ano', ano);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (chartInstance) {
                    chartInstance.destroy();
                }
                atualizarGrafico(data);
            })
            .catch(error => {
                console.error('Erro ao carregar dados:', error);
                // Mostrar mensagem de erro nos elementos
                document.getElementById('siteTotalValue').textContent = 'Erro ao carregar';
                document.getElementById('offSiteTotalValue').textContent = 'Erro ao carregar';
                document.getElementById('totalAmount').textContent = 'Erro ao carregar dados';
            });
    }

    function atualizarGrafico(data) {
        const ctx = document.getElementById('distribuicaoChart').getContext('2d');
        
        const labels = ['Pelo Site', 'Fora do Site'];
        const valores = [
            parseFloat(data.find(item => item.tipo_reserva === 'Pelo Site')?.valor_total || 0),
            parseFloat(data.find(item => item.tipo_reserva === 'Fora do Site')?.valor_total || 0)
        ];
        
        // Calcular valor total
        const valorTotal = valores.reduce((a, b) => a + b, 0);
        
        // Função para formatar moeda
        const formatarMoeda = (valor) => {
            return valor.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
        };

        // Atualizar cards
        document.getElementById('siteTotalValue').textContent = formatarMoeda(valores[0]);
        document.getElementById('offSiteTotalValue').textContent = formatarMoeda(valores[1]);
        document.getElementById('totalAmount').textContent = formatarMoeda(valorTotal);

        // Calcular percentuais para o subtítulo
        const percentualSite = ((valores[0] / valorTotal) * 100) || 0;
        const percentualForaSite = ((valores[1] / valorTotal) * 100) || 0;

        chartInstance = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: valores,
                    backgroundColor: [
                        'rgba(255, 165, 0, 0.8)',  // Azul para reservas pelo site
                        'rgba(184, 121, 5, 0.8)'   // Rosa para reservas fora do site
                    ],
                    borderColor: [
                        'rgba(255, 165, 0, 1)',
                        'rgba(184, 121, 5, 1)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: ['Distribuição de Valores em Reservas', 
                              `Site: ${percentualSite.toFixed(1)}% | Fora do Site: ${percentualForaSite.toFixed(1)}%`],
                        font: {
                            size: 20,
                            weight: 'bold'
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    },
                    subtitle: {
                        display: true,
                        text: getMesAnoText(),
                        font: {
                            size: 16,
                            weight: 'normal'
                        },
                        padding: {
                            bottom: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const valor = context.raw.toLocaleString('pt-BR', {
                                    style: 'currency',
                                    currency: 'BRL'
                                });
                                const porcentagem = ((context.raw / valorTotal) * 100).toFixed(1);
                                return `${context.label}: ${valor} (${porcentagem}%)`;
                            }
                        },
                        padding: 12,
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#2c3e50',
                        bodyColor: '#2c3e50',
                        borderColor: '#e9ecef',
                        borderWidth: 1,
                        displayColors: true,
                        boxWidth: 10,
                        boxHeight: 10,
                        usePointStyle: true
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 14
                            },
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map((label, i) => {
                                        const value = data.datasets[0].data[i];
                                        const percentage = ((value / valorTotal) * 100).toFixed(1);
                                        return {
                                            text: `${label} (${formatarMoeda(value)} - ${percentage}%)`,
                                            fillStyle: data.datasets[0].backgroundColor[i],
                                            strokeStyle: data.datasets[0].borderColor[i],
                                            lineWidth: data.datasets[0].borderWidth,
                                            hidden: isNaN(data.datasets[0].data[i]) || data.datasets[0].data[i] === 0,
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 2000
                }
            }
        });
    }

    function getMesAnoText() {
        const mes = document.getElementById('mesSelect').value;
        const ano = document.getElementById('anoSelect').value;
        
        const meses = {
            '1': 'Janeiro', '2': 'Fevereiro', '3': 'Março', '4': 'Abril',
            '5': 'Maio', '6': 'Junho', '7': 'Julho', '8': 'Agosto',
            '9': 'Setembro', '10': 'Outubro', '11': 'Novembro', '12': 'Dezembro'
        };

        if (mes && ano) {
            return `${meses[mes]} de ${ano}`;
        } else if (ano) {
            return `Ano de ${ano}`;
        } else if (mes) {
            return `${meses[mes]} (Todos os Anos)`;
        }
        return 'Todos os Períodos';
    }

    // Event listeners para os filtros
    document.getElementById('mesSelect').addEventListener('change', function() {
        const mes = this.value;
        const ano = document.getElementById('anoSelect').value;
        carregarDados(mes, ano);
    });

    document.getElementById('anoSelect').addEventListener('change', function() {
        const mes = document.getElementById('mesSelect').value;
        const ano = this.value;
        carregarDados(mes, ano);
    });

    // Carregar dados iniciais
    carregarDados();
});