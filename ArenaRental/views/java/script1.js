var caminho_da_imagem = variavel_js;
console.log(caminho_da_imagem);

const inputFile = document.querySelector("#picture__input");
const pictureImage = document.querySelector(".picture__image");
const pictureImageTxt = "";
pictureImage.innerHTML = pictureImageTxt;

const initialImageSrc = "../../models/php/foto"+ caminho_da_imagem;
const initialImg = document.createElement("img");
initialImg.src = initialImageSrc;
initialImg.classList.add("picture__img");
pictureImage.appendChild(initialImg);

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
    pictureImage.innerHTML = pictureImageTxt;
  }
});