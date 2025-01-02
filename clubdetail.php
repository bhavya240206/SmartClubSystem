<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "clubmanagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clubname = $_POST['clubname'];
    $certificate1_path = null;
    $certificate2_path = null;

    // Directory paths for uploads
    $certificate1_dir = "uploads/certificates1/";
    $certificate2_dir = "uploads/certificates2/";

    // Ensure directories exist
    if (!is_dir($certificate1_dir)) {
        mkdir($certificate1_dir, 0777, true);
    }
    if (!is_dir($certificate2_dir)) {
        mkdir($certificate2_dir, 0777, true);
    }

    // Upload Certificate 1
    if (isset($_FILES['certificate1']) && $_FILES['certificate1']['error'] === UPLOAD_ERR_OK) {
        $certificate1_filename = basename($_FILES['certificate1']['name']);
        $certificate1_path = $certificate1_dir . $certificate1_filename;
        move_uploaded_file($_FILES['certificate1']['tmp_name'], $certificate1_path);
    }

    // Upload Certificate 2
    if (isset($_FILES['certificate2']) && $_FILES['certificate2']['error'] === UPLOAD_ERR_OK) {
        $certificate2_filename = basename($_FILES['certificate2']['name']);
        $certificate2_path = $certificate2_dir . $certificate2_filename;
        move_uploaded_file($_FILES['certificate2']['tmp_name'], $certificate2_path);
    }

    // Insert file paths into the database
    $stmt = $conn->prepare("INSERT INTO certificates (clubname, certificate1, certificate2) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $clubname, $certificate1_path, $certificate2_path);

    if ($stmt->execute()) {
        echo "Certificates uploaded successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
