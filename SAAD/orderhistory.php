<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!-- Header -->

    <h3 class="logo">HUHUHUHUHU</h3>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-menu">
            <span class="fa fa-home"></span>
            <a href="#">Home</a>
        </div>
        <div class="sidebar-menu">
            <span class="fa fa-bars"></span>
            <a href="menu.php">Menu</a>
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
            <?php
                session_start();
                include('connection.php');
                // Retrieve the user's order history from the database
                $user_id = $_SESSION['userinfo']['user_id'];
                $sql = "SELECT oh.Total_Price, oh.order_status, cof.food_name, cof.quantity, cof.checked_out_at FROM order_history oh JOIN checked_out_foods cof ON oh.order_id = cof.checkout_id WHERE oh.user_id = '$user_id'";
                $result = $conn->query($sql);

                // Check if there are any orders
                if ($result->num_rows > 0) {
                    // Create the table header
                    echo '<table class="history-header">';
                    echo '<tr>';
                    echo '<th>Name</th>';
                    echo '<th>Date</th>';
                    echo '<th>Quantity</th>';
                    echo '<th>Total</th>';
                    echo '<th>Status</th>';
                    echo '</tr>';

                    // Loop through each order and display the data
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['food_name'] . '</td>';
                        echo '<td>' . $row['checked_out_at'] . '</td>';
                        echo '<td>' . $row['quantity'] . '</td>';
                        echo '<td>' . $row['Total_Price'] . '</td>';
                        echo '<td>' . $row['order_status'] . '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                } else {
                    echo 'No orders found.';
                }
                ?>
        </form>
    </div>
</body>
</html>