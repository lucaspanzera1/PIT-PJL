<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se | © 2024 Arena Rental, Inc.</title>
    <link rel="stylesheet" type="text/css" href="cadastrar.css" media="screen" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="LOGO.jpg"> 
</head>
<body>
    <div id="Quad"> 

    <h1>Entrar ou cadastre-se</h1>

    <div id="QuadCinza"></div>

    <form action="insert.php" method="post">

    <input type="text" id="data"  placeholder="CPF" maxlength="14" oninput="formatarCPF()" name="cpf"  required>
    <div id="txt1">CPF idêntico ao documento oficial.</div>

    <input type="text" id="nome"  placeholder="Nome" name="nome" required>
    <input type="email" id="sobrenome"  placeholder="Email" name="email"required>

    <div id="txt2">Nome idêntico ao documento oficial.</div>

    <input type="password" id="email"  placeholder="Senha" name="senha" required>
    <div id="txt3">Iremos alertar sobre disponibilidade e promoções!</div>

    <button id="Continuar" > Concordar e continuar</button>

    <div id="txt4"> Clicando em Concordar e continuar, o cliente concorda com os</div>
    <div id="txt5"><a>Termos de Serviço</a> & <a>Política de Privacidade</a> da <a>ArenaRental©</a></div>

    </form>


</div>
    
<script src="cpf.js"></script>
</body>
</html>