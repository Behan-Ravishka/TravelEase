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
$query = "SELECT b.id, b.booking_date, d.destination_name, d.price 
          FROM bookings b
          JOIN destinations d ON b.destination_id = d.id
          JOIN users u ON b.user_id = u.id
          WHERE u.id = ?";

// Prepare the statement
if ($stmt = $conn->prepare($query)) {
    // Bind user_id parameter
    $stmt->bind_param("i", $user_id);
    
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
        /* Glassmorphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
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
            height: 120%;
            background: url("Images/viewbookingback.jpg"), #000;
            background-position: center;
            background-size: cover;
        }

        .notification {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            background-color: #4caf50; 
            color: white;
            border-radius: 5px;
            z-index: 1000;
            transition: opacity 0.5s ease;
        }
        .notification.show {
            display: block;
            opacity: 10;
        }
        
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1001; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px; 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
            max-width: 500px; 
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Button hover effects */
        .delete-button {
            background-color: #e63946;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
            transition: background-color 0.3s ease;
        }
        .delete-button:hover {
            background-color: #d62839;
        }
        .yes-button {
            background-color: #4caf50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
            transition: background-color 0.3s ease;
        }
        .yes-button:hover {
            background-color: #d62839;
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

        table {
            border-collapse: separat
            border-spacing: 
            border: non
            width: 100%;
            border-radius: 12p
            overflow: hidde
            -shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            background: rgba(255, 255, 255, 0.1);
        }

        table td, table th {
            border: 1px solid rgba(255, 255, 255, 0.2)
            padding: 12px 20px;
            backdrop-filter: blur(5px)
            color: white;
        }

        /* Header styling */
        table th {
            background-color: rgba(28, 37, 65, 0.8)
            color: white;
        }

        table td {
            background-color: rgba(255, 255, 255, 0.05)
            color: black;
        }

        table tr:first-child th:first-child {
            border-top-left-radius: 12px;
        }

        table tr:first-child th:last-child {
            border-top-right-radius: 12px;
        }

        /* Rounded corners for the bottom-left and bottom-right of the table */
        table tr:last-child td:first-child {
            border-bottom-left-radius: 12px;
        }

        table tr:last-child td:last-child {
            border-bottom-right-radius: 12px;
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
                }
                ?>
            </div>
        </div>
    </header>

    <section class="flex items-center justify-center min-h-screen mt-9">
        <div class="container mx-auto p-8 glass" style="max-width: 800px;">
            <h2 class="text-6xl text-center mb-6 text-white">My Bookings</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-lg glass">
                    <thead>
                        <tr>
                            <th class="border-b border-gray-200 px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Booking Date</th>
                            <th class="border-b border-gray-200 px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Destination</th>
                            <th class="border-b border-gray-200 px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Price</th>
                            <th class="border-b border-gray-200 px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bookings)): ?>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td class="border-b border-gray-200 px-6 py-4"><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                                    <td class="border-b border-gray-200 px-6 py-4"><?php echo htmlspecialchars($booking['destination_name']); ?></td>
                                    <td class="border-b border-gray-200 px-6 py-4"><?php echo htmlspecialchars($booking['price']); ?></td>
                                    <td class="border-b border-gray-200 px-6 py-4">
                                        <button class="delete-button" data-id="<?php echo $booking['id']; ?>" onclick="openModal(this)">
                                            <i class="fas fa-times-circle"></i> Cancel Booking
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center p-4">No bookings found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Notification -->
    <div class="notification" id="notification">Booking canceled successfully!</div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2 class="text-lg font-bold">Confirm Cancellation</h2>
            <p>Are you sure you want to cancel this booking?</p>
            <div class="flex justify-end mt-4">
            <button class="yes-button" id="confirmCancel">Yes, Cancel</button>
            <button class="delete-button" id="cancelCancel">No, Go Back</button>
            </div>
        </div>
    </div>

    <script>
        let currentBookingId; // Store the current booking ID for cancellation

        // Open the modal and set the current booking ID
        function openModal(button) {
            currentBookingId = button.getAttribute('data-id');
            document.getElementById('myModal').style.display = "block";
        }

        // Close the modal
        document.getElementById('closeModal').onclick = function() {
            document.getElementById('myModal').style.display = "none";
        };

        // Cancel booking
        document.getElementById('confirmCancel').onclick = function() {
            const formData = new FormData();
            formData.append('booking_id', currentBookingId);

            fetch('delete_booking.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('notification').innerText = data;
                document.getElementById('notification').classList.add('show');
                setTimeout(() => {
                    document.getElementById('notification').classList.remove('show');
                    // Reload the page after a short delay to update bookings
                    location.reload();
                }, 2000);
            })
            .catch(error => console.error('Error:', error));

            // Close the modal
            document.getElementById('myModal').style.display = "none";
        };

        // Cancel the cancellation process
        document.getElementById('cancelCancel').onclick = function() {
            document.getElementById('myModal').style.display = "none";
        };
    </script>
</body>
</html>
