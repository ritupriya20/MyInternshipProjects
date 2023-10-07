<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>E-commerce Website</title>
<link rel="stylesheet" href="design.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Monoton&display=swap" rel="stylesheet">
<style>

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
      <a href="login.html"><img src="profile.png" alt="not avail"><br>Profile</a>
      <a href="cart.php"><img src="shopping-cart.png" alt="not avail"><br>Cart</a>
    </div>
  </div>
</nav>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $product = array(
        'product_id' => $product_id,
        'quantity' => $quantity
    );

    if(isset($_SESSION['cart'])){
        $cart = $_SESSION['cart'];
    } else {
        $cart = array(); 
    }

    $productIndex = -1;
    foreach ($cart as $index => $item) {
        if ($item['product_id'] == $product_id) {
            $productIndex = $index;
            break;
        }
    }

    if ($productIndex >= 0) {

        $cart[$productIndex]['quantity'] += $quantity;
    } else {
    
        $cart[] = $product;
    }


    $_SESSION['cart'] = $cart;
    header('Location: cart.php');
} 
else {
    echo "Invalid request.";
}
?>
