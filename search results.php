<?php
// Connect to database (replace with your connection details)
$conn = new mysqli("localhost", "root", "", "travel booking system");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$showLoading = false; // Flag to control loading indicator display

// Initialize filter variables with defaults
$destination = isset($_POST['destination']) ? $_POST['destination'] : '';
$min_price = isset($_POST['min_price']) ? (int)$_POST['min_price'] : 0;
$max_price = isset($_POST['max_price']) ? (int)$_POST['max_price'] : PHP_INT_MAX; // Max price can be very high
$accommodation_type = isset($_POST['accommodation_type']) ? $_POST['accommodation_type'] : '';

// Build SQL query with filters
$sql = "SELECT * FROM destinations WHERE destination_name LIKE '%$destination%'";

if ($min_price >= 0) {
    $sql .= " AND price >= $min_price";
}
if ($max_price < PHP_INT_MAX) {
    $sql .= " AND price <= $max_price";
}
if (!empty($accommodation_type)) {
    $sql .= " AND accommodation_type = '$accommodation_type'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="Images/favicon-32x32.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - TravelEase</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-attachment: fixed;
            font-family: 'Open Sans', sans-serif;
            background: url('Images/searchresultsback.jpg') center no-repeat;
            background-size: cover;
            min-height: 75vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .result-item {
            position: relative;
}

        .results-wrapper {
            width: 80%;
            border-radius: 8px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            text-align: center;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            margin-top: 90px;
        }

        .result-item {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 10px 15px;
            margin: 10px 5px;
            border-radius: 15px;
            transition: all 0.3s ease;
            text-align: left;
            position: relative;
            overflow: hidden;
        }

        .result-header {
            font-size: 6rem;
            margin-bottom: 20px;
            color: #fff;
        }

        .result-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.3);
        }

        .result-item img {
            width: 100%;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .result-item img:hover {
            transform: scale(1.05);
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #fff;
        }

        .result-details {
            margin: 5px 0;
            color: #fff;
            font-size: 20px;
        }

        .price {
            font-size: 1.8rem; 
            color: #fff; 
            margin-top: 5px; 
        }

        .stars {
            display: flex;
            align-items: center;
            color: #FFD700; 
        }

        .star {
            font-size: 20px;
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
            background-color: #007bff;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            position: absolute;
            bottom: 20px;
            left: 20px;
            transition: background-color 0.3s ease;
        }

        .book-now-btn:hover {
            background-color: #0056b3;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
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

    <div class="results-wrapper">
        <h2>Search Results</h2>

        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rating = (int)$row['rating'];
                $numStars = 5; // Total number of stars
                echo "<div class='result-item'>";
                echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='Destination Image'>";
                echo "<div class='overlay'>";
                echo "<div class='result-header'><strong>" . htmlspecialchars($row['destination_name']) . "</strong>" . "</div>";
                echo "<strong class='price'>$" . htmlspecialchars($row['price']) . "</strong>";
                echo "<div class='result-details'>Accommodation: " . htmlspecialchars($row['accommodation_type']) . "</div>";
                echo "<div class='result-details'>Availability: " . htmlspecialchars($row['available_from']) . " to " . htmlspecialchars($row['available_to']) . "</div>";
                echo "<div class='stars'>";
                // Display stars based on the rating
                for ($i = 1; $i <= $numStars; $i++) {
                    echo "<span class='star'>" . ($i <= $rating ? '★' : '☆') . "</span>";
                }
                echo "</div>"; // End of stars div
                echo "<a href='booking page.php?id=" . htmlspecialchars($row['id']) . "' class='hover-effect book-now-btn'>Book Now!</a>";
                echo "</div>"; // End of overlay div
                echo "</div>"; // End of result item div
            }
        } else {
            echo "<p class='text-white'>No results found matching your criteria.</p>";
        }
        ?>
    </div>

</body>
</html>
