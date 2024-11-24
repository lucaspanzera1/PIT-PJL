let ocupacaoChart;

function formatarData(data) {
    const options = { year: 'numeric', month: 'long' };
    return new Date(data).toLocaleDateString('pt-BR', options);
}

function getGradientColor(ctx) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(255, 165, 0, 0.8)');
    gradient.addColorStop(1, 'rgba(255, 165, 0, 0.2)');
    return gradient;
}

function inicializarGrafico(labels, ocupacao, periodo) {
    const ctx = document.getElementById('ocupacaoChart').getContext('2d');
    
    if (ocupacaoChart) {
        ocupacaoChart.destroy();
    }
    
    let titulo = 'Ocupação por Dia da Semana';
    if (periodo === 'mes') {
        titulo += ` - ${formatarData(document.getElementById('dataInicio').value)}`;
    } else if (periodo === 'ano') {
        titulo += ' - Ano Inteiro';
    }

    // Encontrar o valor máximo para definir o stepSize
    const maxValue = Math.max(...ocupacao);
    const stepSize = maxValue <= 10 ? 1 : Math.ceil(maxValue / 10);
    
    ocupacaoChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: titulo,
                data: ocupacao,
                backgroundColor: getGradientColor(ctx),
                borderColor: 'rgba(255, 165, 0, 1)',
                borderWidth: 2,
                borderRadius: 8,
                barPercentage: 0.7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            size: 14,
                            family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif"
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#2c3e50',
                    bodyColor: '#2c3e50',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    padding: 12,
                    borderColor: 'rgba(74, 144, 226, 0.3)',
                    borderWidth: 1,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return `${context.parsed.y} reservas`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: stepSize,
                        font: {
                            size: 12
                        },
                        callback: function(value) {
                            return Number.isInteger(value) ? value : null;
                        }
                    },
                    title: {
                        display: true,
                        text: 'Número de Reservas',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
}

function carregarDados() {
    const periodo = document.getElementById('periodoFiltro').value;
    let dataInicio = document.getElementById('dataInicio').value;
    let dataFim = document.getElementById('dataFim').value;
    
    // Se nenhuma data for selecionada, use o ano inteiro
    if (!dataInicio || !dataFim) {
        const hoje = new Date();
        dataInicio = `${hoje.getFullYear()}-01-01`;
        dataFim = `${hoje.getFullYear()}-12-31`;
        
        // Atualiza os campos de data
        document.getElementById('dataInicio').value = dataInicio;
        document.getElementById('dataFim').value = dataFim;
    }
    
    const url = `../../api/getWeeklyData.php?periodo=${periodo}&dataInicio=${dataInicio}&dataFim=${dataFim}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const diasDaSemana = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
            const ocupacaoMap = diasDaSemana.reduce((acc, dia) => {
                acc[dia] = 0;
                return acc;
            }, {});
            
            data.forEach(item => {
                ocupacaoMap[item.dia_da_semana] = item.ocupacao;
            });
            
            const labels = Object.keys(ocupacaoMap);
            const ocupacao = Object.values(ocupacaoMap);
            
            inicializarGrafico(labels, ocupacao, periodo);
        })
        .catch(error => console.error('Erro ao carregar dados:', error));
}

// Configura a data inicial como início do ano atual
window.addEventListener('DOMContentLoaded', () => {
    const hoje = new Date();
    const inicioAno = `${hoje.getFullYear()}-01-01`;
    const fimAno = `${hoje.getFullYear()}-12-31`;
    
    document.getElementById('dataInicio').value = inicioAno;
    document.getElementById('dataFim').value = fimAno;
    
    carregarDados();
});

// Event Listeners
document.getElementById('periodoFiltro').addEventListener('change', carregarDados);
document.getElementById('aplicarFiltro').addEventListener('click', carregarDados);
document.getElementById('dataInicio').addEventListener('change', carregarDados);
document.getElementById('dataFim').addEventListener('change', carregarDados);