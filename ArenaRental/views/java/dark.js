$(document).ready(function(){
    $(".logoff-btn").click(function(){
        $(this).text("Desconectando..."); // Altera o texto do botão para "Desconectando..."
        $(this).css("font-size", "8px"); // Define o tamanho da fonte como 8px

        // Adiciona um pequeno delay para que a mensagem "Desconectando..." seja visível antes do redirecionamento
        setTimeout(function(){
            window.location.href = "http://localhost/ArenaRental/model/User/logoff.php";
        }, 500); // 500 milissegundos de delay
    });
});

const toggleButton = document.getElementById('toggle-theme');
const body = document.body;
const imgH2 = document.getElementById("imgH2");
const QuadCinza = document.getElementById("QuadCinza");
const Quad = document.getElementById("Quad");
const Corpo = document.getElementById("Corpo");
const menuButtons = document.querySelectorAll('.mainmenubtn');

toggleButton.addEventListener('click', function() {
    body.classList.toggle('dark-mode');
    imgH2.classList.toggle("dark-mode");
    QuadCinza.classList.toggle("dark-mode");
    Quad.classList.toggle("dark-mode");
    Corpo.classList.toggle("dark-mode");

    menuButtons.forEach(button => {
        button.classList.toggle('dark-mode');
    });

    if (body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }
});

const currentTheme = localStorage.getItem('theme');
if (currentTheme === 'dark') {
    body.classList.add('dark-mode');
    imgH2.classList.add('dark-mode');
    QuadCinza.classList.add('dark-mode');
    Quad.classList.add('dark-mode');
    Corpo.classList.add('dark-mode');
    menuButtons.forEach(button => {
        button.classList.add('dark-mode');
    });
} else {
    body.classList.remove('dark-mode');
    imgH2.classList.remove('dark-mode');
    QuadCinza.classList.remove('dark-mode');
    Quad.classList.remove('dark-mode');
    Corpo.classList.remove('dark-mode');
    menuButtons.forEach(button => {
        button.classList.remove('dark-mode');
    });
}
