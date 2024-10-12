<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connect.php'; // Database connection file

// Initialize error message variable
$error_message = '';

// Check for login required message
if (isset($_SESSION['login_required_message'])) {
    $error_message = $_SESSION['login_required_message']; // Get the login required message
    unset($_SESSION['login_required_message']); // Clear message after displaying
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name']; // Get the name from the form

    // Check if the user exists in the database and verify the password
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify the name and password (assuming passwords are hashed)
        if ($user['name'] === $name && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];  // Store user id in session
            $_SESSION['user_name'] = $user['name']; // Store user name in session
            $_SESSION['user_email'] = $user['email']; // Store user email in session

            // Redirect to the booking page or homepage depending on session
            if (isset($_SESSION['redirect_to_booking']) && $_SESSION['redirect_to_booking'] === true) {
                unset($_SESSION['redirect_to_booking']); // Clear the flag
                header("Location: booking_page.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            // Name or password does not match
            $error_message = "Invalid name, email, or password.";
        }
    } else {
        // User not found
        $error_message = "Invalid name, email, or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelEase - Login</title>
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
            flex-direction: column;
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
            background: url("Images/loginback.jpeg"), #000;
            background-position: center;
            background-size: cover;
        }

        .wrapper {
            width: 400px;
            margin-top: 70px;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            position: relative; 
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
            height: 30px;
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

        .forget {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 25px 0 35px 0;
            color: #fff;
        }

        #remember {
            accent-color: #fff;
        }

        .forget label {
            display: flex;
            align-items: center;
        }

        .forget label p {
            margin-left: 8px;
        }

        .wrapper a {
            color: #efefef;
            text-decoration: none;
        }

        .wrapper a:hover {
            text-decoration: underline;
        }

        .eye-icon {
            position: absolute;
            color: #efefef;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
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

        .signup {
            text-align: center;
            margin-top: 30px;
            color: #fff;
        }

        .notification {
            background-color: #BB0000; 
            color: #fff; 
            padding: 10px;
            border-radius: 5px;
            margin: 0 0;
            text-align: center;
            width: calc(100% - 20px); /* Full width minus padding */
            position: fixed; /* Fixed positioning to ensure it appears above everything */
            top: 0; /* Align with the top of the viewport */
            left: 405px; /* Add some horizontal padding */
            opacity: 0; /* Start as hidden */
            transition: opacity 0.5s ease; /* Smooth transition for fade-in/out */
            z-index: 10; /* Ensure it appears above other elements */
            width: 470px;
        }

        .notification.show {
            opacity: 2; /* Show the notification */
        }

        #main-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            padding: 1rem;
            background-color: rgba(0, 0, 0, 0.3);
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

<!-- Login Form -->
<div class="wrapper" id="login-wrapper"> 

    <!-- Display Notification if exists -->
    <?php if (!empty($error_message)): ?>
        <div class="notification show" id="notification">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="login.php">
        <h2>Login</h2>

        <div class="input-field">
            <input type="text" name="name" id="name" required>
            <label>Name</label>
        </div>

        <div class="input-field">
            <input type="email" name="email" id="email" required>
            <label>Email</label>
        </div>

        <div class="input-field">
            <input type="password" name="password" id="password" required>
            <label>Password</label>
            <svg class="eye-icon" id="togglePassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="18" height="18">
          <path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"/>
        </svg>
        </div>

        <div class="forget">
            <label><input type="checkbox" id="remember"> Remember Me</label>
            <a href="forgot password.html">Forget Password?</a>
        </div>

        <button type="submit">Login</button>

        <div class="signup">Don't have an account? <a href="signup.php">Register</a></div>
    </form>
</div>

<!-- Script for toggling password visibility -->
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');
    const notification = document.getElementById('notification');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });

    // Auto-hide the notification after a few seconds
    if (notification) {
        setTimeout(() => {
            notification.classList.remove('show');
        }, 5000); // Change 5000 to desired duration (in milliseconds)
    }
</script>

</body>
</html>
