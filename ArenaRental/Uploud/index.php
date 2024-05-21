<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploud de Imagem | © 2024 Arena Rental, Inc.</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="LOGO.jpg"> 
</head>
<body>

    <div id="Quad"> 
    <h1>Uploud de imagem!</h1>
    
    <div id="QuadCinza"></div>


    <form method="POST" action="proc_upload.php" enctype="multipart/form-data">

    <label class="picture" for="picture__input" tabIndex="0">
        <span class="picture__image"></span>
      </label>
      
      <input name="arquivo" type="file" name="picture__input" id="picture__input">

      <input type="submit" id="Continuar" value="Enviar">

        </div>
        </form>
      <script src="script.js"></script>
</body>
</html>