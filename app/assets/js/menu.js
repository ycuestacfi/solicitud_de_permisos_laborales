document.addEventListener('DOMContentLoaded', () => {
    const menu = document.getElementById('btn_menu');
    const navMenu = document.getElementById('menu');

    menu.addEventListener('click', () => {
        if (!navMenu.classList.contains('menu_active')) {
            navMenu.classList.add('menu_active');
            navMenu.style.display="flex";
            menu.classList.add('menu_active');
        } else {
            navMenu.classList.remove('menu_active');
            navMenu.style.display="none";
            menu.classList.remove('menu_active');
        }
       
    });
});
