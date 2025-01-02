<?php
// Database connection
$servername = "localhost";
$username = "root"; // Update as needed
$password = ""; // Update as needed
$dbname = "clubmanagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$sql = "SELECT club_name, event_name, event_datetime, venue FROM eventdetails1";
$result = $conn->query($sql);

// Prepare data
$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($events);

// Close connection
$conn->close();
?>
