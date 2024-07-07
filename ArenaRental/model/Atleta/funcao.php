<?php

session_start();


function SalvaEmail(){
    if(isset($_SESSION['email'])) {
       return $_SESSION['email'];
    } else {
        echo "Email do usuário não encontrado.";
    }
}

function SalvaNome(){
    if(isset($_SESSION['nome'])) {
       return $_SESSION['nome'];
    } else {
        echo "Nome do usuário não encontrado.";
    }
}

function SalvaID() {
    if (isset($_SESSION['id'])) {
        return $_SESSION['id']; // Retorna o valor do ID se estiver definido na sessão
    } else {
        return "ID"; // Retorna uma string "ID" se o ID não estiver definido na sessão
    }
}

function SalvaTipo() {
    if (isset($_SESSION['tipo'])) {
        return $_SESSION['tipo']; // Retorna o valor do ID se estiver definido na sessão
    } else {
        return "tipo"; // Retorna uma string "ID" se o ID não estiver definido na sessão
    }
}

function SalvaData() {
    if (isset($_SESSION['data_registro'])) {
        $data_registro = $_SESSION['data_registro'];
        // Formata a data para o formato brasileiro (dd/mm/YYYY)
        return date('d/m/Y', strtotime($data_registro));
    } else {
        return "data";
    }
}




function FotoPerfil(){
    include_once("../../../controller/conexaoimg.php");

    $id_user = SalvaID();
        
    // Consulta as imagens do usuário
    $query = mysqli_query($conn, "SELECT * FROM imagem WHERE id_user = '$id_user'");
    if($query) {
        if(mysqli_num_rows($query) > 0) {
            while($row = mysqli_fetch_assoc($query)) {
                $nome_imagem = $row['nome_imagem'];
                echo "<img src= '../../../user_pfp/$nome_imagem' alt='Imagem do Usuário'>";
                return $nome_imagem;
            }
        } else {
            echo "Usuário não está logado.";
        }
    } else {
        echo "Erro na consulta ao banco de dados.";
    }
}
function Foto(){
    include_once("controller/conexaoimg.php");

    $id_user = SalvaID();
        
    // Consulta as imagens do usuário
    $query = mysqli_query($conn, "SELECT * FROM imagem WHERE id_user = '$id_user'");
    if($query) {
        if(mysqli_num_rows($query) > 0) {
            while($row = mysqli_fetch_assoc($query)) {
                $nome_imagem = $row['nome_imagem'];
                return $nome_imagem;
            }
        } else {
            echo "Usuário não está logado.";
        }
    } else {
        echo "Erro na consulta ao banco de dados.";
    }
}



function buscarRegistro($pdo, $id) {
    require('../../../controller/conexao.php');

    $sql = "SELECT * FROM cadastro WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $registro;

}


function mascaraCPF($cpf){
    $cpf = preg_replace('/\D/', '', $cpf); // Remove todos os caracteres não numéricos
    $cpf = preg_replace('/(\d{3})(\d)/', '$1.$2', $cpf); // Coloca um ponto entre o terceiro e o quarto dígitos
    $cpf = preg_replace('/(\d{3})(\d)/', '$1.$2', $cpf); // Coloca um ponto entre o sexto e o sétimo dígitos
    $cpf = preg_replace('/(\d{3})(\d{1,2})$/', '$1-$2', $cpf); // Coloca um hífen depois do bloco de três dígitos final
    return $cpf;
}

function validaCPF($cpf) {
    $cpf = preg_replace('/\D/', '', $cpf); // Remove todos os caracteres não numéricos
    if (strlen($cpf) !== 11 || !preg_match('/^\d{11}$/', $cpf)) return false; // Verifica se o CPF tem 11 dígitos
    // Verifica se todos os dígitos são iguais, o que torna o CPF inválido
    if (preg_match('/^(\d)\1{10}$/', $cpf)) return false;

    // Calcula o primeiro dígito verificador
    $sum = 0;
    for ($i = 0; $i < 9; $i++) $sum += intval($cpf[$i]) * (10 - $i);
    $rest = $sum % 11;
    $digit = ($rest < 2) ? 0 : 11 - $rest;
    if ($digit !== intval($cpf[9])) return false;

    // Calcula o segundo dígito verificador
    $sum = 0;
    for ($i = 0; $i < 10; $i++) $sum += intval($cpf[$i]) * (11 - $i);
    $rest = $sum % 11;
    $digit = ($rest < 2) ? 0 : 11 - $rest;
    if ($digit !== intval($cpf[10])) return false;

    return true;
}




?>
