<?php
session_start();

if(isset($_SESSION['cart'])){
    $cart = $_SESSION['cart'];
} else {
    $cart = array(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Monoton&display=swap" rel="stylesheet">
    <title>Cart</title>
    <style>
    
    .cart-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-left:40px;
}

.cart-items {
    flex-basis: 70%; 
    margin-right: 20px; 
}

.cart-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 10px;
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.cart-item img {
    max-width: 100px;
    max-height: 100px;
    margin-right: 10px;
}

.cart-item div {
    flex-grow: 1;
}

.total-bill {
    flex-basis: 30%; 
    padding: 10px;
    border-radius: 10px;
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.delete{
    background-color:red;
  font-family: 'Poppins', sans-serif;
  color:white;
  cursor: pointer;
  border:none;
}

    </style>
</head>
<body>
<nav>
  <div class="navbar">
    <a class="logo" href="index.php">R</a>
    <div class="categories">
        <a href="index.php#apparels">Apparel & Accessories</a>
        <a href="index.php#electronics">Electronics & Gadgets</a>
    </div>
    <div class="left">
      <img class="search-img" src="search.png" alt="not avail">
      <input class="search-bar" id="search-bar" type="text" placeholder="Search for your favourite brands..">
    </div>
    <div class="icons">
      <a href="login.php"><img src="profile.png" alt="not avail"><br>Profile</a>
      <a href="cart.php"><img src="shopping-cart.png" alt="not avail"><br>Cart</a>
    </div>
  </div>
</nav>
<br>
    <h2 style="margin-left:20px;">Cart</h2><br>
    <div class="cart-container">
        <div class="cart-items">
            <?php
            if (empty($cart)) {
                echo "<p>Your cart is empty.</p>";
            } else {
                $conn = mysqli_connect("localhost", "root", "", "e_commerce");

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                foreach ($cart as $item) {
                    $product_id = $item['product_id'];
                    $quantity = $item['quantity'];

                    $sql = "SELECT * FROM products WHERE id='$product_id'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        echo "<div class='cart-item'>";
                        echo "<img src='{$row['image_url']}' alt='{$row['name']}'>";
                        echo "<div>";
                        echo "<p>{$row['name']}</p>";
                        echo '<form action="update_cart.php" method="post">';
                        echo "<input type='hidden' name='product_id' value='$product_id'>";
                        echo '<button type="submit" name="action" value="decrease">-</button>';
                        echo '<input type="number" name="quantity" value="' . $quantity . '" min="1">';
                        echo '<button type="submit" name="action" value="increase">+</button>';
                        echo"</form>";
                        echo "<p>Price: ₹{$row['discounted_price']}</p>";
                        echo '<form action="update_cart.php" method="post">';
                        echo '<input type="hidden" name="product_id" value="' . $item['product_id'] . '">';
                        echo '<input type="hidden" name="action" value="delete">';
                        echo '<button type="submit" class="delete">Delete from Cart</button>';
                        echo '</form>';
                        echo "</div>";
                        echo "</div>";
                    }
                }

                mysqli_close($conn);
            }
            ?>
        </div>
        <div class="total-bill">
    <?php
    $total = 0;
    $totalSavings = 0;
    $full_total=0;
    foreach ($cart as $item) {
        $product_id = $item['product_id'];

        $conn = mysqli_connect("localhost", "root", "", "e_commerce");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT original_price, discounted_price FROM products WHERE id='$product_id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $full_total+=($row['original_price']) * $item['quantity'];
            $total += $row['discounted_price'] * $item['quantity'];
            $totalSavings += ($row['original_price'] - $row['discounted_price']) * $item['quantity'];
        }

        mysqli_close($conn);
    }
    echo"<h2 style='text-decoration:underline;'>Bill<h2>";
    echo "<h3>MRP: <span style='color:red;text-decoration:line-through;'>₹{$full_total}</span></h3>";
    echo "<h3>Cart Subtotal: <span>₹{$total}</span></h3>";
    echo "<h3>Total Savings: <span style='color:green;'>₹{$totalSavings}</span></h3>";
    ?>
</div>

    </div>
    <br>
    <a href="index.php" style="color:black">Continue Shopping</a>
</body>
</html>
