<?php
session_start(); // Start the session to store user information

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel booking system"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Processing form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    // Validate form input
    if (empty($name) || empty($email) || empty($password)) {
        echo 'Please provide your name, email, and password.';
        exit();
    }

    // Check if email already exists
    $sql_check = "SELECT * FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Email already exists, show error message
        echo '
        <div class="notification-container">
            <div class="alert alert-danger">
                This email is already registered. Please use another email or <a href="login.php">login here</a>.
            </div>
        </div>

        <style>
            .notification-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                background-color: rgba(0, 0, 0, 0.7);
                color: #fff;
                text-align: center;
                font-family: Arial, sans-serif;
            }
            .alert-danger {
                background-color: #dc3545;
                padding: 20px;
                border-radius: 8px;
                margin-bottom: 20px;
                font-size: 18px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            }
            a {
                color: #fff;
                text-decoration: underline;
            }
        </style>
        ';
    } else {
        // Email does not exist, proceed with registration

        // Hash the password before saving it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Prepare SQL statement to insert user
        $sql_insert = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        // Bind the user details (name, email, hashed password)
        $stmt_insert->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt_insert->execute()) {
            // Get the user's ID for session tracking
            $user_id = $stmt_insert->insert_id;

            // Start the session and store user information
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $name;

            // Successful registration message with loading effect and auto redirect
            echo '
            <div class="notification-container">
                <div class="alert alert-success">
                    Registration successful! You will be redirected to the Loginpage shortly.
                </div>
                <div class="loader">
                    <div class="spinner"></div>
                    <p>Redirecting...</p>
                </div>
            </div>

            <style>
                .notification-container {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    min-height: 100vh;
                    background-color: rgba(0, 0, 0, 0.7);
                    color: #fff;
                    text-align: center;
                    font-family: Arial, sans-serif;
                }

                .alert-success {
                    background-color: #28a745;
                    padding: 20px;
                    border-radius: 8px;
                    margin-bottom: 20px;
                    font-size: 18px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                }

                .loader {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }

                .spinner {
                    border: 4px solid rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    border-top: 4px solid #fff;
                    width: 50px;
                    height: 50px;
                    animation: spin 1s linear infinite;
                    margin-bottom: 10px;
                }

                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }

                p {
                    color: #fff;
                    font-size: 16px;
                    margin-top: 10px;
                }
            </style>

            <script>
                setTimeout(function() {
                    window.location.href = "login.php";
                }, 5000); // Redirect after 5 seconds
            </script>';
        } else {
            echo "Error: " . $stmt_insert->error;
        }

        $stmt_insert->close();
    }

    $stmt_check->close();
}

$conn->close();
?>
