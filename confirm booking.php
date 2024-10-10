<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, set a session variable to redirect after login
    $_SESSION['redirect_to_booking'] = true;
    $_SESSION['login_required_message'] = "First log in to make a booking!"; // Update the message
    // Redirect to login page with notification
    header("Location: login.php");
    exit();
}

// Include the database connection
include 'connect.php'; // Database connection

// Get the user's registered email and user ID
$user_email = $_SESSION['user_email'];
$user_id = $_SESSION['user_id']; // Get user ID from session

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data and sanitize inputs
    $destination_id = intval($_POST['destination_id']); // Destination ID
    $name = $conn->real_escape_string(trim($_POST['name'])); // User's name
    $email = $conn->real_escape_string(trim($_POST['email'])); // User's email
    $phone = $conn->real_escape_string(trim($_POST['phone'])); // User's phone
    
    // Check if user is attempting to book with their registered email
    if ($email !== $user_email) {
        $notification = "Please use your <strong>registered email</strong> to make a booking!<br><br>
        <a href='index.php' class='hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-blue-600 to-blue-400'>Back To Home</a>";
    } else {
        // Insert booking details into the database, including user_id
        $sql = "INSERT INTO bookings (destination_id, name, email, phone, user_id) VALUES ('$destination_id', '$name', '$email', '$phone', '$user_id')";

        if ($conn->query($sql) === TRUE) {
            // Store booking details in session for confirmation display
            $_SESSION['booking_details'] = [
                'destination' => $_POST['destination_id'],
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
            ];
            
            // Create a confirmation message with booking details
            $confirmation_message = "Your booking has been confirmed <strong>successfully!</strong><br><br>
            Destination ID: <strong>{$destination_id}</strong><br>
            Name: <strong>{$name}</strong><br>
            Email: <strong>{$email}</strong><br>
            Phone: <strong>{$phone}</strong><br><br>
            <strong>Thank you for choosing <a href='index.php' class='hover:text-gray-400 transition-colors'>TravelEase.</a></strong><br><br>
            <a href='index.php' class='hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-blue-600 to-blue-400'>Back To Home</a>";
        } else {
            // Handle error if unable to insert into database
            $notification = "Error: " . $conn->error;
        }
    }
} else {
    // Redirect to booking page if accessed directly
    header("Location: booking_page.php?id=" . $_POST['destination_id']);
    exit();
}

// Close the database connection
$conn->close();

// Initialize notification variable
$notification = $notification ?? ''; // This will ensure it is defined even if not set

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="Images/favicon-32x32.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - TravelEase</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap");

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Open Sans", sans-serif;
    font-size: 21px;
}

body {
    background: url('Images/bookingconfback.jpg') center no-repeat;
    background-size: cover;
    width: 100%;
    height: 100%;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.3); /* Semi-transparent black overlay */
    z-index: -9999; /* Ensure the overlay is above the background but below the content */
}

.confirmation-wrapper {
    width: 80%;
    max-width: 600px;
    border-radius: 10px;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
    text-align: center;
    color: white;
}

.notification {
    padding: 1rem;
    background-color: rgba(255, 0, 0, 0.5); /* Red background */
    color: white;
    border-radius: 5px;
    margin-bottom: 0.2rem;
    margin: auto;
    transition: opacity 0.5s ease-in-out;
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

<div class="overlay"></div>

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
            <a href="account.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-pink-500 to-purple-500">My Profile</a>
        </div>
    </div>
</header>

<div class="confirmation-wrapper">
    <!-- Display notification if any -->
    <?php if ($notification): ?>
        <div class="notification">
            <?php echo $notification; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($confirmation_message)): ?>
        <?php echo $confirmation_message; ?>
    <?php endif; ?>
</div>

</body>
</html>
