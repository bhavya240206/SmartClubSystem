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

// Fetch the club name from the query parameter
$clubname = isset($_GET['clubname']) ? $_GET['clubname'] : '';

if ($clubname) {
    // Prepare SQL to fetch certificates for the given club
    $stmt = $conn->prepare("SELECT certificate1, certificate2 FROM certificates WHERE clubname = ?");
    $stmt->bind_param("s", $clubname);
    $stmt->execute();
    $stmt->bind_result($certificate1, $certificate2);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
} else {
    die("Club name not specified.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Certificates</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .certificate-link {
            display: block;
            text-align: center;
            margin: 20px 0;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .certificate-link:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Certificates for <?php echo htmlspecialchars($clubname); ?></h1>
        <?php if ($certificate1): ?>
            <a class="certificate-link" href="<?php echo htmlspecialchars($certificate1); ?>" target="_blank">View Certificate 1</a>
        <?php else: ?>
            <p>No Certificate 1 uploaded.</p>
        <?php endif; ?>
        
        <?php if ($certificate2): ?>
            <a class="certificate-link" href="<?php echo htmlspecialchars($certificate2); ?>" target="_blank">View Certificate 2</a>
        <?php else: ?>
            <p>No Certificate 2 uploaded.</p>
        <?php endif; ?>
    </div>
</body>
</html>
