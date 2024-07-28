<?php
include_once("../../controllers/conexaoimg.php");
include '../../models/php/funcao.php';

// Função para obter o ID do usuário
SalvaID();


$arquivo = $_FILES['arquivo']['name'];

// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = 'foto/';

// Tamanho máximo do arquivo em Bytes
$_UP['tamanho'] = 1024 * 1024 * 100; // 100mb

// Array com a extensões permitidas
$_UP['extensoes'] = array('png', 'jpg', 'jpeg', 'gif');

// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if ($_FILES['arquivo']['error'] != 0) {
    die("Não foi possivel fazer o upload, erro: <br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
    exit; // Para a execução do script
}

// Faz a verificação do tamanho do arquivo
else if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
    echo "
        <META HTTP-EQUIV=REFRESH CONTENT='0;URL=http://localhost/ArenaRental/land/page1.php'>
        <script type=\"text/javascript\">
            alert(\"Arquivo muito grande.\");
        </script>
    ";
} else {
    // Mantém o nome original do arquivo
    $nome_final = $_FILES['arquivo']['name'];

    // Verificar se é possível mover o arquivo para a pasta escolhida

    

    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
        $id_user = SalvaID(); // Obtém o ID do usuário usando a função SalvaID()

        $query_delete = mysqli_query($conn, "DELETE FROM imagem WHERE id_user = '$id_user'");
        $query = mysqli_query($conn, "INSERT INTO imagem (nome_imagem, id_user) VALUES ('$nome_final', '$id_user')");
        echo "
            <META HTTP-EQUIV=REFRESH CONTENT='0;URL=http://localhost/ArenaRental/views/html/registra.quadra1.php'>
            <script type=\"text/javascript\">
                alert(\"Imagem cadastrada com Sucesso.\");
            </script>
        ";
    } else {
        // Upload não efetuado com sucesso, exibe a mensagem
        echo "
            <META HTTP-EQUIV=REFRESH CONTENT='0;URL=http://localhost/ArenaRental/views/html/tela1.php'>
            <script type=\"text/javascript\">
                alert(\"Imagem não foi cadastrada com Sucesso.\");
            </script>
        ";
    }
}
?>
