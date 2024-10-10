<?php
// Connect to database (replace with your connection details)
$conn = new mysqli("localhost", "root", "", "travel booking system");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$showLoading = false; // Flag to control loading indicator display

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destination = $_POST['destination'];
    $min_price = $_POST['min_price'];
    $max_price = $_POST['max_price'];
    $accommodation_type = $_POST['accommodation_type'];

    $showLoading = true; // Set flag to show loading indicator during processing

    // SQL query with filters
    $sql = "SELECT * FROM destinations WHERE destination_name LIKE '%$destination%' 
            AND price BETWEEN $min_price AND $max_price 
            AND accommodation_type = '$accommodation_type'";

    $result = $conn->query($sql);

    // Processing complete, hide loading indicator
    $showLoading = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="Images/favicon-32x32.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtered Results-TravelEase</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-attachment: fixed;
            font-family: 'Open Sans', sans-serif;
            background: url('Images/filterresultsback.jpg') center no-repeat;
            background-size: cover;
            min-height: 75vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .results-wrapper {
            width: 90%;
            border-radius: 8px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            text-align: center;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            margin-top: 90px;
        }

        .result-item {
            background-color: rgba(255, 255, 255, 0.15);
            padding: 5px 10px;
            margin: 5px 3px;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-align: left;
        }

        .result-item:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 40px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #fff;
        }

        .result-header {
            display: flex;
            justify-content: space-between;
            color: #fff;
        }

        .result-details {
            margin: 5px 0;
            color: #fff;
        }

        img {
            width: 300px;
            height: auto;
            border-radius: 5px;
        }

        #main-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            padding: 1rem;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 999;
            margin-bottom: 5px;
        }

        .book-now-btn {
        background-color: #007bff; /* Button color */
        color: white; /* Button text color */
        : 25px 50px; /* Button padding */
        border: none; /* Remove border */
        border-radius: 30px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor on hover */
        text-align: center; /* Center text */
        text-decoration: none; /* Remove underline */
        position: absolute; /* Position it absolutely within the result-item */
        bottom: 40px; /* Adjust as needed for spacing from bottom */
        left: 990px; /* Adjust as needed for spacing from left */
        position: relative;
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
                <img src="Images/favicon-32x32.png"  alt="Logo" class="h-12 w-12">
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

    <div class="results-wrapper">
        <h2>Filtered Destinations</h2>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='result-item'>";
                echo "<div class='result-header'><strong>" . $row['destination_name'] . "</strong><strong>$" . $row['price'] . "</strong>" ."</div>";
                echo "<div class='result-details'>Accommodation: " . $row['accommodation_type'] . "</div>";
                echo "<div class='result-details'>Rating: " . $row['rating'] . " | Reviews: " . $row['reviews'] . "</div>";
                echo "<div class='result-details'>Availability: " .$row['availability'] . "</div>";
                echo "<img src='" . $row['image_url'] . "' alt='Destination Image'>";
                echo "<a href='booking page.php?id=" . $row['id'] . "' class='hover-effect book-now-btn px-10 py-5 rounded-full text-white bg-gradient-to-r from-blue-600 to-blue-400'>Book Now!</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No results found matching your criteria.</p>";
        }
        ?>
    </div>

</body>
</html>