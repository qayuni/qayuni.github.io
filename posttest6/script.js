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

const darkModeButton = document.getElementById('dark-mode-button');
const body = document.body;
const header = document.querySelector('header');
const menuLinks = document.querySelectorAll('.menu-links a');
const textContainer = document.querySelector('.text-container');
const inputResi = document.querySelector('.input-resi');
const buttonResi = document.querySelector('.button-resi');
const botus = document.querySelector('.botus');
const textBotus = document.querySelector('.text-botus');
const menuToggle = document.querySelector('.menu-toggle');
const layan = document.querySelector('.layan');
const layanan = document.querySelector('.layanan');
const halucon = document.querySelector('.halu-container');
const bestcon = document.querySelector('.best-container');
const layancon = document.querySelectorAll('.layan-container');
const bg = document.querySelector('.bg');
const cc = document.querySelector('.cek-container');
const tresi = document.querySelector('.text-resi');
const inresi = document.querySelector('input-resi');
const bresi = document.querySelector('button-resi');

darkModeButton.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    header.classList.toggle('dark-mode');
    menuLinks.forEach(link => link.classList.toggle('dark-mode'));
    if (textContainer) textContainer.classList.toggle('dark-mode');
    if (inputResi) inputResi.classList.toggle('dark-mode');
    if (buttonResi) buttonResi.classList.toggle('dark-mode');
    botus.classList.toggle('dark-mode');
    textBotus.classList.toggle('dark-mode');
    layanan.classList.toggle('dark-mode');
    halucon.classList.toggle('dark-mode');
    bestcon.classList.toggle('dark-mode');
    layan.classList.toggle('dark-mode');
    layancon.forEach(container => container.classList.toggle('dark-mode'));
    bg.classList.toggle('dark-mode');
    cc.classList.toggle('dark-mode');
    tresi.classList.toggle('dark-mode');
    inresi.classList.toggle('dark-mode');
    bresi.classList.toggle('dark-mode');

    
    
    if (body.classList.contains('dark-mode')) {
        darkModeButton.textContent = '☀️';
    } else {
        darkModeButton.textContent = '🌙';
    }
});


