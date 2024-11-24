let currentImageIndex = 0;
const images = document.querySelectorAll('.quadra-image-large');
const modal = document.getElementById('imageModal');
const modalImg = document.getElementById('modalImage');

function openModal(img) {
    modal.style.display = "block";
    modalImg.src = img.src;

    // Encontrar o índice da imagem atual
    for (let i = 0; i < images.length; i++) {
        if (images[i] === img) {
            currentImageIndex = i;
            break;
        }
    }
}

function closeModal() {
    modal.style.display = "none";
}

function changeImage(direction) {
    currentImageIndex += direction;

    // Loop através das imagens
    if (currentImageIndex >= images.length) {
        currentImageIndex = 0;
    }
    if (currentImageIndex < 0) {
        currentImageIndex = images.length - 1;
    }

    modalImg.src = images[currentImageIndex].src;
}

// Fechar modal ao clicar fora da imagem
modal.onclick = function(e) {
    if (e.target === modal) {
        closeModal();
    }
}

// Controles de teclado
document.onkeydown = function(e) {
    switch (e.key) {
        case "ArrowLeft":
            changeImage(-1);
            break;
        case "ArrowRight":
            changeImage(1);
            break;
        case "Escape":
            closeModal();
            break;
    }
}
