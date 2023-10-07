<?php
session_start();
session_start();


if(isset($_SESSION['cart'])){
    $cart = $_SESSION['cart'];
} 

else {
    $cart = array(); 
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $action = $_POST['action'];
    if ($action === 'delete') {
        
        $cart = array_filter($cart, function($item) use ($productId) {
            return $item['product_id'] != $productId;
        });
    } else {
        

    $newQuantity = $_POST['quantity']; 

    if ($action === 'decrease' && $newQuantity > 1) {
        $newQuantity--;
    } elseif ($action === 'increase') {
        $newQuantity++;
    }

   
    foreach ($cart as &$item) {
        if ($item['product_id'] == $productId) {
            $item['quantity'] = $newQuantity; 
            break;
        }
    }
    
    $productId = $_POST['product_id'];
    $action = $_POST['action'];
    $newQuantity = $_POST['quantity'];
}
    $_SESSION['cart'] = $cart;
   
    header('Location: cart.php');
    exit();
} 
else {
    echo "Invalid request method";
}
?>

