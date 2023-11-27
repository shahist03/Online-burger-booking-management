<?php
session_start();

// Check if the Add to Cart button is clicked
if (isset($_POST['add_to_cart'])) {
    // Get product details from the form
    $product = $_POST['product'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
 

    // Add item to the cart
    $_SESSION['cart'][] = array(
        'productname' => $product,
        'price' => $price,
        'quantity' => $quantity,
        // Store the image filename
    );

    // Insert order details into the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "burger";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO booking (product_name, price, quantity) VALUES ('$product', $price, $quantity)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New record created successfully')</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

// Check if the Remove Item link is clicked
if (isset($_GET['remove_product'])) {
    $removeProduct = $_GET['remove_product'];

    // Create a new array without the item to be removed
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($removeProduct) {
        return !(isset($item['productname']) && $item['productname'] === $removeProduct);
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Your existing CSS styles */
        /* ... */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        .cart-item {
            border-bottom: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            position: relative;
        }

        .cart-item img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .cart-item h4 {
            margin: 0;
        }

        .remove-link {
            position: absolute;
            top: 5px;
            right: 5px;
            color: red;
            text-decoration: none;
        }

        .total-amount {
            text-align: right;
            margin-top: 20px;
            font-size: 18px;
        }

        .continue-shopping {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .order-form {
            margin-top: 10px;
        }

        .ingredients-checkbox {
            margin-right: 10px;
        }
    </style>
    <title>Shopping Cart</title>
</head>
<body>

<div class="container">
   <h2>
    Your order
   </h2>

    <?php
    // Check if the cart is not empty
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            // Check if the key "productname" exists before using it
            $productName = isset($item['productname']) ? $item['productname'] : '';
            $price = isset($item['price']) ? $item['price'] : 0;
            $quantity = isset($item['quantity']) ? $item['quantity'] : 1;
           
            echo "<div class='cart-item'>
                    <img src='assets/images/menu/{}' alt='{$productName}'>
                    <h4>{$productName}</h4>
                    <p>Description goes here</p>
                    <p>Price: {$price} - Quantity: {$quantity}
                        <a href='cart.php?remove_product=" . urlencode($productName) . "' class='remove-link'>Remove</a>
                    </p>
                    <form class='order-form' action='ordernow.php' method='post'>
                        <input type='hidden' name='product' value='{$productName}'>
                        <label>Add Ingredients:</label>
                        <input type='checkbox' class='ingredients-checkbox' name='ingredient[]' value='Cheese'> Cheese
                        <input type='checkbox' class='ingredients-checkbox' name='ingredient[]' value='Lettuce'> Lettuce
                        <input type='checkbox' class='ingredients-checkbox' name='ingredient[]' value='Tomato'> Tomato
                        <!-- Add more ingredients as needed -->
                        <input type='submit' name='order now' value='ordernow'>
                    </form>
                </div>";
        }

        // Calculate total amount
        $totalAmount = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $_SESSION['cart']));

        // Display total amount
        echo "<p class='total-amount'>Total Amount: $totalAmount</p>";
    } else {
        echo "<p>Your cart is empty.</p>";
    }
    ?>

    <a href="services.html" class="continue-shopping">Continue Shopping</a>
</div>

</body>
</html>
