<?php
include 'connect.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Check if the token exists in the database
    $query = "SELECT id FROM users WHERE verification_token = ? AND email_verified = 0";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // If token is valid, update the user to mark email as verified
        $query = "UPDATE users SET email_verified = 1, verification_token = NULL WHERE verification_token = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        
        echo "Your email has been verified successfully!";
    } else {
        echo "Invalid or expired verification link.";
    }
} else {
    echo "No token provided.";
}
?>
