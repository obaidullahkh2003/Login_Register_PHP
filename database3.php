<?php
session_start();

$servername = "localhost:3306";
$username = "root";  // Replace with your database username
$password = "admin";  // Replace with your database password
$dbname = "masw_shopping";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_or_email = $conn->real_escape_string($_POST['username_or_email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username_or_email' OR email = '$username_or_email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            header("Location: products.html");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "No user found with this username or email";
    }
}

$conn->close();
?>
