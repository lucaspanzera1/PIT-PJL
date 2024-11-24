document.addEventListener("DOMContentLoaded", () => {
    const toggleButton = document.getElementById("toggleButton");
    const body = document.body;

    const toggleDarkMode = () => {
        body.classList.toggle("dark-mode");
        const darkModeEnabled = body.classList.contains("dark-mode");
        localStorage.setItem("dark-mode", darkModeEnabled);
        
        // Adiciona animação de rotação ao ícone
        const icons = toggleButton.querySelectorAll('svg');
        icons.forEach(icon => {
            icon.style.transform = `rotate(${darkModeEnabled ? '360deg' : '0deg'})`;
        });
    };

    const darkModeStored = localStorage.getItem("dark-mode") === "true";
    if (darkModeStored) {
        body.classList.add("dark-mode");
    }

    toggleButton.addEventListener("click", toggleDarkMode);
});

