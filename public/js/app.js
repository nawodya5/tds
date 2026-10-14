
const sidebar = document.getElementById('appSidebar');
const toggle = document.getElementById('sidebarToggle');
const close = document.getElementById('sidebarClose');
const overlay = document.getElementById('sidebarOverlay');

function setSidebarOpen(open) {
    sidebar?.classList.toggle('is-open', open);
    overlay?.classList.toggle('is-visible', open);
}

toggle?.addEventListener('click', () => setSidebarOpen(true));
close?.addEventListener('click', () => setSidebarOpen(false));
overlay?.addEventListener('click', () => setSidebarOpen(false));
