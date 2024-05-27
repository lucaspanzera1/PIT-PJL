<?php

session_start();


function SalvaInfo($nome){
    $_SESSION['nome'] = $nome;
    $_SESSION['email'] = $email;
    $_SESSION['id_usuario'] = $id_usuario;
}

function SalvaNome(){
    if(isset($_SESSION['nome'])) {
        $nome = $_SESSION['nome'];
        echo "$nome";
    } else {
        echo "Nome do usuário não encontrado.";
    }
}

function SalvaID(){
     if(isset($_SESSION['id_usuario'])) {
            $id_usuario = $_SESSION['id_usuario'];
            echo "$id_usuario";
        } else {
            echo "ID";
        }
    }


function FotoPerfil(){

    include_once("../../controllers/conexaoimg.php");

        // Verifica se o usuário está logado
        if(isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
        } 
        
        // Consulta as imagens do usuário
            $query = mysqli_query($conn, "SELECT * FROM imagem WHERE email_user = '$email'");

            if(mysqli_num_rows($query) > 0) {
                while($row = mysqli_fetch_assoc($query)) {
                    $nome_imagem = $row['nome_imagem'];
                    echo "<img src= '../../models/php/foto/$nome_imagem' alt='Imagem do Usuário'>";
                    $nome_imagem;
                }
            } else {
                echo "Usuário não está logado.";
            }
}

function buscarRegistro($pdo, $email) {
    require('../../controllers/conexao.php');

    $sql = "SELECT * FROM cadastro WHERE email=:email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $registro;

}
?>