<?php

include "cart.php";
if (isset($_POST['add_ingredients'])) {
    // Get product details from the form
    $product = $_POST['product'];
    $ingredients = isset($_POST['ingredient']) ? $_POST['ingredient'] : [];

    // Insert ingredients into the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "burger";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert ingredients into the user_ingredients table
    foreach ($ingredients as $ingredient) {
        $sql = "INSERT INTO ordernow (user_id, product_name, ingredient) VALUES (1, '$product', '$ingredient')"; // Replace '1' with the actual user ID

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
   
    // Clear the shopping cart
    unset($_SESSION['cart']);

    // Redirect back to cart.php
   
    exit();
}
?>
