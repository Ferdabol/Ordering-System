<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Header -->
    <input type="checkbox" id="cart">
    <label for="cart" class="label-cart"><span class="fa fa-shopping-cart"></span></label>


    <input type="checkbox" id="bell">
    <label for="bell" class="label-bell"><i class="bx bx-bell"></i></label>

    <h3 class="head-t">
        fwaff
    </h3>
   

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="top">
            <div class="logo">
                <img src="logo.png" alt="Logo">
                <h3>M's Bilao</h3>
            </div>
            <i class="bx bx-menu" id="btn"></i>
        </div>

        <div class="user">
            <div>
                <p class="bold"><?php echo $_SESSION['userinfo']['Fname'] . ' ' . substr($_SESSION['userinfo']['Lname'], 0, 1) . '.'; ?></p>
                <p>Customer</p>
            </div>
        </div>
        <ul>
            <li>
                <a href="homepage.php">
                    <i class="bx bxs-home"></i>
                    <span class="nav-item">Home</span>
                </a>
                <span class="tooltip">Home</span>
            </li>
            <li>
                <a href="menu.php">
                    <i class="bx bx-food-menu"></i>
                    <span class="nav-item">Menu</span>
                </a>
                <span class="tooltip">Menu</span>
            </li>
            <li>
                <a href="profile.php">
                    <i class="bx bxs-smile"></i>
                    <span class="nav-item">Profile</span>
                </a>
                <span class="tooltip">Profile</span>
            </li>
            <li>
                <a href="aboutus.php">
                    <i class="bx bxs-info-circle"></i>
                    <span class="nav-item">About</span>
                </a>
                <span class="tooltip">About</span>
            </li>
            <li>
                <a href="login.php">
                    <i class="bx bx-log-out"></i>
                    <span class="nav-item">Logout</span>
                </a>
                <span class="tooltip">Logout</span>
            </li>
        </ul>
    </div>

        
    </div>
    <!-- Content -->
    <div class="container">
        <div class="menu">
            <div class="menu-banner">
                <img src="pics/sample.jpg">
            </div>

            <h3 class="menu-title">What we Offer</h3>
            <div class="menu-category">
                <a href="?category=1">Kakanin Bilao</a>
                <a href="?category=2">Pancit Bilao</a>
                <a href="?category=3">Ulam Bilao</a>
                <a href="?category=all">All</a>
            </div>

            
            <div class="menu-content">
                <?php

                    include("connection.php");

                    if (isset($_SESSION['userinfo'])) {
                        $userinfo = $_SESSION['userinfo'];

                        // Determine the selected category
                        $category_filter = isset($_GET['category']) ? intval($_GET['category']) : null;
                        if (isset($_GET['category']) && $_GET['category'] === 'all') {
                            $category_filter = null;
                        }

                        // Query to get the price range for each food item
                        $sql = "
                            SELECT 
                                f.food_id,
                                f.Name,
                                f.Description,
                                f.Image,
                                MIN(fp.price) AS min_price,
                                MAX(fp.price) AS max_price
                            FROM 
                                food f
                            INNER JOIN 
                                food_size_pricing fp ON f.food_id = fp.food_id
                        ";

                        if ($category_filter) {
                            $sql .= " WHERE f.category_id = $category_filter";
                        }

                        $sql .= " GROUP BY f.food_id, f.Name, f.Description, f.Image";

                        $result = $conn->query($sql);

                        // Loop over the menu items and generate the HTML code
                        while ($row = $result->fetch_assoc()) {
                            $price_range = number_format($row['min_price'], 2) . " - " . number_format($row['max_price'], 2) . "₱";
                            ?>
                            <div class="menu-item" data-name="<?php echo $row['Name']; ?>" data-price="<?php echo $price_range; ?>" data-image="<?php echo $row['Image']; ?>" data-food-id="<?php echo $row['food_id']; ?>">
                                <img class="card-img" src="<?php echo $row['Image']; ?>">
                                <div class="card-detail">
                                    <h4>
                                        <?php echo $row['Name']; ?> 
                                        <span><?php echo $price_range; ?></span>
                                    </h4>
                                    <p><?php echo $row['Description']; ?></p>
                                </div>
                            </div>
                            <?php
                            // Save the menu item data to the session
                            $_SESSION['menu_items'][] = array(
                                'name' => $row['Name'],
                                'price_range' => $price_range,
                                'image' => $row['Image'],
                                'description' => $row['Description'],
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
                    <h2 class="size-name">Select a Size</h2>
                    <div class="size-options">
                        <!-- Dynamic Size Options will load here -->
                    </div>
                    <div class="date">
                        <h2 class="date-name">Select a Date</h2>
                        <input type="date" name="Date" id="prepDate" min="2024-01-01" max="2024-12-31" value="NOW">
                    </div>
                    <div class="date">
                        <h2 class="date-name">Quantity</h2>
                        <input type="number" id="quantity" value="1" min="1">
                    </div>
                    <button id="addToCartBtn">Add to Cart</button>
                </div>
            </div>
        </div>


    </div>
    <script src="js.js"></script>
</body>

<script>
    let btn = document.querySelector('#btn')
    let sidebar = document.querySelector('.sidebar')

    btn.onclick = function(){
        sidebar.classList.toggle('active')
    };
</script>

</html>