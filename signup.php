<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "";    // Replace with your database password
$dbname = "clubmanagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validate role
    $validRoles = ['club-member', 'student'];
    if (!in_array($role, $validRoles)) {
        die("Invalid role selected.");
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert data into the login table
    $sql = "INSERT INTO login (role, email, password) VALUES ('$role', '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Sign-up successful!'); window.location.href = 'login.html';</script>";
    } else {
        // Check for duplicate email error
        if ($conn->errno == 1062) { // Error code for duplicate entry
            echo "<script>alert('Email already registered. Please try a different email.'); window.history.back();</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>
