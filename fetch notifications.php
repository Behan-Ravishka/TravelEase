<?php
session_start();

if (isset($_SESSION['user_id'])) {
    require 'connect.php'; // Connect to the database

    $user_id = $_SESSION['user_id'];

    // Fetch unread notifications for this user
    $query = "SELECT * FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $notifications = [];
    $unreadCount = 0;

    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
        $unreadCount++;
    }

    // Response structure
    $response = [
        'unreadCount' => $unreadCount, // Unread notifications count
        'notifications' => $notifications // Notifications data
    ];

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If the user is not logged in, return empty data
    $response = [
        'unreadCount' => 0,
        'notifications' => []
    ];
    
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
