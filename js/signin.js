

document.addEventListener('DOMContentLoaded', function () {
  //showing password
  showLoginPassword = document.getElementById("toggle-password");
  showLoginPassword.addEventListener("click", () => {
    showLoginPassword.classList.toggle("fa-eye-slash");
    showLoginPassword.classList.toggle("fa-eye");
    loginPassword = document.getElementById("login-password");
    if (loginPassword.type == "password") {
      loginPassword.type = "text";
    } else {
      loginPassword.type = "password";
    }
  });
});