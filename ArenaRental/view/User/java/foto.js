const inputFile = document.querySelector("#picture__input");
const pictureImage = document.querySelector(".picture__image");
const pictureImageTxt = "Foto";

// Caminho inicial da imagem usando a variável nomeImagem definida pelo PHP
const caminhoInicial = `../../models/php/foto/${nomeImagem}`;

// Função para carregar a imagem ao iniciar a página
function carregarImagemInicial() {
  const img = document.createElement("img");
  img.src = caminhoInicial;
  img.classList.add("picture__img");

  pictureImage.innerHTML = "";
  pictureImage.appendChild(img);
}

// Chama a função para carregar a imagem ao iniciar a página
carregarImagemInicial();

inputFile.addEventListener("change", function (e) {
  const inputTarget = e.target;
  const file = inputTarget.files[0];

  if (file) {
    const reader = new FileReader();

    reader.addEventListener("load", function (e) {
      const readerTarget = e.target;

      const img = document.createElement("img");
      img.src = readerTarget.result;
      img.classList.add("picture__img");

      pictureImage.innerHTML = "";
      pictureImage.appendChild(img);
    });

    reader.readAsDataURL(file);
  } else {
    // Se não houver arquivo selecionado, mostra o texto padrão
    pictureImage.innerHTML = pictureImageTxt;
  }
});
