<?php
// Start session
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "travel_booking_system"); // Check database name

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $destination = $conn->real_escape_string(trim($_POST['destination']));
    $checkIn = $conn->real_escape_string(trim($_POST['check_in']));
    $checkOut = $conn->real_escape_string(trim($_POST['check_out']));
    $guests = intval($_POST['guests']); // Ensure guests is an integer

    // Prepare the SQL query
    $sql = "SELECT * FROM destinations 
            WHERE destination_name LIKE '%$destination%' 
            AND available_from <= '$checkIn' 
            AND available_to >= '$checkOut' 
            AND max_guests >= '$guests'";

    // Execute the query
    $result = $conn->query($sql);

    // Check for query errors
    if (!$result) {
        echo json_encode(['error' => $conn->error]);
        exit;
    }

    // Process the results
    $results = array();
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }

    // If no results are found, return a message
    if (empty($results)) {
        echo json_encode(['message' => 'No results found']);
    } else {
        // Return the results in JSON format
        header('Content-Type: application/json');
        echo json_encode($results);
    }
}

// Close the database connection
$conn->close();
?>
