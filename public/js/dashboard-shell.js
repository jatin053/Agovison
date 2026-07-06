document.addEventListener('DOMContentLoaded', () => {
    const shell = document.querySelector('.dash-shell');
    const toggle = document.querySelector('[data-sidebar-toggle]');

    if (!shell || !toggle) {
        return;
    }

    toggle.addEventListener('click', () => {
        shell.classList.toggle('is-sidebar-open');
    });

    document.addEventListener('click', (event) => {
        if (window.innerWidth > 1240) {
            return;
        }

        const sidebar = document.getElementById('dashboardSidebar');

        if (!sidebar || !shell.classList.contains('is-sidebar-open')) {
            return;
        }

        if (sidebar.contains(event.target) || toggle.contains(event.target)) {
            return;
        }

        shell.classList.remove('is-sidebar-open');
    });
});
