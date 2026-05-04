document.addEventListener('DOMContentLoaded', () => {
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const errorMessage = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');

    if (togglePassword && password) {
        togglePassword.addEventListener('click', () => {
            const isPassword = password.getAttribute('type') === 'password';
            password.setAttribute('type', isPassword ? 'text' : 'password');
            togglePassword.classList.toggle('fa-eye', !isPassword);
            togglePassword.classList.toggle('fa-eye-slash', isPassword);
        });
    }

    const params = new URLSearchParams(window.location.search);
    const type = params.get('type');
    const message = params.get('message');

    if (message && errorMessage && errorText) {
        errorText.textContent = message;
        errorMessage.style.display = 'flex';

        if (type === 'success') {
            errorMessage.style.background = '#d4edda';
            errorMessage.style.color = '#155724';
        }
    }
});
