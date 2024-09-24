const mobileMenu = document.getElementById('mobile-menu');
const navbar = document.querySelector('.menu-links');

mobileMenu.addEventListener('click', () => {
    navbar.classList.toggle('active');
});

document.addEventListener('click', (event) => {
    if (!mobileMenu.contains(event.target) && !menuLinks.contains(event.target)) {
        menuLinks.classList.remove('active');
    }
});

const darkModeToggle = document.getElementById('dark-mode');
    const body = document.body;
    const header = document.querySelector('header');
    const menuLinks = document.querySelectorAll('.menu-links a');
    const textContainer = document.querySelector('.text-container');
    const inputResi = document.querySelector('.input-resi');
    const buttonResi = document.querySelector('.button-resi');
    const footer = document.querySelector('footer');
    const textBotus = document.querySelector('.text-botus');
    const menuToggle = document.querySelector('.menu-toggle');

    darkModeToggle.addEventListener('change', () => {
        body.classList.toggle('dark-mode');
        header.classList.toggle('dark-mode');
        menuLinks.forEach(link => link.classList.toggle('dark-mode'));
        if (textContainer) textContainer.classList.toggle('dark-mode');
        if (inputResi) inputResi.classList.toggle('dark-mode');
        if (buttonResi) buttonResi.classList.toggle('dark-mode');
        footer.classList.toggle('dark-mode');
        textBotus.classList.toggle('dark-mode');
        footer.classList.toggle('dark-mode');
    });