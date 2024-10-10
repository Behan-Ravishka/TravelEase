<?php
session_start();

// Fetch user details from the session
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Connect to the database
include 'connect.php';

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the $bookings array to prevent undefined variable issues
$bookings = [];

// Update the query to link bookings and users via email
$query = "SELECT b.booking_date, d.destination_name, d.price 
          FROM bookings b
          JOIN destinations d ON b.destination_id = d.id
          JOIN users u ON b.user_id = u.id
          WHERE u.email = ?";

// Prepare the statement
if ($stmt = $conn->prepare($query)) {
    // Get the user's email from the database
    $email_query = "SELECT email FROM users WHERE id = ?";
    if ($email_stmt = $conn->prepare($email_query)) {
        $email_stmt->bind_param("i", $user_id);
        $email_stmt->execute();
        $email_stmt->bind_result($email);
        $email_stmt->fetch();
        $email_stmt->close();
    }

    // Bind the email parameter
    $stmt->bind_param("s", $email);
    
    // Execute the query and fetch the results
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $bookings = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "Error executing query: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing query: " . $conn->error;
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
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
            position: relative; /* Position background */
        }

        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: url("Images/viewbookingback.jpg"), #000;
            background-position: center;
            background-size: cover;
            z-index: 0; /* Background behind content */
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

        /* Glassmorphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 2rem;
            max-width: 90%;
            width: 100%;
            margin: 25px 200px auto;
        }

        .custom-table {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            border-collapse: collapse;
        }

        .custom-table th, 
        .custom-table td {
            padding: 12px;
            border: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
    <header class="navbar-bg py-4 shadow-lg fixed w-full z-50" id="main-header">
        <div class="container mx-auto flex justify-between items-center px-6">
            <div class="flex items-center">
                <a href="index.php" class="hover:opacity-80 transition-opacity"><img src="Images/favicon-32x32.png" width="50px" height="50px" alt="Logo"></a>
                <div class="text-2xl font-bold text-white ml-2">
                    <a href="index.php" class="hover:opacity-80 transition-opacity">TravelEase</a>
                </div>
            </div>

            <div class="space-x-4">
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<a href="index.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-pink-500 to-purple-500">Home</a>';
                    echo '<a href="logout.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-blue-600 to-blue-400">Logout</a>';
                } else {
                    echo '<a href="login.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-blue-600 to-blue-400">Login</a>';
                    echo '<a href="signup.php" class="hover-effect px-4 py-2 rounded-full text-white bg-gradient-to-r from-pink-500 to-purple-500">Sign Up</a>';
                }
                ?>
            </div>
        </div>
    </header>

    <section class="flex items-center justify-center min-h-screen mt-16"> <!-- Centering Section -->
        <div class="container mx-auto p-8 glass" style="max-width: 800px;"> <!-- Adjusted Card Width -->
            <h2 class="text-4xl text-center mb-6 text-white">My Bookings</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md glass">
                    <thead>
                        <tr>
                            <th class="border-b border-gray-200 px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Booking Date</th>
                            <th class="border-b border-gray-200 px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Destination</th>
                            <th class="border-b border-gray-200 px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($bookings) > 0): ?>
                            <?php foreach ($bookings as $booking): ?>
                                <tr class="hover:bg-gray-100 transition duration-300">
                                    <td class="border-b border-gray-200 px-6 py-4"><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                                    <td class="border-b border-gray-200 px-6 py-4"><?php echo htmlspecialchars($booking['destination_name']); ?></td>
                                    <td class="border-b border-gray-200 px-6 py-4"><?php echo htmlspecialchars($booking['price']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="border-b border-gray-200 px-6 py-4 text-center">No bookings found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
