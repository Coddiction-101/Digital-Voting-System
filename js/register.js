document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('registerForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const errorMessage = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');

    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const inputId = toggle.id === 'togglePassword' ? 'password' : 'confirmPassword';
            const input = document.getElementById(inputId);
            if (input.getAttribute('type') === 'password') {
                input.setAttribute('type', 'text');
                toggle.classList.remove('fa-eye');
                toggle.classList.add('fa-eye-slash');
            } else {
                input.setAttribute('type', 'password');
                toggle.classList.remove('fa-eye-slash');
                toggle.classList.add('fa-eye');
            }
        });
    });

    form.addEventListener('submit', (e) => {
        hideError();

        const nameVal = document.getElementById('name').value.trim();
        const emailVal = document.getElementById('email').value.trim();
        const passVal = password.value.trim();
        const confirmPassVal = confirmPassword.value.trim();

        if (nameVal.length < 3) {
            e.preventDefault();
            showError('Name must be at least 3 characters');
            return;
        }

        if (emailVal === '') {
            e.preventDefault();
            showError('Email or Voter ID is required');
            return;
        }

        if (passVal.length < 6) {
            e.preventDefault();
            showError('Password must be at least 6 characters');
            return;
        }

        if (passVal !== confirmPassVal) {
            e.preventDefault();
            showError('Passwords do not match');
        }
    });

    function showError(msg) {
        errorText.textContent = msg;
        errorMessage.style.display = 'flex';
        errorMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function hideError() {
        errorMessage.style.display = 'none';
        errorText.textContent = '';
    }

    const params = new URLSearchParams(window.location.search);
    const message = params.get('message');
    if (message) {
        showError(message);
    }
});
