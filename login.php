<?php
session_start(); // Start the session to store user details

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve submitted form data
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Database connection details
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "clubmanagement";

    // Establish a database connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query
    $sql = "SELECT role, password FROM login WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if a matching email is found
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($retrievedRole, $hashedPassword);
        $stmt->fetch();

        // Verify the entered password and role
        if (password_verify($password, $hashedPassword)) {
            if ($retrievedRole === $role) {
                // Store role and email in session
                $_SESSION['user_role'] = $retrievedRole;
                $_SESSION['email'] = $email;

                // Debugging: Check if session variables are set
                echo "Session Role: " . $_SESSION['user_role'];
                echo "Session Email: " . $_SESSION['email'];

                // Redirect based on role
                if ($retrievedRole === "club-member") {
                    header("Location: post.html");
                } elseif ($retrievedRole === "student") {
                    header("Location: display1.html");
                } else {
                    echo "<h3>Invalid role. Please contact the administrator.</h3>";
                }
            } else {
                echo "<h3>Role mismatch. Please try again.</h3>";
            }
        } else {
            echo "<h3>Invalid password. Please try again.</h3>";
        }
    } else {
        echo "<h3>No account found with the provided email. Please try again.</h3>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
