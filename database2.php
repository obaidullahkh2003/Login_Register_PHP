<?php
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
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash the password for security
    $credit_card_number = $_POST['credit'];

    // Generate a unique ID
    $sql = "SELECT MAX(id) AS max_id FROM users";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $new_id = $row['max_id'] + 1;

    $sql = "INSERT INTO users (id, name, username, email, password, credit_card_number) VALUES ('$new_id', '$name', '$username', '$email', '$password', '$credit_card_number')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location: login.html");  // Redirect to login page after successful registration
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
