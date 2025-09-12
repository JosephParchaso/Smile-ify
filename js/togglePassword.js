function togglePassword(inputId = null) {
  if (inputId) {
    const passwordInput = document.getElementById(inputId);
    passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
  } else {
    const passwordInputs = document.querySelectorAll('#newPassword, #confirmPassword');
    const allVisible = Array.from(passwordInputs).every(input => input.type === 'text');
    
    passwordInputs.forEach(input => {
      input.type = allVisible ? 'password' : 'text';
    });
  }
}
