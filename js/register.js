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

    // Basic validation on form submit
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        hideError();

        const nameVal = document.getElementById('name').value.trim();
        const emailVal = document.getElementById('email').value.trim();
        const passVal = password.value.trim();
        const confirmPassVal = confirmPassword.value.trim();

        if (nameVal.length < 3) {
            showError('Name must be at least 3 characters');
            return;
        }

        if (emailVal === '') {
            showError('Email or Voter ID is required');
            return;
        }

        if (passVal.length < 6) {
            showError('Password must be at least 6 characters');
            return;
        }

        if (passVal !== confirmPassVal) {
            showError('Passwords do not match');
            return;
        }

        showSuccess();
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

    function showSuccess() {
        const successDiv = document.createElement('div');
        successDiv.style.cssText = `
            background: #d4edda;
            border-left: 4px solid #28a745;
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            color: #155724;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
        `;
        successDiv.innerHTML = '<i class="fas fa-check-circle" style="margin-right: 10px;"></i><span>Registration successful! Redirecting...</span>';

        form.insertBefore(successDiv, form.firstChild);

        setTimeout(() => {
            alert('In real application, redirect to login page.');
        }, 1500);
    }
});
