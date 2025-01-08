<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Header -->
    <input type="checkbox" id="cart">
    <label for="cart" class="label-cart"><span class="fa fa-shopping-cart"></span></label>

    <h3 class="logo">HUHUHUHUHU</h3>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-menu">
            <span class="fa fa-home"></span>
            <a href="#">Home</a>
        </div>
        <div class="sidebar-menu">
            <span class="fa fa-bars"></span>
            <a href="#">Menu</a>
        </div>
        <div class="sidebar-menu">
            <span class="fa fa-user"></span>
            <a href="profile.php">Profile</a>
        </div>
        <div class="sidebar-menu">
            <span class="fa fa-address-card"></span>
            <a href="#">About Us</a>
        </div>
        <div class="sidebar-menu">
            <span class="fa fa-phone"></span>
            <a href="#">Contact</a>
        </div>   
    </div>
    <!-- Content -->
    <div class="container">
        <div class="menu">
            <div class="menu-banner">
                <img src="sample.jpg">
            </div>

            <h3 class="menu-title">What we Offer</h3>
            <div class="menu-category">
                <a href="#">Kakanin Bilao</a>
                <a href="#">Pancit Bilao</a>
                <a href="#">Ulam Bilao</a>
                <a href="#">Bilao Package</a>
            </div>
            
            <div class="menu-content">
                <?php
                // Start the session
                session_start();

                include("connection.php");

                if (isset($_SESSION['userinfo'])) {
                    $userinfo = $_SESSION['userinfo'];
                    
                    // Query to get the price range for each food item
                    $sql = "
                        SELECT 
                            f.food_id,
                            f.Name,
                            f.Description,
                            f.Image,
                            f.Time,
                            MIN(fp.price) AS min_price,
                            MAX(fp.price) AS max_price
                        FROM 
                            food f
                        INNER JOIN 
                            food_size_pricing fp ON f.food_id = fp.food_id
                        GROUP BY 
                            f.food_id, f.Name, f.Description, f.Image, f.Time
                    ";
                    
                    $result = $conn->query($sql);

                    // Loop over the menu items and generate the HTML code
                    while ($row = $result->fetch_assoc()) {
                        $price_range = number_format($row['min_price'], 2) . " - " . number_format($row['max_price'], 2) . "$";
                        ?>
                        <div class="menu-item" data-name="<?php echo $row['Name']; ?>" data-price="<?php echo $price_range; ?>" data-image="<?php echo $row['Image']; ?>" data-food-id="<?php echo $row['food_id']; ?>">
                            <img class="card-img" src="<?php echo $row['Image']; ?>">
                            <div class="card-detail">
                                <h4>
                                    <?php echo $row['Name']; ?> 
                                    <span><?php echo $price_range; ?></span>
                                </h4>
                                <p><?php echo $row['Description']; ?></p>
                                <p class="card-time"><span class="fa fa-clock"></span> <?php echo $row['Time']; ?> mins</p>
                            </div>
                        </div>
                        <?php
                        // Save the menu item data to the session
                        $_SESSION['menu_items'][] = array(
                            'name' => $row['Name'],
                            'price_range' => $price_range,
                            'image' => $row['Image'],
                            'description' => $row['Description'],
                            'time' => $row['Time']
                        );
                    }
                }
                ?>
            </div>

        </div>
    <!-- Order -->
        <div class="menu-order">
            <h3>Order Menu</h3>
            <div class="order-address">
                <p>Address Delivery</p>
                <h4><?php echo $_SESSION['userinfo']['Address']; ?></h4>
            </div>
            <div class="order-time">
                <span class="fa fa-gear"></span> 30 mins <span class="fa fa-map-pin"></span>2 km
            </div>

            <div class="order-wrapper">
                <div id="order-items">
                    <?php
                    
                    if (isset($_SESSION['order']['order_items'])) {
                        foreach ($_SESSION['order']['order_items'] as $item) {
                            ?>
                            <div class="order-card">
                                <img class="order-image" src="<?php echo $item['image']; ?>">
                                <div class="order-detail">
                                    <p><?php echo $item['name']; ?></p>
                                    <i class="fa fa-times remove-item"></i>
                                    <input type="text" value="<?php echo $item['quantity']; ?>" readonly>
                                </div>
                                <h4 class="order-price">$<?php echo $item['price'] * $item['quantity']; ?></h4>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>                
            </div>

            <hr class="divider">
            <div class="order-total">
                <p>Subtotal <span id="subtotal">$<?php echo $_SESSION['order']['subtotal']; ?></span></p>
                <p>Tax (10%) <span id="tax">$<?php echo $_SESSION['order']['tax']; ?></span></p>
                <p>Delivery Fee <span id="delivery-fee">$<?php echo $_SESSION['order']['delivery_fee']; ?></span></p>

                <hr class="divider">
                <p>Total <span id="total">$<?php echo $_SESSION['order']['total']; ?></span></p>
            </div>

            <div class="payment-method">
                
            </div>

            <button id="checkout-btn" class="checkout">Checkout</button>
        </div>

        <?php
        if (!isset($_SESSION['order'])) {
            // Store the order data in the session
            $_SESSION['order'] = array(
                'address' => $_SESSION['userinfo']['Address'],
                'time' => '30 mins',
                'distance' => '2 km',
                'subtotal' => 0.00,
                'tax' => 0.00,
                'delivery_fee' => 50.00,
                'total' => 0.00,
                'order_items' => array(),
            );
        }
        
        ?>

        <!-- Food Item Modal -->
        <div id="foodModal" data-food-id="1">
            <div class="modal-content">
                <img src="" class="modal-image" alt="Food Image">
                <div class="modal-details">
                    <span class="close">&times;</span>
                    <h2 class="modal-name"></h2>
                    <p class="modal-description"></p>
                    <p class="modal-price"></p>
                    <div class="size-options">
                        <!-- Dynamic Size Options will load here -->
                    </div>
                    <button id="addToCartBtn">Add to Cart</button>
                </div>
            </div>
        </div>


    </div>
    <script src="js.js"></script>
</body>
</html>