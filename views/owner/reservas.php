<?php
// Recuperar a data passada pela URL, ou usar a data atual como padrão
$dataHoje = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');

// Converter a data do formato yyyy-mm-dd para dd/mm/yyyy
$dataFormatada = date('d/m/Y', strtotime($dataHoje));
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas para <?php echo $dataFormatada ?> | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel='shorcut icon' href="../../resources/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../resources/css/hoje.css?v=<?= time() ?>">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script>
    function obterDataDaURL() {
        const urlParams = new URLSearchParams(window.location.search);
        const dataUrl = urlParams.get('data');

        if (dataUrl) {
            const [ano, mes, dia] = dataUrl.split('-');
            return `${dia}/${mes}/${ano}`; // Formato dd/mm/yyyy
        } else {
            const diasSemana = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira',
                'Sexta-feira', 'Sábado'
            ];
            const dataAtual = new Date();
            const diaSemana = diasSemana[dataAtual.getDay()];
            const dia = String(dataAtual.getDate()).padStart(2, '0');
            const mes = String(dataAtual.getMonth() + 1).padStart(2, '0');
            const ano = dataAtual.getFullYear();
            return `${diaSemana}, ${dia}/${mes}/${ano}`; // Formato dd/mm/yyyy
        }
    }

    window.onload = function() {
        document.getElementById('dataHoje').textContent = obterDataDaURL();
    }
    </script>
</head>

<body>

    <?php include '../layouts/header.quadra.php'; ?>
    <?php include '../layouts/verification.php'; ?>

    <section>
        <div id="Info">
            <?php include '../layouts/mensagem.php'; ?>
            <h1><?php echo htmlspecialchars($owner->getNomeEspaco()) ?> <?php echo htmlspecialchars($quadra['nome']); ?>
            </h1>
            <h2>Reservas para <?php echo isset($dataFormatada) ? htmlspecialchars($dataFormatada) : 'hoje'; ?>.</h2>

            <div class="modal-overlay" id="modalOverlay"></div>
            <div class="modal-reserva" id="modalReserva">
                <div class="modal-header">
                    <h2 class="modal-title">Nova Reserva</h2>
                    <button type="button" class="close-button" onclick="fecharModal()">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M18 6L6 18M6 6l12 12" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>
                </div>
                <form id="formReserva" method="POST" action="../../controllers/OwnerController.php?action=reservar">
                    <input type="hidden" name="action" value="reservar">
                    <input type="hidden" id="quadra_id" name="quadra_id">
                    <input type="hidden" id="data" name="data">

                    <div class="form-group">
                        <label for="nome_cliente">Nome do Cliente</label>
                        <input type="text" id="nome_cliente" name="nome_cliente" required>
                        <div class="input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M12 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"
                                    stroke-width="2" />
                            </svg>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="horario_inicio">Horário de Início</label>
                        <input type="time" id="horario_inicio" name="horario_inicio" required>
                        <div class="input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="12" cy="12" r="10" stroke-width="2" />
                                <path d="M12 6v6l4 2" stroke-width="2" />
                            </svg>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="horario_fim">Horário de Fim</label>
                        <input type="time" id="horario_fim" name="horario_fim" required>
                        <div class="input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="12" cy="12" r="10" stroke-width="2" />
                                <path d="M12 6v6l4 2" stroke-width="2" />
                            </svg>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="valor">Valor da Reserva (R$)</label>
                        <input type="number" id="valor" name="valor" step="0.01" required>
                        <div class="input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" stroke-width="2" />
                            </svg>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="fecharModal()">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Confirmar Reserva</button>
                    </div>
                </form>
            </div>

            <?php
// Agora usar $dataHoje para buscar os horários no banco de dados
$quadraId = $quadra['id']; // Certifique-se de que $quadra['id'] está definido corretamente

// Chame a função que busca os horários disponíveis
$dataHoje = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');
$horarios = Owner::getHorariosDisponiveis($quadraId, $dataHoje);
 if (isset($horarios) && !empty($horarios)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Horário Início</th>
                        <th>Horário Fim</th>
                        <th>Status</th>
                        <th>Cliente</th>
                        <th>
                            Valor
                            <span class="eye-icon" onclick="toggleValueVisibility()" title="Mostrar/Ocultar valores">
                                <svg width="41" height="72" viewBox="0 0 41 72" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21.92 31.6C12.84 29.24 9.92 26.8 9.92 23C9.92 18.64 13.96 15.6 20.72 15.6C27.84 15.6 30.48 19 30.72 24H39.56C39.28 17.12 35.08 10.8 26.72 8.76V0H14.72V8.64C6.96 10.32 0.719999 15.36 0.719999 23.08C0.719999 32.32 8.36 36.92 19.52 39.6C29.52 42 31.52 45.52 31.52 49.24C31.52 52 29.56 56.4 20.72 56.4C12.48 56.4 9.24 52.72 8.8 48H0C0.48 56.76 7.04 61.68 14.72 63.32V72H26.72V63.4C34.52 61.92 40.72 57.4 40.72 49.2C40.72 37.84 31 33.96 21.92 31.6Z"
                                        fill="black" />
                                </svg>
                            </span>
                        </th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($horarios as $horario): ?>
                    <tr class="<?php 
                if ($horario['status'] == 'pendente') {
                    echo 'pendente';
                } elseif ($horario['status'] == 'reservado') {
                    echo 'reservado';
                }
            ?>">
                        <td><?php echo htmlspecialchars($horario['horario_inicio']); ?></td>
                        <td><?php echo htmlspecialchars($horario['horario_fim']); ?></td>
                        <td><?php echo htmlspecialchars($horario['status']); ?></td>
                        <td><?php echo !empty($horario['username_cliente']) ? htmlspecialchars($horario['nome_cliente']) : '-'; ?>
                        </td>
                        <td class="valor-cell">
                            <?php echo isset($horario['valor_reserva']) ? 'R$ ' . number_format($horario['valor_reserva'], 2, ',', '.') : '-'; ?>
                        </td>
                        <td>
                            <?php if ($horario['status'] == 'disponível'): ?>
                            <form id="meuFormulario">
                                <input type="hidden" name="quadra_id"
                                    value="<?php echo htmlspecialchars($quadra['id']); ?>">
                                <input type="hidden" name="data" value="<?php echo $dataHoje; ?>">
                                <input type="hidden" name="horario_inicio"
                                    value="<?php echo $horario['horario_inicio']; ?>">
                                <input type="hidden" name="horario_fim" value="<?php echo $horario['horario_fim']; ?>">

                                <select name="acao" required onchange="handleAcaoChange(this.value)">
                                    <option value="">Selecione uma ação</option>
                                    <option value="intervalo">Intervalo</option>
                                    <option value="reservar">Reservar por fora</option>
                                </select>

                                <button type="submit">Confirmar</button>
                            </form>
                            <?php elseif ($horario['status'] == 'pendente'): ?>
                            <form method="POST"
                                action="../../controllers/OwnerController.php?action=confirmarReserva&origem=hoje"
                                style="display: inline-block;">
                                <input type="hidden" name="reserva_id" value="<?php echo $horario['reserva_id']; ?>">
                                <input type="hidden" name="redirect_url"
                                    value="<?php echo urlencode('../views/owner/reservas.php?id=' . $quadra['id'] . '&data=' . $dataHoje); ?>">
                                <button type="submit">Confirmar</button>
                            </form>

                            <form onsubmit="return confirmarCancelamento(event, <?= $horario['reserva_id']; ?>)">
                                <input type="hidden" name="reserva_id" value="<?= $horario['reserva_id']; ?>">
                                <input type="hidden" name="redirect_url"
                                    value="<?php echo urlencode('../views/owner/reservas.php?id=' . $quadra['id'] . '&data=' . $dataHoje); ?>">
                                <button type="submit" class="btn-cancelar">Cancelar</button>
                            </form>

                        </td>

                        <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>Não há horários disponíveis para hoje.</p>
            <?php endif; ?>
        </div>
    </section>

</body>

</html>
<script>
function confirmarCancelamento(event, reservaId) {
    event.preventDefault();

    Swal.fire({
        title: 'Tem certeza?',
        text: "Você não poderá reverter isso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, cancelar!',
        cancelButtonText: 'Não'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../../controllers/OwnerController.php?action=cancelarReserva&origem=hoje';

            const inputReserva = document.createElement('input');
            inputReserva.type = 'hidden';
            inputReserva.name = 'reserva_id';
            inputReserva.value = reservaId;

            const inputRedirect = document.createElement('input');
            inputRedirect.type = 'hidden';
            inputRedirect.name = 'redirect_url';
            const originalRedirectUrl = document.querySelector(
                `form input[name="redirect_url"][value*="reservas.php"]`).value;
            inputRedirect.value = originalRedirectUrl;

            form.appendChild(inputReserva);
            form.appendChild(inputRedirect);
            document.body.appendChild(form);
            form.submit();
        }
    });

    return false;
}


document.getElementById('formReserva').addEventListener('submit', function(e) {
    e.preventDefault();

    const horarioInicio = document.getElementById('horario_inicio').value;
    const horarioFim = document.getElementById('horario_fim').value;
    const valor = document.getElementById('valor').value;
    const nomeCliente = document.getElementById('nome_cliente').value;

    // Validações básicas
    if (!nomeCliente.trim()) {
        alert('Por favor, insira o nome do cliente');
        return;
    }

    if (!horarioInicio || !horarioFim) {
        alert('Por favor, selecione os horários de início e fim');
        return;
    }

    if (horarioInicio >= horarioFim) {
        alert('O horário de início deve ser menor que o horário de fim');
        return;
    }

    if (!valor || valor <= 0) {
        alert('Por favor, insira um valor válido para a reserva');
        return;
    }

    // Se passou por todas as validações, envia o formulário
    this.submit();
});

function abrirModal(quadraId, data, horarioInicio, horarioFim) {
    const overlay = document.getElementById('modalOverlay');
    const modal = document.getElementById('modalReserva');

    overlay.style.display = 'block';
    modal.style.display = 'block';

    // Força um reflow para garantir que a transição funcione
    modal.offsetHeight;

    overlay.classList.add('active');
    modal.classList.add('active');

    // Preenche os campos hidden
    document.getElementById('quadra_id').value = quadraId;
    document.getElementById('data').value = data;
    document.getElementById('horario_inicio').value = horarioInicio;
    document.getElementById('horario_fim').value = horarioFim;

    // Previne scroll do body
    document.body.style.overflow = 'hidden';

    // Foca no primeiro campo
    document.getElementById('nome_cliente').focus();
}

function fecharModal() {
    const overlay = document.getElementById('modalOverlay');
    const modal = document.getElementById('modalReserva');

    overlay.classList.remove('active');
    modal.classList.remove('active');

    // Aguarda o fim da animação antes de esconder
    setTimeout(() => {
        overlay.style.display = 'none';
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('formReserva').reset();
    }, 300);
}

// Validação do formulário
document.getElementById('formReserva').addEventListener('submit', function(e) {
    const campos = ['nome_cliente', 'horario_inicio', 'horario_fim', 'valor'];
    let valido = true;

    campos.forEach(campo => {
        const input = document.getElementById(campo);
        if (!input.value.trim()) {
            input.parentElement.classList.add('shake');
            setTimeout(() => input.parentElement.classList.remove('shake'), 300);
            valido = false;
        }
    });

    if (!valido) {
        e.preventDefault();
    }
});

// Fecha o modal ao clicar no overlay
document.getElementById('modalOverlay').addEventListener('click', fecharModal);

// Previne o fechamento ao clicar no modal
document.getElementById('modalReserva').addEventListener('click', function(e) {
    e.stopPropagation();
});

// Fecha o modal com a tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        fecharModal();
    }
});

// Função atualizada para enviar os dados para o controller
function submitReserva(event) {
    event.preventDefault();

    // Coleta os dados do formulário
    const formData = new FormData(document.getElementById('formReserva'));
    formData.append('action', 'reservar'); // Adiciona a action

    // Envia a requisição para o OwnerController
    fetch('../../controllers/OwnerController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na requisição');
            }
            return response.text();
        })
        .then(data => {
            console.log('Resposta:', data); // Para debug
            fecharModal();
            window.location.reload(); // Recarrega a página para mostrar a mensagem
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao realizar a reserva. Por favor, tente novamente.');
        });
}

// Atualiza a função handleAcaoChange do seu formulário original
function handleAcaoChange(valor) {
    const form = document.getElementById('meuFormulario');
    const quadraId = form.querySelector('[name="quadra_id"]').value;
    const data = form.querySelector('[name="data"]').value;
    const horarioInicio = form.querySelector('[name="horario_inicio"]').value;
    const horarioFim = form.querySelector('[name="horario_fim"]').value;

    if (valor === 'reservar') {
        // Previne o envio padrão do formulário e abre o modal
        form.onsubmit = function(e) {
            e.preventDefault();
            abrirModal(quadraId, data, horarioInicio, horarioFim);
        };
    } else if (valor === 'intervalo') {
        form.action = '../../controllers/OwnerController.php?action=intervalo';
        form.method = 'POST';
        form.onsubmit = null;
    }
}

// Fecha o modal se clicar fora
document.getElementById('modalOverlay').addEventListener('click', function(event) {
    if (event.target === this) {
        fecharModal();
    }
});

// Previne que o modal feche se clicar dentro dele
document.getElementById('modalReserva').addEventListener('click', function(event) {
    event.stopPropagation();
});

let valuesVisible = true;

function toggleValueVisibility() {
    valuesVisible = !valuesVisible;
    const valuesCells = document.querySelectorAll('.valor-cell');
    const eyeIcon = document.querySelector('.eye-icon');

    valuesCells.forEach(cell => {
        if (valuesVisible) {
            cell.classList.remove('value-hidden');
            eyeIcon.innerHTML = `
            <svg width="41" height="72" viewBox="0 0 41 72" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M21.92 31.6C12.84 29.24 9.92 26.8 9.92 23C9.92 18.64 13.96 15.6 20.72 15.6C27.84 15.6 30.48 19 30.72 24H39.56C39.28 17.12 35.08 10.8 26.72 8.76V0H14.72V8.64C6.96 10.32 0.719999 15.36 0.719999 23.08C0.719999 32.32 8.36 36.92 19.52 39.6C29.52 42 31.52 45.52 31.52 49.24C31.52 52 29.56 56.4 20.72 56.4C12.48 56.4 9.24 52.72 8.8 48H0C0.48 56.76 7.04 61.68 14.72 63.32V72H26.72V63.4C34.52 61.92 40.72 57.4 40.72 49.2C40.72 37.84 31 33.96 21.92 31.6Z" fill="black"/>
</svg>`;
            eyeIcon.title = 'Ocultar valores';
        } else {
            cell.classList.add('value-hidden');
            eyeIcon.innerHTML = `
            <svg width="64" height="72" viewBox="0 0 64 72" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M33.76 15.6C40.88 15.6 43.52 19 43.76 24H52.6C52.32 17.12 48.12 10.8 39.76 8.76V0H27.76V8.64C25.64 9.12 23.64 9.84 21.84 10.8L27.72 16.68C29.36 16 31.36 15.6 33.76 15.6ZM5.08 4.24L0 9.32L13.76 23.08C13.76 31.4 20 35.92 29.4 38.72L43.44 52.76C42.08 54.68 39.24 56.4 33.76 56.4C25.52 56.4 22.28 52.72 21.84 48H13.04C13.52 56.76 20.08 61.68 27.76 63.32V72H39.76V63.4C43.6 62.68 47.04 61.2 49.56 58.92L58.44 67.8L63.52 62.72L5.08 4.24Z" fill="black"/>
</svg>
`;
            eyeIcon.title = 'Mostrar valores';
        }
    });
}
</script>