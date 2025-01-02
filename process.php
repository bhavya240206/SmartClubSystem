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

// Insert data into the database
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $clubName = $_POST['club-name'];
    $eventName = $_POST['event-name'];
    $eventDatetime = $_POST['event-time'];
    $venue = $_POST['venue'];

    $sql1 = "INSERT INTO eventdetails (club_name, event_name, event_datetime, venue) 
            VALUES ('$clubName', '$eventName', '$eventDatetime', '$venue')";
    $sql2 = "INSERT INTO eventdetails1 (club_name, event_name, event_datetime, venue) 
            VALUES ('$clubName', '$eventName', '$eventDatetime', '$venue')";

    if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
        // Redirect to display.html after successful insertion
        header("Location: display.html");
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
