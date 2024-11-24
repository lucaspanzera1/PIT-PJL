fetch('../../api/getReservasUsuarioData.php')
    .then(response => response.json())
    .then(data => {
        const labels = data.map(item => {
            // Limita o nome a 15 caracteres e adiciona ... se necessário
            const nome = item.nome_usuario;
            return nome.length > 15 ? nome.substring(0, 15) + '...' : nome;
        });
        const reservas = data.map(item => parseInt(item.total_reservas));
        
        // Cores personalizadas mais vibrantes
        const colors = [
            'rgba(255, 99, 132, 0.8)',   // Rosa
            'rgba(54, 162, 235, 0.8)',   // Azul
            'rgba(255, 206, 86, 0.8)',   // Amarelo
            'rgba(75, 192, 192, 0.8)',   // Verde-água
            'rgba(153, 102, 255, 0.8)'   // Roxo
        ];
        
        const borderColors = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)'
        ];

        const ctx = document.getElementById('usuariosChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Reservas',
                    data: reservas,
                    backgroundColor: colors,
                    borderColor: borderColors,
                    borderWidth: 2,
                    borderRadius: 10,
                    borderSkipped: false,
                    maxBarThickness: 80,
                    minBarLength: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 20,
                        right: 20,
                        bottom: 20,
                        left: 20
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart',
                    delay: (context) => context.dataIndex * 300
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.1)',
                            lineWidth: 0.5
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 12,
                                weight: '500'
                            },
                            callback: function(value) {
                                return Number.isInteger(value) ? value : null;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Top 5 Usuários com Mais Reservas',
                        color: '#2c3e50',
                        font: {
                            size: 20,
                            weight: 'bold',
                            family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif"
                        },
                        padding: {
                            top: 10,
                            bottom: 30
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#2c3e50',
                        bodyColor: '#2c3e50',
                        bodyFont: {
                            size: 14
                        },
                        borderColor: 'rgba(0, 0, 0, 0.1)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                const reservas = context.parsed.y;
                                return `${reservas} reserva${reservas !== 1 ? 's' : ''}`;
                            },
                            title: function(context) {
                                // Mostra o nome completo no tooltip
                                return data[context[0].dataIndex].nome_usuario;
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'nearest'
                }
            }
        });
    })
    .catch(error => console.error('Erro ao carregar dados:', error));