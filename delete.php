<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root"; // Update as needed
$password = ""; // Update as needed
$dbname = "clubmanagement";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read the JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['club_name'], $data['event_name'], $data['event_datetime'], $data['venue'])) {
    $clubName = $conn->real_escape_string($data['club_name']);
    $eventName = $conn->real_escape_string($data['event_name']);
    $eventDatetime = $conn->real_escape_string($data['event_datetime']);
    $venue = $conn->real_escape_string($data['venue']);

    // Delete from eventdetails
    $sql1 = "DELETE FROM eventdetails 
             WHERE club_name = ? AND event_name = ? AND event_datetime = ? AND venue = ?";
    $stmt1 = $conn->prepare($sql1);

    if ($stmt1 === false) {
        die("Error preparing statement for eventdetails: " . $conn->error);
    }

    $stmt1->bind_param("ssss", $clubName, $eventName, $eventDatetime, $venue);

    // Delete from eventdetails1
    $sql2 = "DELETE FROM eventdetails1 
             WHERE club_name = ? AND event_name = ? AND event_datetime = ? AND venue = ?";
    $stmt2 = $conn->prepare($sql2);

    if ($stmt2 === false) {
        die("Error preparing statement for eventdetails1: " . $conn->error);
    }

    $stmt2->bind_param("ssss", $clubName, $eventName, $eventDatetime, $venue);

    // Execute both statements
    $success1 = $stmt1->execute();
    $success2 = $stmt2->execute();

    if ($success1 && $success2) {
        echo "success";
    } else {
        echo "error: " . $stmt1->error . " | " . $stmt2->error;
    }

    $stmt1->close();
    $stmt2->close();
} else {
    echo "error: Invalid input";
}

$conn->close();
?>
