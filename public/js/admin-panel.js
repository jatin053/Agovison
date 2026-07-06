document.addEventListener('DOMContentLoaded', () => {
    const shell = document.querySelector('.admin-shell');
    const toggle = document.querySelector('[data-admin-sidebar-toggle]');
    const sidebar = document.getElementById('adminSidebar');

    if (!shell || !toggle || !sidebar) {
        return;
    }

    toggle.addEventListener('click', () => {
        shell.classList.toggle('is-sidebar-open');
    });

    document.addEventListener('click', (event) => {
        if (window.innerWidth > 1240 || !shell.classList.contains('is-sidebar-open')) {
            return;
        }

        if (sidebar.contains(event.target) || toggle.contains(event.target)) {
            return;
        }

        shell.classList.remove('is-sidebar-open');
    });
});
