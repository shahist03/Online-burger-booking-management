<?php

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "burger";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    echo "Failed to Connect";
}

if (isset($_POST["add"])) {
    $productImage = isset($_POST["hidden_image"]) ? $_POST["hidden_image"] : "";
    $productName = isset($_POST["hidden_name"]) ? $_POST["hidden_name"] : "";
    $productPrice = isset($_POST["hidden_price"]) ? $_POST["hidden_price"] : "";
    $productQuantity = isset($_POST["quantity"]) ? $_POST["quantity"] : "";

    // Rest of the code...
}


    $sql = "INSERT INTO `orders` (`product_name`, `image`, `price`, `quantity`) VALUES ('$productName', '$productImage', '$productPrice', '$productQuantity')";

    if (mysqli_query($conn, $sql)) {
        echo "Order added successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }




if (isset($_POST["remove"])) {
    $removeId = $_POST["remove"];

    $sql = "DELETE FROM `product` WHERE id = '$removeId'";
    mysqli_query($conn, $sql);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Restarant</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/plugins/owl.carousel.min.css">
        <link rel="stylesheet" href="assets/css/all.min.css">
        <link rel="stylesheet" href="assets/css/style.css">

    <!-- ... (your existing head section) ... -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <span>Order Summary</span>
        <div>
            <a href="index.php">Back to Shop</a>
        </div>
    </nav>

    <main>
        <h2>Your Order</h2>
        <div class="order-container">
            <?php
            $orderQuery = "SELECT * FROM `product` ORDER BY id ASC";
            $orderResult = mysqli_query($conn, $orderQuery);

            if (mysqli_num_rows($orderResult) > 0) {
                while ($orderRow = mysqli_fetch_array($orderResult)) {
            ?>
                    <div class="order-item">
                        <img src="assets/images/menu/1.jpg<?php echo $orderRow["image"]; ?>" alt="">
                        <input type="hidden" name="hidden_image" value="<?php echo $row["image"]; ?>">
<input type="hidden" name="hidden_name" value="<?php echo $row["product_name"]; ?>">
<input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>">

                        <form action="order.php" method="post">
                            <input type="hidden" name="remove" value="<?php echo $orderRow["id"]; ?>">
                            <input type="submit" name="remove_item" value="Remove Item">
                        </form>
                    </div>
            <?php
                }
            } else {
                echo "<p>No items in your order.</p>";
            }
            ?>
        </div>
    </main>

    <footer></footer>
</body>
</html>
