document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.result-fill').forEach((bar) => {
        const width = bar.style.width;
        bar.style.width = '0';

        requestAnimationFrame(() => {
            bar.style.transition = 'width 600ms ease';
            bar.style.width = width;
        });
    });
});

