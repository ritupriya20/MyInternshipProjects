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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">

<style>

.banner {
    background-color: #1f1a37;
    color: #fff;
    text-align: center;
    padding: 20px;
    font-size: 24px;
    width: 1190px;
    margin-left: 15px;
    margin-right:15px;
    align-items: center;
    font-family: 'Poppins', sans-serif;
    font-weight:bold;
}
.sale{
    height: 170px;
    width:170px;
}
.product-container {
border: 1px solid #ccc;
padding: 15px;
margin: 10px;
width: 250px;
text-align: center;
display: inline-block;
vertical-align: top;
}

.product-image {
width: 150px;
height: 150px;
object-fit: cover;
margin-bottom: 10px;
}

.product-name {
font-weight: bold;
}

.original-price {
text-decoration: line-through;
color: #777;
}

.discounted-price {
color: #33cc33;
font-size: 1.2em;
margin: 10px 0;
}

.description {
font-size: 0.9em;
line-height: 1.4;
margin-bottom: 10px;
overflow: hidden;
text-overflow: ellipsis;
display: -webkit-box;
-webkit-line-clamp: 3;
-webkit-box-orient: vertical;
}

.quantity-selector {
display: flex;
align-items: center;
justify-content: center;
margin-top: 10px;
}

.quantity-buttonp {
background-color: #33cc33;
border: none;
color: #fff;
font-size: 1em;
padding: 5px 10px;
cursor: pointer;
margin: 0 5px;
}
.quantity-buttonm {
background-color: red;
border: none;
color:#fff;
font-size: 1em;
padding: 5px 10px;
cursor: pointer;
margin: 0 5px;
}

.quantity-display {
font-size: 1.2em;
}

.modal {
display: none;
position: fixed;
z-index: 1;
left: 0;
top: 0;
width: 100%;
height: 100%;
overflow: auto;
background-color: rgb(0,0,0);
background-color: rgba(0,0,0,0.4);
padding-top: 60px;
}

.modal-content {
background-color: #fefefe;
margin: 5% auto;
padding: 20px;
border: 1px solid #888;
width: 80%;
}

.close {
color: #aaa;
float: right;
font-size: 28px;
font-weight: bold;
}

.addtocart{
  background-color:green;
  font-family: 'Poppins', sans-serif;
  color:white;
  cursor: pointer;
}

.close:hover,
.close:focus {
color: black;
text-decoration: none;
cursor: pointer;
}

.display_modal{
display: flex;
}

.right1{
margin-left:78px;
}

.left1{
margin-top:50px;
}

.content{
  margin-left:40px;
  font-family: 'Poppins', sans-serif;
}

.product-container:hover,.banner:hover{
  transform: scale(1.1);
}

</style>
</head>
<body>
<nav>
  <div class="navbar">
    <a class="logo" href="index.php">R</a>
    <div class="categories">
        <a href="#apparels">Apparel & Accessories</a>
        <a href="#electronics">Electronics & Gadgets</a>
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
<br>
<div class="banner">
    <img class="sale"src="sale.png" alt="not avail"><br>
    Sale starts Today !! <br>Amazing Dealss on Top Brands..
</div>
<br>
<div class="content">
<h2 id="electronics">Electronics & Gadgets</h2>

<?php
  $conn = mysqli_connect("localhost", "root", "", "e_commerce");

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  $sql = "SELECT id,name, original_price, discounted_price, description,image_url FROM products"; 
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      if($row['id']==7){
        echo'<h2 id="apparels">Apparels & Accesories</h2><br>';
        continue;
      }

      $savings = $row['original_price'] - $row['discounted_price'];
      $percent_off = ($savings / $row['original_price']) * 100;
      $encodedImageUrl = urlencode($row['image_url']);
      echo '<div class="product-container">';
      echo '<div onclick="openProductDetails(\'' . ($row['id']-1)  . '\')">';
      echo '<img class="product-image" src="' . $row["image_url"] . '" alt="' . $row['name'] . '">';
      echo '<div class="product-name">' . $row['name'] . '</div>';
      echo '<div class="original-price">' ."MRP:&#8377;". $row['original_price'] . '</div>';
      echo '<div class="discounted-price">' ."&#8377;". $row['discounted_price'] . '</div>';
      echo '<div class="savings">Save: &#8377;' . $savings . ' (' . round($percent_off) . '% off)</div>';
      echo '<div class="description">' . $row['description'] . '</div>';
      echo '</div>';
      echo '<div class="quantity-selector">';
      echo '<button class="quantity-buttonm" data-action="minus">-</button>';
      echo '<div class="quantity-display" id="quantityDisplay_' . $row['id'] . '">1</div>';
      echo '<button class="quantity-buttonp" data-action="plus">+</button>';

      echo '<form action="add_to_cart.php" method="post">';
    echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
    echo '<input type="hidden" class="quantity-input" name="quantity" id="quantityInput_' . $row['id'] . '" value="1" min="1">';
    echo '<input type="submit" class="addtocart" value="Add to Cart">';
    echo '</form>';
      echo '</div>';
      echo '</div>';
      $products[] = array(
        'name' => $row['name'],
        'original_price' => $row['original_price'],
        'discounted_price' => $row['discounted_price'],
        'description' => $row['description'],
        'image_url' => $row['image_url']
      );
    }
  } else {
    echo "0 results";
    $products = array();
  }

  mysqli_close($conn);
?>
</div>
<div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="productDetails"></div>
        </div>
    </div>

<script>
const products = <?php echo json_encode($products); ?>;
function openProductDetails(index) {
  if(index!=6){
    let product = products[index];
    let modal = document.getElementById("myModal");
    let productDetails = document.getElementById("productDetails");
    let imageUrl = product.image_url;

    productDetails.innerHTML = `
    <div class="display_modal">
        <div class="left1">
            <img src="${imageUrl}" alt="${product.name}" style="max-width:250px; max-height: 250px;">
        </div>
        <div class="right1">
            <h2>${product.name}</h2>
            <p>Original Price: ₹${product.original_price}</p>
            <p>Discounted Price: ₹${product.discounted_price}</p>
            <p>Savings: ₹${product.original_price - product.discounted_price}</p>
            <p>Description: ${product.description}</p>
          </div>
        </div>
        <div>
    `;
    modal.style.display = "block";
}
}

function closeModal() {
    let modal = document.getElementById("myModal");
    modal.style.display = "none";
}
document.addEventListener('DOMContentLoaded', function() {
    const quantityButtons = document.querySelectorAll('.quantity-buttonm, .quantity-buttonp');

    quantityButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const display = this.parentElement.querySelector('.quantity-display');
            let quantity = parseInt(display.textContent, 10);

            if (this.dataset.action === 'minus' && quantity > 1) {
                quantity--;
            } else if (this.dataset.action === 'plus') {
                quantity++;
            }

            display.textContent = quantity;

            const productId = display.id.split('_')[1];
            const quantityInput = document.querySelector(`#quantityInput_${productId}`);
            quantityInput.value = quantity;
        });
    });
});

</script>
</body>
</html>
