<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se | Dono | | © 2024 Arena Rental, Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel='shorcut icon' href="../../../resources/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../User/css/registrar.css?v=<?= time() ?>">
</head>
<body>
    <div id="Quad"> 

    <h1>Cadastre-se Dono</h1>

    <div id="QuadCinza"></div>

    <form action="../../../model/Dono/insert.php" method="post">

    <input type="text" id="cpf"  placeholder="CPF" oninput="mascararCPF()" maxlength="14"  name="cpf"  required>
    <div id="cpfError" style="color: red;"></div>
    <div id="txt1">CPF idêntico ao documento oficial.</div>

    <input type="text" id="nome"  placeholder="Nome" name="nome" required>
    <input type="email" id="sobrenome"  placeholder="Email" name="email"required>

    <div id="txt2">Nome idêntico ao documento oficial.</div>

    <input type="password" id="email"  placeholder="Senha" name="senha" required>
    <div id="txt3">Iremos alertar sobre disponibilidade e promoções!</div>

    <button id="Continuar" > Concordar e continuar </button>

    <div id="txt4"> Clicando em Concordar e continuar, o cliente concorda com os</div>
    <div id="txt5"><a>Termos de Serviço</a> & <a>Política de Privacidade</a> da <a>ArenaRental©</a></div>

    </form>


</div>

<script src="../../User/java/nome.js" ></script>
<script src="../../User/java/cpf.js"></script>
</body>
</html>