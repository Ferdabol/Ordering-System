<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/menu.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <!-- Header -->

    <h3 class="head-t">HUHUHUHUHU</h3>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="top">
            <div class="logo">
                <i class='bx bxl-codepen'></i>
                <span>HUHUHUHUHU</span>
            </div>
            <i class="bx bx-menu" id="btn"></i>
        </div>

        <div class="user">
            <div>
                <p class="bold">Ferd O.</p>
                <p>Admin</p>
            </div>
        </div>
        <ul>
            <li>
                <a href="#">
                    <i class="bx bxs-home"></i>
                    <span class="nav-item">Home</span>
                </a>
                <span class="tooltip">Home</span>
            </li>
            <li>
                <a href="menu.php">
                    <i class="bx bx-list-check"></i>
                    <span class="nav-item">Menu</span>
                </a>
                <span class="tooltip">Menu</span>
            </li>
            <li>
                <a href="profile.php">
                    <i class="bx bxs-shopping-bag"></i>
                    <span class="nav-item">Profile</span>
                </a>
                <span class="tooltip">Profile</span>
            </li>
            <li>
                <a href="#">
                    <i class="bx bxs-food-menu"></i>
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

    <!-- Profile Page -->
    <div class="profile-container">
        <div class="profile">
            <div class="profile-header">
                <img class="profile-img" src="sample.jpg">
                <div class="profile-text-container">
                    <h1 class="profile-tile">Ferdabol</h1>
                    <p class="profile-email">tae@gmail.com</p>
                </div>
            </div>

            <div class="account-info">               
                <a href="profile.php" class="account-link"><span class="fa solid fa-user account-icon"></span>Account</a>
                <a href="settings.php" class="account-link"><span class="fa solid fa-gear account-icon"></span>Settings</a>
                <a href="#" class="account-link"><span class="fa solid fa-bell account-icon"></span>Notification</a>
                <a href="orderhistory.php" class="account-link"><span class="fa solid fa-user account-icon"></span>Order History</a>
            </div>
        </div>

        <form class="account" method="post">
            <div class="account-header">
                <h1 class="account-title">Account Settings</h1>
            </div>
            <div class="history-container">
                <div class="history-box">
                    <?php
                    session_start();
                    include('connection.php');


                    $user_id = $_SESSION['userinfo']['user_id'];

                    $sql = "SELECT o.order_id, o.order_date, oi.quantity, f.Name, fs.price, s.size_name 
                            FROM orders o 
                            JOIN order_items oi ON o.order_id = oi.order_id 
                            JOIN food_size_pricing fs ON oi.pricing_id = fs.pricing_id 
                            JOIN food f ON fs.food_id = f.food_id 
                            JOIN size s ON fs.size_id = s.size_id 
                            WHERE o.user_id = '$user_id'";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Create the table header
                        echo '<table class="history-header">';
                        echo '<tr class="h-header">';
                        echo '<th>Order ID</th>';
                        echo '<th>Order Date</th>';
                        echo '<th>Quantity</th>';
                        echo '<th>Food Name</th>';
                        echo '<th>Price</th>';
                        echo '<th>Size</th>';
                        echo '</tr>';

                        // Loop through each order and display the data
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['order_id'] . '</td>';
                            echo '<td>' . $row['order_date'] . '</td>';
                            echo '<td>' . $row['quantity'] . '</td>';
                            echo '<td>' . $row['Name'] . '</td>';
                            echo '<td>' . $row['price'] . '</td>';
                            echo '<td>' . $row['size_name'] . '</td>';
                            echo '</tr>';
                        }

                        echo '</table>';
                    } else {
                        echo 'No orders found.';
                    }
                    ?>
                </div>
            </div>
        </form>
    </div>
</body>
<script>
    let btn = document.querySelector('#btn')
    let sidebar = document.querySelector('.sidebar')

    btn.onclick = function(){
        sidebar.classList.toggle('active')
    };
</script>
</html>