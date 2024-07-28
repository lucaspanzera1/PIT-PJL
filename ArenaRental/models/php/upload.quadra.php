<?php
include_once("../../controllers/conexaoimg.php");
include '../../models/php/funcao.php';

// Função para obter o ID do usuário
$id_usuario = SalvaID();

$arquivo = $_FILES['arquivo']['name'];

// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = 'foto/';

// Tamanho máximo do arquivo em Bytes
$_UP['tamanho'] = 1024 * 1024 * 100; // 100mb

// Array com as extensões permitidas
$_UP['extensoes'] = array('png', 'jpg', 'jpeg', 'gif');

// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if ($_FILES['arquivo']['error'] != 0) {
    die("Não foi possível fazer o upload, erro: <br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
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
        // Insere a imagem e o ID do usuário no banco de dados
        $query = mysqli_query($conn, "INSERT INTO imagem_quadra (nome_imagem, id_dono) VALUES ('$nome_final', '$id_usuario')");
        
        if ($query) {
            echo "
                <META HTTP-EQUIV=REFRESH CONTENT='0;URL=http://localhost/ArenaRental/index.php'>
                <script type=\"text/javascript\">
                    alert(\"Imagem cadastrada com Sucesso.\");
                </script>
            ";
        } else {
            echo "
                <META HTTP-EQUIV=REFRESH CONTENT='0;URL=http://localhost/ArenaRental/index.php'>
                <script type=\"text/javascript\">
                    alert(\"Erro ao cadastrar imagem no banco de dados.\");
                </script>
            ";
        }
    } else {
        // Upload não efetuado com sucesso, exibe a mensagem
        echo "
            <META HTTP-EQUIV=REFRESH CONTENT='0;URL=http://localhost/ArenaRental/index.php'>
            <script type=\"text/javascript\">
                alert(\"Imagem não foi cadastrada com Sucesso.\");
            </script>
        ";
    }
}
?>
