<?php
// Database connection (same as signup.php)
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "burger";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    echo "Failed to Connect";
}
// Login logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pass = $_POST["psw"];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row["password"]) {
            include "services.html";
            echo "Login successful!";
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }
}

$conn->close();
?>