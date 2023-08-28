<?php

session_start();
require_once '../config/conn_db.php'; // Added semicolon at the end



if (isset($_GET['foodname']) && isset($_GET['price']) && isset($_GET['quantity'])) {
    $foodname = $_GET['foodname'];
    $price = $_GET['price'];
    $quantity = $_GET['quantity'];
    
    // Store the selected food item in the session or database as needed
    // You can use an array or other data structure to store multiple items in the cart

    $_SESSION['cart'][] = array(
        'foodname' => $foodname,
        'price' => $price,
        'quantity' => $quantity
        
    );
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>menu</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
  
<!-- Your modal code here -->

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h1>รายการสั่งอาหาร</h1>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
        </div>
    </div>

   <!-- ตาราง -->
<table class="table">
    <thead>
        <tr>
            <th scope="col">NO.</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            
        </tr>
    </thead>
    <tbody>
    <?php
    $totalPrice = 0; // Initialize total price
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $cartItems = $_SESSION['cart'];
        $count = 1;

        foreach ($cartItems as $item) {
            $itemName = $item['foodname'];
            $itemPrice = $item['price'];
            $itemQuantity = $item['quantity'];

            $itemTotal = $itemPrice * $itemQuantity;
            $totalPrice += $itemTotal;
            ?>
            <tr>
                <th scope="row"><?php echo $count; ?></th>
                <td><?php echo $itemName; ?></td>
                <td><?php echo $itemPrice; ?></td>
                <td><?php echo $itemQuantity; ?></td>
                <td>
                    <button class="btn btn-danger" onclick="removeItem('<?php echo $itemName; ?>')">Remove</button>
                </td>
            </tr>
            <?php
            $count++;
        }
    }
    ?>
</tbody>
</table>

<!-- Display the total price -->
<p>Total Price: <?php echo $totalPrice; ?></p> <button class="btn btn-danger" onclick="removeAllItems()">Remove All</button>

<a href="order-menu.php" class="btn btn-secondary">Back to Order Menu</a>


<script>
    function removeAllItems() {
        const xhr = new XMLHttpRequest();

        xhr.open('GET', `../service/remove_all_items.php`, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                location.reload(); // Reload the page to reflect the updated cart
            }
        };

        xhr.send();
    }
</script>
<script>
    function removeItem(itemName) {
        const xhr = new XMLHttpRequest();

        xhr.open('GET', `../service/remove_item.php?foodname=${encodeURIComponent(itemName)}`, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                location.reload(); // Reload the page to reflect the updated cart
            }
        };

        xhr.send();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
    // Your JavaScript code here
</script>
</body>
</html>
