<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // If user is not logged in, set the notification and redirect to login
    $_SESSION['login_required_message'] = "You have to login or signup first!";
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get booking details from form inputs
    $destination = $_POST['destination'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $guests = $_POST['guests'];

    // Store booking details in session
    $_SESSION['booking_details'] = [
        'destination' => $destination,
        'check_in' => $check_in,
        'check_out' => $check_out,
        'guests' => $guests,
    ];

    // Redirect to confirmation page
    header("Location: confirm booking.php");
    exit();
}

// Connect to database (replace with your connection details)
$conn = new mysqli("localhost", "root", "", "travel booking system");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the destination ID from the URL
if (isset($_GET['id'])) {
    $destination_id = intval($_GET['id']); // Use intval to sanitize the input

    // SQL query to fetch the destination details
    $sql = "SELECT * FROM destinations WHERE id = $destination_id";
    $result = $conn->query($sql);

    // Check if destination exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p>Destination not found.</p>";
        exit();
    }
} else {
    echo "<p>Invalid request.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="Images/favicon-32x32.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page - TravelEase</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="styles.css">
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
            padding: 0 20px;
            background: url('Images/bookingback.jpg') center no-repeat;
            background-size: cover;
            position: relative;
        }

        .booking-wrapper {
            width: 80%;
            border-radius: 8px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            text-align: center;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #fff;
        }

        .details {
            color: #fff;
            margin-top: -3px;
            margin-bottom: -3px;
        }

        .book-now-btn {
            padding: 5px 435px;
            margin-top: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .book-now-btn:hover {
            background-color: #0056b3;
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

<div class="booking-wrapper">
    <h2>Booking Details for <?php echo htmlspecialchars($row['destination_name']); ?></h2>
    <p class="details">Price: $<?php echo htmlspecialchars($row['price']); ?></p>
    <p class="details">Accommodation Type: <?php echo htmlspecialchars($row['accommodation_type']); ?></p>
    <p class="details">Rating: <?php echo htmlspecialchars($row['rating']); ?></p>
    <p class="details">Availability: <?php echo htmlspecialchars($row['availability']); ?></p>
    <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Destination Image" style="width: 300px; height: auto; border-radius: 5px; margin: 20px 360px;">

    <form action="confirm booking.php" method="post">
        <input type="hidden" name="destination_id" value="<?php echo htmlspecialchars($row['id']); ?>">
        
        <label for="name" class="details">Your Name:</label>
        <input type="text" id="name" name="name" required class="px-2 py-1 rounded border">

        <label for="email" class="details">Your Email:</label>
        <input type="email" id="email" name="email" placeholder="example@gmail.com" required class="px-2 py-1 rounded border">

        <label for="phone" class="details">Your Phone Number:</label>
        <input type="tel" id="phone" name="phone" placeholder="07XXXXXXXX" required class="px-0 py-1 rounded border">

        <button type="submit" class="book-now-btn">Confirm Booking</button>
    </form>
</div>

</body>
</html>
