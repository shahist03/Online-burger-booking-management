<?php
// Database connection


session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "burger";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    echo "Failed to Connect";
}

// ... (same as before)

// Signup logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        include "index.html";
        echo "<script>alert('Signup successful!')</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


?>