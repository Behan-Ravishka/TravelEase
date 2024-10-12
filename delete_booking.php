<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['booking_id'])) {
        $booking_id = $_POST['booking_id'];

        // Prepare and execute the delete statement
        $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);

        if ($stmt->execute()) {
            echo "Booking canceled successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
}

$conn->close();
?>
