document.addEventListener('DOMContentLoaded', () => {
  const loginForm = document.getElementById('loginForm');

  loginForm.addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    const email = document.querySelector('input[name="email"]').value;
    const password = document.querySelector('input[name="password"]').value;

    // Prepare form data
    const formData = new URLSearchParams();
    formData.append('email', email);
    formData.append('password', password);

    fetch('php/login.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: formData.toString()
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Redirect to dashboard
          window.location.href = 'dashboard.php';
        } else {
          // Show error message
          showError(data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showError('An unexpected error occurred.');
      });
  });

  // Function to display error messages
  function showError(message) {
    const errorDiv = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');

    errorText.textContent = message;
    errorDiv.style.display = 'block';

    // Optional: hide error after some seconds
    setTimeout(() => {
      errorDiv.style.display = 'none';
    }, 5000);
  }
});
