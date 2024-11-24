document.addEventListener('DOMContentLoaded', function() {
    const ordenacaoSelect = document.getElementById('ordenacao');
    const reservasContainer = document.getElementById('reservas-container');

    function ordenarReservas(ordem) {
        const reservas = Array.from(document.querySelectorAll('.reserva-container'));
        
        reservas.sort((a, b) => {
            const dataA = new Date(a.dataset.date);
            const dataB = new Date(b.dataset.date);
            
            return ordem === 'recente' ? dataB - dataA : dataA - dataB;
        });

        // Limpa o container
        while (reservasContainer.firstChild) {
            reservasContainer.removeChild(reservasContainer.firstChild);
        }

        // Adiciona os elementos ordenados
        reservas.forEach(reserva => {
            reservasContainer.appendChild(reserva);
        });
    }

    ordenacaoSelect.addEventListener('change', function() {
        ordenarReservas(this.value);
    });

    // Funcionalidade de toggle das tabelas
    document.querySelectorAll('.data-titulo').forEach(function(dataTitulo) {
        var tabelaId = dataTitulo.getAttribute('data-id');
        var tabela = document.getElementById(tabelaId);

        // Inicializa as tabelas como visíveis e as setas rotacionadas para baixo
        dataTitulo.classList.add('open'); 
        tabela.classList.add('visivel');

        dataTitulo.addEventListener('click', function() {
            if (tabela.classList.contains('visivel')) {
                tabela.classList.remove('visivel');
                tabela.style.display = "none";
                dataTitulo.classList.remove('open');
                dataTitulo.classList.add('closed');
            } else {
                tabela.classList.add('visivel');
                tabela.style.display = "block";
                dataTitulo.classList.remove('closed');
                dataTitulo.classList.add('open');
            }
        });
    });
});

function confirmarCancelamento(event, reservaId) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você realmente deseja cancelar esta reserva?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, cancelar!',
        cancelButtonText: 'Não, manter',
        customClass: {
            popup: 'swal-wide',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../../controllers/ClientController.php?action=cancelarReserva';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'reserva_id';
            input.value = reservaId;
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    });
    
    return false;
}