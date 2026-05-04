document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('themeToggle');
    const savedTheme = localStorage.getItem('dvs-theme');

    if (savedTheme === 'dark') {
        document.body.classList.add('dark-theme');
    }

    if (toggle) {
        toggle.textContent = document.body.classList.contains('dark-theme') ? 'Light' : 'Dark';

        toggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-theme');
            const isDark = document.body.classList.contains('dark-theme');
            localStorage.setItem('dvs-theme', isDark ? 'dark' : 'light');
            toggle.textContent = isDark ? 'Light' : 'Dark';
        });
    }
});
