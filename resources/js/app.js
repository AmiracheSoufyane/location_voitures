import { createIcons, icons } from 'lucide';

window.toggleSidebar = function () {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('-translate-x-full');
};
window.togglePersonnes = function () {
    const menu = document.getElementById('personnesMenu');
    menu.classList.toggle('hidden');
};
document.addEventListener("DOMContentLoaded", () => {
    createIcons({ icons });
});