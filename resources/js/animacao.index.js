document.addEventListener('DOMContentLoaded', function() {
    // Adiciona animações suaves ao carregar os itens
    const quadraItems = document.querySelectorAll('.quadra-item');
    quadraItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        setTimeout(() => {
            item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, index * 100);
    });
});