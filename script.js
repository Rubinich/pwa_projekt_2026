const toggle = document.querySelector('.nav-toggle');
const navLinks = document.querySelector('nav ul');

toggle.addEventListener('click', () => {
    const isOpen = navLinks.classList.toggle('open');
    toggle.innerHTML = isOpen ? '&#10005;' : '&#9776;';
});