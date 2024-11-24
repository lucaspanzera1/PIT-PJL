let chartInstance = null;

// Função para mostrar loading
function showLoading() {
    document.getElementById('loadingIndicator').style.display = 'flex';
}

// Função para esconder loading
function hideLoading() {
    document.getElementById('loadingIndicator').style.display = 'none';
}

// Função para atualizar estatísticas
function atualizarEstatisticas(data) {
    const totalReservas = data.reduce((sum, item) => sum + parseInt(item.total_reservas), 0);
    const horarioMaisPopular = data.reduce((prev, current) => 
        parseInt(current.total_reservas) > parseInt(prev.total_reservas) ? current : prev
    );
    const mediaDia = (totalReservas / data.length).toFixed(1);

    document.getElementById('totalReservas').textContent = totalReservas;
    document.getElementById('horarioPopular').textContent = `${horarioMaisPopular.horario}h`;
    document.getElementById('mediaDia').textContent = mediaDia;
}

// Função para inicializar os filtros
function initializeFiltros() {
    const tipoVisualizacao = document.getElementById('tipoVisualizacao');
    const mesContainer = document.getElementById('mesContainer');
    const semanaContainer = document.getElementById('semanaContainer');
    const mesSelecionado = document.getElementById('mesSelecionado');
    const semanaSelecionada = document.getElementById('semanaSelecionada');

    tipoVisualizacao.addEventListener('change', function() {
        mesContainer.style.display = this.value === 'mes' || this.value === 'semana' ? 'block' : 'none';
        semanaContainer.style.display = this.value === 'semana' ? 'block' : 'none';
        
        // Animação suave
        mesContainer.style.animation = 'fadeIn 0.3s ease-in-out';
        semanaContainer.style.animation = 'fadeIn 0.3s ease-in-out';
        
        atualizarGrafico();
    });

    mesSelecionado.addEventListener('change', function() {
        if (tipoVisualizacao.value === 'semana') {
            atualizarSemanas();
        }
        atualizarGrafico();
    });

    semanaSelecionada.addEventListener('change', atualizarGrafico);

    // Inicializar com visualização anual
    atualizarGrafico();
}

// Função para atualizar o gráfico
function atualizarGrafico() {
    showLoading();
    
    const tipoVisualizacao = document.getElementById('tipoVisualizacao').value;
    const mes = document.getElementById('mesSelecionado').value;
    const semana = document.getElementById('semanaSelecionada').value;

    const params = new URLSearchParams({
        tipo: tipoVisualizacao,
        mes: mes,
        semana: semana
    });

    fetch(`../../api/getHorariosData.php?${params}`)
        .then(response => response.json())
        .then(data => {
            if (chartInstance) {
                chartInstance.destroy();
            }

            const ctx = document.getElementById('horariosChart').getContext('2d');
            
            // Gradiente para o background
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(255, 165, 0, 0.2)');
            gradient.addColorStop(1, 'rgba(255, 165, 0, 0)');

            chartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(item => `${item.horario}h`),
                    datasets: [{
                        label: 'Reservas',
                        data: data.map(item => parseInt(item.total_reservas)),
                        backgroundColor: gradient,
                        borderColor: 'rgb(255, 165, 0)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 6,
                        pointBackgroundColor: 'rgb(255, 165, 0)',
                        pointBorderColor: 'white',
                        pointBorderWidth: 2,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: 'rgb(255, 165, 0)',
                        pointHoverBorderColor: 'white',
                        pointHoverBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Número de Reservas',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                    return Number.isInteger(value) ? value : null;
                                }
                            },
                            grid: {
                                color: 'rgba(255, 165, 0, 0.05)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Horário',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: getTituloGrafico(tipoVisualizacao, mes, semana),
                            font: {
                                size: 18,
                                weight: 'bold'
                            },
                            padding: 20
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 165, 0, 0.9)',
                            titleColor: '#000',
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyColor: '#666',
                            bodyFont: {
                                size: 13
                            },
                            borderColor: 'rgba(255, 165, 0, 0.1)',
                            borderWidth: 1,
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    const reservas = context.parsed.y;
                                    return `${reservas} reserva${reservas !== 1 ? 's' : ''}`;
                                }
                            }
                        },
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Atualizar estatísticas
            atualizarEstatisticas(data);
            hideLoading();
        })
        .catch(error => {
            console.error('Erro ao carregar dados:', error);
            hideLoading();
        });
}

// Função para gerar o título do gráfico
function getTituloGrafico(tipo, mes, semana) {
    const meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 
                   'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    
    if (tipo === 'ano') {
        return 'Distribuição de Reservas por Horário - Ano Inteiro';
    } else if (tipo === 'mes') {
        return `Distribuição de Reservas por Horário - ${meses[mes - 1]}`;
    } else {
        return `Distribuição de Reservas por Horário - ${meses[mes - 1]} - Semana ${semana}`;
    }
}

// Inicializar os filtros quando o documento estiver pronto
document.addEventListener('DOMContentLoaded', initializeFiltros);