function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function showInlineMessage(targetId, message) {
    const target = document.getElementById(targetId);

    if (target) {
        target.textContent = message;
        target.style.display = 'block';
    }
}

