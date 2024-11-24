<?php
require_once '../../models/Owner.php';
require_once '../../models/Client.php';
require_once '../../models/User.php';

session_start(); // Iniciar sessão

if (isset($_SESSION['mensagem'])):
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']); // Remove a mensagem para evitar repetição ao recarregar a página
endif;

if (isset($_SESSION['mensagem1'])):
    $mensagem1 = $_SESSION['mensagem1'];
    unset($_SESSION['mensagem1']); // Remove a mensagem para evitar repetição ao recarregar a página
endif;


// Verifica se há um erro armazenado na sessão (se necessário)
if (isset($_SESSION['erro'])):
    $erro = $_SESSION['erro'];
    unset($_SESSION['erro']); // Remove o erro para evitar repetição ao recarregar a página
endif;

// Verifique se há dados de cliente na sessão
if (isset($_SESSION['client'])) {
    // Crie uma instância da classe Client com os dados da sessão
    $client = new Client(
        $_SESSION['client']['id'],
        $_SESSION['client']['nome'],
        $_SESSION['client']['email'],
        $_SESSION['client']['tipo'],
        $_SESSION['client']['data_registro']
    );

    // Formatar a data de registro
    $dataRegistro = $_SESSION['client']['data_registro'];
    $dataFormatoBrasileiro = date('d/m/Y', strtotime($dataRegistro));

    // Verifique se o cliente é do tipo "Dono"
    if ($client->getType() === 'Dono') {
        // Carregue as informações do proprietário usando o ID do cliente
        $owner = Owner::getOwnerById($client->getId());
    }
    // Verifique se o botão de logoff foi pressionado
    if (isset($_POST['logoff'])) {
        $client->logoff(); // Chame a função de logoff
    }
    // Exiba o nome do cliente
    //echo "Bem-vindo, " . htmlspecialchars($_SESSION['client']['nome']) . "!";
} else {
    //echo "Bem-vindo!";
}

?>
<link rel="stylesheet" href="../../resources/css/header.css?v=<?= time() ?>">
<link rel="stylesheet" href="../../resources/css/notifications.css?v=<?= time() ?>">
<script src="../../resources/js/notifications.js"></script>
<script>
console.log('Session ID:', <?php echo json_encode($_SESSION['user_id'] ?? null); ?>);
</script>
<script>
console.log('Header carregado');
</script>
<header>
    <div>
        <a href="../home/index.php">
            <h2 id="imgH2"></h2>
        </a>
        <h1></h1>
    </div>

    <div>
        <?php if (isset($_SESSION['client'])): ?>
        <div class="notifications-wrapper">
            <button class="notifications-toggle">
                <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M28.1313 25.2146L26.25 23.3333V16.0416C26.25 11.5646 23.8583 7.81665 19.6875 6.82498V5.83331C19.6875 4.6229 18.7104 3.64581 17.5 3.64581C16.2896 3.64581 15.3125 4.6229 15.3125 5.83331V6.82498C11.1271 7.81665 8.75001 11.55 8.75001 16.0416V23.3333L6.86876 25.2146C5.95001 26.1333 6.59168 27.7083 7.8896 27.7083H27.0958C28.4083 27.7083 29.05 26.1333 28.1313 25.2146ZM23.3333 24.7916H11.6667V16.0416C11.6667 12.425 13.8688 9.47915 17.5 9.47915C21.1313 9.47915 23.3333 12.425 23.3333 16.0416V24.7916ZM17.5 32.0833C19.1042 32.0833 20.4167 30.7708 20.4167 29.1666H14.5833C14.5833 30.7708 15.8813 32.0833 17.5 32.0833Z"
                        fill="black" />
                </svg>
                <?php include 'notifications.php'; ?>
                <?php if (!empty($notificacoes)): ?>
                <span class="notification-count"><?= count($notificacoes) ?></span>
                <?php endif; ?>
            </button>
        </div>

        <div class="dropdown">
            <div id="ImgPerfil" class="mainmenubtn">
                <img src="<?php echo htmlspecialchars($client->getProfilePicture()); ?>" alt="AAAA">
            </div>

            <div class="dropdown-child">
                <button id="Name">
                    <?php  $nomeCompleto = htmlspecialchars($client->getName());
                $primeiroNome = explode(' ', $nomeCompleto)[0];
                echo $primeiroNome; ?></button>

                <a href="../client/conta.php">
                    <button>
                        <svg viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Conta</button>
                </a>

                <?php if ($client->getType() === 'cliente'): ?>
                <a href="../client/form.owner1.php"><button>
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none"
                            stroke-width="2">
                            <path d="M3 11l18-5v12L3 14v-3z" />
                            <path d="M11.6 16.8a3 3 0 11-5.8-1.6" />
                        </svg>
                        Anuncie</button></a>
                <?php endif; ?>

                <a href="../chat/index.php">
                    <button style="position: relative;">
                        <svg viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>Chat
                        <span id="chat-notification-count" class="notification-count" style="display: none;"></span>
                    </button>
                </a>
                <script>
                function atualizarNotificacoesChatHeader() {
                    fetch('../../api/get_total_nao_lidas.php')
                        .then(response => response.json())
                        .then(data => {
                            const notificationCount = document.getElementById('chat-notification-count');
                            if (data.total > 0) {
                                notificationCount.textContent = data.total;
                                notificationCount.style.display = 'block';
                            } else {
                                notificationCount.style.display = 'none';
                            }
                        })
                        .catch(error => console.error('Erro ao carregar notificações:', error));
                }

                // Atualizar a cada 30 segundos
                setInterval(atualizarNotificacoesChatHeader, 30000);

                // Atualizar imediatamente quando a página carrega
                document.addEventListener('DOMContentLoaded', atualizarNotificacoesChatHeader);
                </script>
                <button id="toggleButton">
                    <svg class="sun-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                    <svg class="moon-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                    <span>Tema</span>
                </button>

                <form method="POST">
                    <a id="logout"><button type="submit" name="logoff" class="logoff-btn"><svg viewBox="0 0 24 24">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>Logoff</button></a>
                </form>
            </div>
        </div>


        <?php else: ?>
    </div>
    <div class="dropdown">
        <button class="mainmenubtn"></button>
        <div class="dropdown-child">
            <a href="../auth/login.php"><button><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                        fill="none" stroke-width="2">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                    Login</button></a>
            <a href="../auth/registrar.php"><button><svg viewBox="0 0 24 24" width="24" height="24"
                        stroke="currentColor" fill="none" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <line x1="20" y1="8" x2="20" y2="14" />
                        <line x1="23" y1="11" x2="17" y2="11" />
                    </svg>
                    Registrar</button></a>
            <a href="../auth/registrar.php"><button><svg viewBox="0 0 24 24" width="24" height="24"
                        stroke="currentColor" fill="none" stroke-width="2">
                        <path d="M3 11l18-5v12L3 14v-3z" />
                        <path d="M11.6 16.8a3 3 0 11-5.8-1.6" />
                    </svg>
                    Anuncie</button></a>
            <button id="toggleButton">
                <svg class="sun-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="5"></circle>
                    <line x1="12" y1="1" x2="12" y2="3"></line>
                    <line x1="12" y1="21" x2="12" y2="23"></line>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                    <line x1="1" y1="12" x2="3" y2="12"></line>
                    <line x1="21" y1="12" x2="23" y2="12"></line>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                    <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                </svg>
                <svg class="moon-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
                <span>Tema</span>
            </button>
        </div>
    </div>
    <?php endif; ?>
</header>
<script src="../../resources/js/dark.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainMenuBtn = document.querySelector('.mainmenubtn');
    const dropdownChild = document.querySelector('.dropdown-child');

    mainMenuBtn.addEventListener('click', function() {
        dropdownChild.classList.toggle('active');
    });

    // Fechar o dropdown quando clicar fora dele
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.dropdown')) {
            dropdownChild.classList.remove('active');
        }
    });
});
</script>