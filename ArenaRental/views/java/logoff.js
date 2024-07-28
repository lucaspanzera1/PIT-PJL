$(document).ready(function(){
    $(".logoff-btn").click(function(){
        $(this).text("Desconectando..."); // Altera o texto do botão para "Desconectando..."
        $(this).css("font-size", "8px"); // Define o tamanho da fonte como 10px
        // Redireciona o usuário para logoff.php após 1 segundo
        setTimeout(function(){
            window.location.href = "../../../models/php/logoff.php";
        }, 1000);
    });
});

