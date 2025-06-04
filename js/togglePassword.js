function togglePassword() {
  const passwordInput = document.getElementById('passWord');
  passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
}