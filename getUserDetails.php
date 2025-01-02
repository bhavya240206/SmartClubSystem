<?php
session_start(); // Start the session

header('Content-Type: application/json');

// Check if the user is logged in
if (isset($_SESSION['user_role']) && isset($_SESSION['email'])) {
    // Return role and email
    echo json_encode([
        "role" => $_SESSION['user_role'],
        "email" => $_SESSION['email'],
    ]);
} else {
    // User not logged in
    echo json_encode(["error" => "User not logged in."]);
}
?>
