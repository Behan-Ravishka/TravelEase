<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TravelEase-Signup</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="styles.css">
  <link rel="icon" href="Images/favicon-32x32.png" type="image/png">
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap");

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Open Sans", sans-serif;
    }

    body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      width: 100%;
      padding: 0 10px;
    }

    body::before {
      content: "";
      position: absolute;
      width: 100%;
      height: 100%;
      background: url("Images/signupback.jpeg"), #000;
      background-position: center;
      background-size: cover;
    }

    .wrapper {
      width: 400px;
      margin-top: 80px;
      border-radius: 8px;
      padding: 30px;
      text-align: center;
      border: 1px solid rgba(255, 255, 255, 0.5);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
    }

    form {
      display: flex;
      flex-direction: column;
    }

    h2 {
      font-size: 2rem;
      margin-bottom: 20px;
      color: #fff;
    }

    .input-field {
      position: relative;
      border-bottom: 2px solid #ccc;
      margin: 15px 0;
    }

    .input-field label {
      position: absolute;
      top: 50%;
      left: 0;
      transform: translateY(-50%);
      color: #fff;
      font-size: 16px;
      pointer-events: none;
      transition: 0.15s ease;
    }

    .input-field input {
      width: 100%;
      height: 40px;
      background: transparent;
      border: none;
      outline: none;
      font-size: 16px;
      color: #fff;
    }

    .input-field input:focus~label,
    .input-field input:valid~label {
      font-size: 0.8rem;
      top: 10px;
      transform: translateY(-120%);
    }

    .wrapper a {
      color: #efefef;
      text-decoration: none;
    }

    .wrapper a:hover {
      text-decoration: underline;
    }

    button {
      background: #fff;
      color: #000;
      font-weight: 600;
      border: none;
      padding: 12px 20px;
      cursor: pointer;
      border-radius: 3px;
      font-size: 16px;
      border: 2px solid transparent;
      transition: 0.3s ease;
    }

    button:hover {
      color: #fff;
      border-color: #fff;
      background: rgba(255, 255, 255, 0.15);
    }

    .register {
      text-align: center;
      margin-top: 30px;
      color: #fff;
    }

    .eye-icon {
      position: absolute;
      color: #efefef;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
    }

    #main-header {
      position: fixed; /* Make the header stay at the top */
  top: 0;
  left: 0;
  right: 0;
  display: flex;
  justify-content: space-between;
  padding: 1rem;
  background-color: rgb(0, 0, 0, 0, 0.3);
  z-index: 999;
}
  </style>
</head>
<body>

  <!-- Header Section -->
<header class="navbar-bg py-4 shadow-lg fixed w-full z-50" id="main-header">
    <div class="container mx-auto flex justify-between items-center px-6">
        <!-- Logo and Website Name -->
        <div class="flex items-center">
            <a href="index.php" class="hover:opacity-80 transition-opacity">
                <img src="Images/favicon-32x32.png" width="50px" height="50px" alt="Logo">
            </a>
            <div class="text-2xl font-bold text-white ml-2">
                <a href="index.php" class="hover:opacity-80 transition-opacity">TravelEase</a>
            </div>
        </div>
        <div class="space-x-4">
            <a href="index.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-pink-500 to-purple-500">Home</a>
        </div>
    </div>
</header>

  <!-- Signup Form -->
  <div class="wrapper">
    <form method="post" action="register.php">
      <h2>Signup</h2>
      <div class="input-field">
        <input type="text" name="name" required>
        <label>Enter your name</label>
      </div>
      <div class="input-field">
        <input type="email" name="email" required>
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="password" id="password" name= "password"required>
        <label>Enter your password</label>
        <svg class="eye-icon" id="togglePassword1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="18" height="18">
          <path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"/>
        </svg>
      </div>
      <div class="input-field">
        <input type="password" id="confirmPassword" name="confirmPassword" required>
        <label>Confirm your password</label>
        <svg class="eye-icon" id="togglePassword2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="18" height="18">
          <path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"/>
        </svg>
      </div>
      <button type="submit">Signup</button>
      <div class="register">
        <p>Already have an account? <a href="login.php">Login</a></p>
      </div>
    </form>
  </div>

  <script>
    const togglePassword1 = document.querySelector('#togglePassword1');
    const password = document.querySelector('#password');
    const togglePassword2 = document.querySelector('#togglePassword2');
    const confirmPassword = document.querySelector('#confirmPassword');

    togglePassword1.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      this.classList.toggle('fa-eye-slash');
    });

    togglePassword2.addEventListener('click', function () {
      const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
      confirmPassword.setAttribute('type', type);
      this.classList.toggle('fa-eye-slash');
    });

    var successMessage = new URLSearchParams(window.location.search).get('success');
    if (successMessage) {
        alert(successMessage);
    }
    
  </script>
</body>
</html>
